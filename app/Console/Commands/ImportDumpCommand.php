<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportDumpCommand extends Command
{
    protected $signature = 'db:import-dump {file=bbs (3).sql}';
    protected $description = 'Import MySQL dump data into Neon PostgreSQL database cleanly using upsert';

    private $db;

    public function handle(): int
    {
        $fileName = $this->argument('file');
        $filePath = base_path($fileName);

        if (!file_exists($filePath)) {
            $this->error("File tidak ditemukan: {$filePath}");
            return Command::FAILURE;
        }

        // Ambil connection string Neon
        $neonUrl = env('DB_URL');
        if (!$neonUrl && file_exists(base_path('.env.vercel'))) {
            $lines = file(base_path('.env.vercel'), FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            foreach ($lines as $line) {
                if (str_starts_with(trim($line), 'DB_URL=')) {
                    $neonUrl = trim(substr(trim($line), 7), " \"'");
                    break;
                }
            }
        }

        if (!$neonUrl) {
            $this->error("DB_URL untuk Neon tidak ditemukan di .env atau .env.vercel!");
            return Command::FAILURE;
        }

        $this->info("Menghubungkan ke Neon PostgreSQL...");
        config([
            'database.connections.neon_target' => [
                'driver' => 'pgsql',
                'url' => $neonUrl,
                'charset' => 'utf8',
                'prefix' => '',
                'search_path' => 'public',
                'sslmode' => 'require',
            ]
        ]);

        $this->db = DB::connection('neon_target');

        $this->info("Membaca file dump: {$fileName}...");
        $sql = file_get_contents($filePath);

        $tablesOrder = [
            'kategori_perilaku',
            'lokasi',
            'users',
            'training_c45',
            'observasi_bbs',
        ];

        foreach ($tablesOrder as $table) {
            $this->importTable($table, $sql);
        }

        $this->newLine();
        $this->info("Semua data berhasil di-import ke Neon PostgreSQL!");
        return Command::SUCCESS;
    }

    private function importTable(string $table, string $sql): void
    {
        $pattern = '/INSERT\s+INTO\s+`' . preg_quote($table, '/') . '`\s*\(([^)]+)\)\s*VALUES\s*(.+?);(?=\s*(?:INSERT|CREATE|ALTER|DROP|\/\*|--|$))/s';
        
        if (!preg_match_all($pattern, $sql, $matches, PREG_SET_ORDER)) {
            $this->warn("Tabel {$table}: Tidak ada data INSERT ditemukan.");
            return;
        }

        $this->info("Memproses tabel {$table}...");
        $totalImported = 0;

        foreach ($matches as $match) {
            $rawColumns = $match[1];
            $rawValues = $match[2];

            $columns = array_map(function ($col) {
                return trim($col, " `\t\n\r\0\x0B");
            }, explode(',', $rawColumns));

            $rows = $this->parseValues($rawValues);

            $batch = [];
            foreach ($rows as $rowValues) {
                if (count($rowValues) !== count($columns)) {
                    continue;
                }
                $record = array_combine($columns, $rowValues);
                $batch[] = $record;

                if (count($batch) >= 100) {
                    $this->upsertBatch($table, $columns, $batch);
                    $totalImported += count($batch);
                    $batch = [];
                }
            }

            if (!empty($batch)) {
                $this->upsertBatch($table, $columns, $batch);
                $totalImported += count($batch);
            }
        }

        $this->resetSequence($table);
        $this->line("  -> Selesai {$table}: {$totalImported} baris di-upsert.");
    }

    private function parseValues(string $raw): array
    {
        $rows = [];
        $len = strlen($raw);
        $i = 0;

        while ($i < $len) {
            // Cari pembuka row '('
            while ($i < $len && $raw[$i] !== '(') {
                $i++;
            }
            if ($i >= $len) {
                break;
            }
            $i++; // lewati '('

            $currentRow = [];
            $currentVal = '';
            $inString = false;
            $isEscaped = false;
            $isNull = false;

            while ($i < $len) {
                $ch = $raw[$i];

                if ($inString) {
                    if ($isEscaped) {
                        if ($ch === 'n') {
                            $currentVal .= "\n";
                        } elseif ($ch === 'r') {
                            $currentVal .= "\r";
                        } elseif ($ch === 't') {
                            $currentVal .= "\t";
                        } else {
                            $currentVal .= $ch;
                        }
                        $isEscaped = false;
                    } elseif ($ch === '\\') {
                        $isEscaped = true;
                    } elseif ($ch === "'") {
                        // Cek apakah ada '' (escaped single quote SQL)
                        if ($i + 1 < $len && $raw[$i + 1] === "'") {
                            $currentVal .= "'";
                            $i++;
                        } else {
                            $inString = false;
                        }
                    } else {
                        $currentVal .= $ch;
                    }
                } else {
                    if ($ch === "'") {
                        $inString = true;
                        $currentVal = '';
                    } elseif ($ch === ',' || $ch === ')') {
                        $trimmed = trim($currentVal);
                        if (strtoupper($trimmed) === 'NULL') {
                            $currentRow[] = null;
                        } elseif (is_numeric($trimmed) && !str_starts_with($trimmed, '+')) {
                            $currentRow[] = str_contains($trimmed, '.') ? (float) $trimmed : (int) $trimmed;
                        } else {
                            $currentRow[] = $currentVal === '' && $trimmed !== '' ? $trimmed : $currentVal;
                        }

                        $currentVal = '';

                        if ($ch === ')') {
                            $i++;
                            $rows[] = $currentRow;
                            break;
                        }
                    } else {
                        $currentVal .= $ch;
                    }
                }
                $i++;
            }
        }

        return $rows;
    }

    private function upsertBatch(string $table, array $columns, array $batch): void
    {
        $updateColumns = array_values(array_filter($columns, fn($col) => $col !== 'id'));
        $this->db->table($table)->upsert($batch, ['id'], $updateColumns);
    }

    private function resetSequence(string $table): void
    {
        try {
            $this->db->statement("SELECT setval(pg_get_serial_sequence('{$table}', 'id'), COALESCE((SELECT MAX(id) FROM \"{$table}\"), 1))");
        } catch (\Throwable $e) {
            // Abaikan jika sequence tidak ada
        }
    }
}
