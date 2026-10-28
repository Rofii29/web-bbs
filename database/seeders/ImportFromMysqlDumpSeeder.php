<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Import data dari file bbs (3).sql (MySQL dump) ke database Neon PostgreSQL.
 * Menggunakan upsert agar tidak ada data duplikat.
 * 
 */
class ImportFromMysqlDumpSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info("=== Import Data dari MySQL Dump ke Neon PostgreSQL ===");

        DB::statement("SET session_replication_role = replica;");

        $this->importKategoriPerilaku();
        $this->importLokasi();
        $this->importUsers();
        $this->importTrainingC45();
        $this->importObservasiBbs();

        DB::statement("SET session_replication_role = DEFAULT;");

        $this->command->info("=== Import selesai! ===");
    }

    private function importKategoriPerilaku(): void
    {
        $this->command->info("Importing kategori_perilaku...");
        $data = [
            ["id" => 1,  "nama_kategori" => "Alat Pelindung Diri (APD)",              "deskripsi" => "Kepatuhan penggunaan helm, kacamata, sarung tangan, sepatu safety, dan pelindung telinga.",                                   "created_at" => "2026-08-21 00:28:20", "updated_at" => "2026-08-21 00:28:20"],
            ["id" => 2,  "nama_kategori" => "Posisi & Ergonomi Badan",                "deskripsi" => "Postur kerja, posisi mengangkat benda berat, titik jepit (pinch point), dan posisi terhindar bahaya.",                     "created_at" => "2026-08-21 00:28:20", "updated_at" => "2026-08-21 00:28:20"],
            ["id" => 3,  "nama_kategori" => "Alat & Perkakas Kerja",                  "deskripsi" => "Kelayakan alat kerja tangan, perkakas listrik, inspeksi tag, dan penggunaan alat tepat guna.",                              "created_at" => "2026-08-21 00:28:20", "updated_at" => "2026-08-21 00:28:20"],
            ["id" => 4,  "nama_kategori" => "Prosedur & Izin Kerja (JSA/PTW)",        "deskripsi" => "Penerapan izin kerja khusus (Hot Work, Confined Space), ketersediaan JSA, dan SOP.",                                       "created_at" => "2026-08-21 00:28:20", "updated_at" => "2026-08-21 00:28:20"],
            ["id" => 5,  "nama_kategori" => "Mengemudi & Transportasi",               "deskripsi" => "Penggunaan sabuk pengaman, batas kecepatan di area plant, inspeksi kendaraan harian.",                                      "created_at" => "2026-08-21 00:28:21", "updated_at" => "2026-08-21 00:28:21"],
            ["id" => 6,  "nama_kategori" => "Kerapihan & Kebersihan (Housekeeping)",  "deskripsi" => "Penataan material, area jalan bebas hambatan, penanganan ceceran minyak/kimia.",                                           "created_at" => "2026-08-21 00:28:21", "updated_at" => "2026-08-21 00:28:21"],
            ["id" => 7,  "nama_kategori" => "Peralatan Listrik & Mekanikal",          "deskripsi" => "Pengamanan kabel terkelupas, grounding, penutup panel listrik, dan guard mesin berputar.",                                  "created_at" => "2026-08-21 00:28:21", "updated_at" => "2026-08-21 00:28:21"],
            ["id" => 8,  "nama_kategori" => "Isolasi Energi (LOTO / Lockout Tagout)", "deskripsi" => "Pemasangan gembok dan tag isolasi sumber energi saat perawatan atau perbaikan mesin.",                                     "created_at" => "2026-08-21 00:28:21", "updated_at" => "2026-08-21 00:28:21"],
            ["id" => 9,  "nama_kategori" => "Bahan Berbahaya & Beracun (B3)",         "deskripsi" => "Penyimpanan kimia berlabel, penyediaan MSDS/LDKB, dan penampungan ceceran (spill kit).",                                    "created_at" => "2026-08-21 00:28:21", "updated_at" => "2026-08-21 00:28:21"],
            ["id" => 10, "nama_kategori" => "Tanggap Darurat & Kesiapsiagaan",        "deskripsi" => "Keterjangkauan APAR, akses jalur evakuasi, eyewash station, dan kesiapan kotak P3K.",                                      "created_at" => "2026-08-21 00:28:22", "updated_at" => "2026-08-21 00:28:22"],
        ];
        DB::table("kategori_perilaku")->upsert($data, ["id"], ["nama_kategori", "deskripsi", "updated_at"]);
        DB::statement("SELECT setval(\"kategori_perilaku_id_seq\", (SELECT MAX(id) FROM kategori_perilaku))");
        $this->command->info("  -> kategori_perilaku: " . count($data) . " baris.");
    }

    private function importLokasi(): void
    {
        $this->command->info("Importing lokasi...");
        $data = [
            ["id" => 1,  "nama_lokasi" => "Workshop Utama (Main Plant)",               "area" => "Zona 1",               "created_at" => "2026-08-21 00:28:22", "updated_at" => "2026-08-21 00:28:22"],
            ["id" => 2,  "nama_lokasi" => "Gudang Material & Logistik",               "area" => "Zona 2",               "created_at" => "2026-08-21 00:28:22", "updated_at" => "2026-08-21 00:28:22"],
            ["id" => 3,  "nama_lokasi" => "Area Process & Tank Farm",                 "area" => "Zona 3",               "created_at" => "2026-08-21 00:28:22", "updated_at" => "2026-08-21 00:28:22"],
            ["id" => 4,  "nama_lokasi" => "Laboratorium Pengujian & Quality Control", "area" => "Zona 4",               "created_at" => "2026-08-21 00:28:22", "updated_at" => "2026-08-21 00:28:22"],
            ["id" => 5,  "nama_lokasi" => "Gedung Administrasi & Kantor Utama",       "area" => "Zona 5",               "created_at" => "2026-08-21 00:28:22", "updated_at" => "2026-08-21 00:28:22"],
            ["id" => 6,  "nama_lokasi" => "Wellpad",                                  "area" => "Operasional Lapangan", "created_at" => "2026-08-21 01:07:10", "updated_at" => "2026-08-21 01:07:10"],
            ["id" => 7,  "nama_lokasi" => "RIG ACS 14 LOKASI5R.82P",                 "area" => "Operasional Lapangan", "created_at" => "2026-10-03 03:12:17", "updated_at" => "2026-10-03 03:12:17"],
            ["id" => 8,  "nama_lokasi" => "OMO",                                      "area" => "Operasional Lapangan", "created_at" => "2026-10-04 02:00:33", "updated_at" => "2026-10-04 02:00:33"],
            ["id" => 9,  "nama_lokasi" => "BANGKO",                                   "area" => "PT CEP-SMI",           "created_at" => "2026-10-04 02:36:59", "updated_at" => "2026-10-04 02:36:59"],
            ["id" => 10, "nama_lokasi" => "KOTA BATAK",                               "area" => "PT CEP-SMI",           "created_at" => "2026-10-04 02:36:59", "updated_at" => "2026-10-04 02:36:59"],
            ["id" => 11, "nama_lokasi" => "WEHOUSE",                                  "area" => "PT CEP-SMI",           "created_at" => "2026-10-04 02:36:59", "updated_at" => "2026-10-04 02:36:59"],
            ["id" => 12, "nama_lokasi" => "RIG AU17 LOKASI 3N21A",                   "area" => "PT CEP-SMI",           "created_at" => "2026-10-04 02:36:59", "updated_at" => "2026-10-04 02:36:59"],
            ["id" => 13, "nama_lokasi" => "MINAS",                                    "area" => "PT CEP-SMI",           "created_at" => "2026-10-04 02:36:59", "updated_at" => "2026-10-04 02:36:59"],
            ["id" => 14, "nama_lokasi" => "PETAPAHAN",                                "area" => "PT CEP-SMI",           "created_at" => "2026-10-04 02:36:59", "updated_at" => "2026-10-04 02:36:59"],
            ["id" => 15, "nama_lokasi" => "Yard WDR",                                 "area" => "PT CEP-SMI",           "created_at" => "2026-10-04 02:36:59", "updated_at" => "2026-10-04 02:36:59"],
            ["id" => 16, "nama_lokasi" => "RIG BMS19 LOKASI7M-69C",                  "area" => "PT CEP-SMI",           "created_at" => "2026-10-04 02:36:59", "updated_at" => "2026-10-04 02:36:59"],
            ["id" => 17, "nama_lokasi" => "BAUNG",                                    "area" => "PT CEP-SMI",           "created_at" => "2026-10-04 02:36:59", "updated_at" => "2026-10-04 02:36:59"],
            ["id" => 18, "nama_lokasi" => "RIG IDB 08 LOKASI5F1013B",                "area" => "PT CEP-SMI",           "created_at" => "2026-10-04 02:36:59", "updated_at" => "2026-10-04 02:36:59"],
            ["id" => 19, "nama_lokasi" => "RIG BMS 09 LOKASI4Q17AA",                 "area" => "PT CEP-SMI",           "created_at" => "2026-10-04 02:36:59", "updated_at" => "2026-10-04 02:36:59"],
            ["id" => 20, "nama_lokasi" => "RIG ACS 11 LOKASI2P24B",                  "area" => "PT CEP-SMI",           "created_at" => "2026-10-04 02:36:59", "updated_at" => "2026-10-04 02:36:59"],
        ];
        DB::table("lokasi")->upsert($data, ["id"], ["nama_lokasi", "area", "updated_at"]);
        DB::statement("SELECT setval(\"lokasi_id_seq\", (SELECT MAX(id) FROM lokasi))");
        $this->command->info("  -> lokasi: " . count($data) . " baris.");
    }

    private function importTrainingC45(): void
    {
        $this->command->info("Importing training_c45...");
        $data = [
            ["id" => 1,  "jenis_perilaku" => "safe",    "kategori_id" => 1, "lokasi_id" => 1, "tingkat_potensi_bahaya" => "rendah", "kepatuhan_prosedur" => "patuh",    "tingkat_risiko" => "rendah", "created_at" => "2026-08-21 00:28:23", "updated_at" => "2026-08-21 00:28:23"],
            ["id" => 2,  "jenis_perilaku" => "safe",    "kategori_id" => 6, "lokasi_id" => 2, "tingkat_potensi_bahaya" => "rendah", "kepatuhan_prosedur" => "patuh",    "tingkat_risiko" => "rendah", "created_at" => "2026-08-21 00:28:23", "updated_at" => "2026-08-21 00:28:23"],
            ["id" => 3,  "jenis_perilaku" => "safe",    "kategori_id" => 2, "lokasi_id" => 1, "tingkat_potensi_bahaya" => "sedang", "kepatuhan_prosedur" => "patuh",    "tingkat_risiko" => "rendah", "created_at" => "2026-08-21 00:28:23", "updated_at" => "2026-08-21 00:28:23"],
            ["id" => 4,  "jenis_perilaku" => "safe",    "kategori_id" => 4, "lokasi_id" => 3, "tingkat_potensi_bahaya" => "sedang", "kepatuhan_prosedur" => "patuh",    "tingkat_risiko" => "rendah", "created_at" => "2026-08-21 00:28:23", "updated_at" => "2026-08-21 00:28:23"],
            ["id" => 5,  "jenis_perilaku" => "at_risk", "kategori_id" => 6, "lokasi_id" => 2, "tingkat_potensi_bahaya" => "sedang", "kepatuhan_prosedur" => "melanggar","tingkat_risiko" => "sedang", "created_at" => "2026-08-21 00:28:23", "updated_at" => "2026-08-21 00:28:23"],
            ["id" => 6,  "jenis_perilaku" => "at_risk", "kategori_id" => 1, "lokasi_id" => 1, "tingkat_potensi_bahaya" => "sedang", "kepatuhan_prosedur" => "melanggar","tingkat_risiko" => "sedang", "created_at" => "2026-08-21 00:28:24", "updated_at" => "2026-08-21 00:28:24"],
            ["id" => 7,  "jenis_perilaku" => "at_risk", "kategori_id" => 2, "lokasi_id" => 3, "tingkat_potensi_bahaya" => "sedang", "kepatuhan_prosedur" => "melanggar","tingkat_risiko" => "sedang", "created_at" => "2026-08-21 00:28:24", "updated_at" => "2026-08-21 00:28:24"],
            ["id" => 8,  "jenis_perilaku" => "at_risk", "kategori_id" => 8, "lokasi_id" => 3, "tingkat_potensi_bahaya" => "tinggi", "kepatuhan_prosedur" => "melanggar","tingkat_risiko" => "tinggi", "created_at" => "2026-08-21 00:28:24", "updated_at" => "2026-08-21 00:28:24"],
            ["id" => 9,  "jenis_perilaku" => "at_risk", "kategori_id" => 4, "lokasi_id" => 3, "tingkat_potensi_bahaya" => "tinggi", "kepatuhan_prosedur" => "melanggar","tingkat_risiko" => "tinggi", "created_at" => "2026-08-21 00:28:24", "updated_at" => "2026-08-21 00:28:24"],
            ["id" => 10, "jenis_perilaku" => "at_risk", "kategori_id" => 8, "lokasi_id" => 1, "tingkat_potensi_bahaya" => "tinggi", "kepatuhan_prosedur" => "melanggar","tingkat_risiko" => "tinggi", "created_at" => "2026-08-21 00:28:24", "updated_at" => "2026-08-21 00:28:24"],
            ["id" => 11, "jenis_perilaku" => "at_risk", "kategori_id" => 1, "lokasi_id" => 3, "tingkat_potensi_bahaya" => "tinggi", "kepatuhan_prosedur" => "melanggar","tingkat_risiko" => "tinggi", "created_at" => "2026-08-21 00:28:25", "updated_at" => "2026-08-21 00:28:25"],
        ];
        DB::table("training_c45")->upsert($data, ["id"], ["jenis_perilaku", "tingkat_risiko", "updated_at"]);
        DB::statement("SELECT setval(\"training_c45_id_seq\", (SELECT MAX(id) FROM training_c45))");
        $this->command->info("  -> training_c45: " . count($data) . " baris.");
    }

    private function importUsers(): void
    {
        $this->command->info("Importing users dari file SQL...");

        $sqlFile = base_path("bbs (3).sql");
        if (!file_exists($sqlFile)) {
            $this->command->error("File bbs (3).sql tidak ditemukan di: " . base_path());
            return;
        }

        $content = file_get_contents($sqlFile);

        // Cari semua blok INSERT INTO `users`
        preg_match_all('/INSERT INTO `users`[^;]+;/s', $content, $matches);
        if (empty($matches[0])) {
            $this->command->warn("Tidak ada INSERT users ditemukan.");
            return;
        }

        $total = 0;
        foreach ($matches[0] as $block) {
            // Ambil semua value baris per baris
            preg_match_all('/\((\d+),\s*(\'[^\']*\'|NULL),\s*(\'[^\']*\'|NULL),\s*(\'[^\']*\'|NULL),\s*(\'[^\']*\'|NULL),\s*(\'[^\']*\'|NULL),\s*(\'[^\']*\'|NULL),\s*(\'[^\']*\'|NULL),\s*(\'[^\']*\'|NULL),\s*(\'[^\']*\'|NULL),\s*(\'[^\']*\'|NULL),\s*(\'[^\']*\'|NULL),\s*(\'[^\']*\'|NULL),\s*(\'[^\']*\'|NULL)\)/', $block, $rows, PREG_SET_ORDER);

            foreach ($rows as $r) {
                $strip = fn($v) => $v === "NULL" ? null : trim($v, "'");
                try {
                    DB::table("users")->upsert([[
                        "id"               => (int) $r[1],
                        "name"             => $strip($r[2]),
                        "email"            => $strip($r[3]),
                        "email_verified_at"=> $strip($r[4]),
                        "password"         => $strip($r[5]),
                        "role"             => $strip($r[6]),
                        "no_hp"            => $strip($r[7]),
                        "jabatan"          => $strip($r[8]),
                        "unit_departemen"  => $strip($r[9]),
                        "no_batch"         => $strip($r[10]),
                        "status"           => $strip($r[11]),
                        "remember_token"   => $strip($r[12]),
                        "created_at"       => $strip($r[13]),
                        "updated_at"       => $strip($r[14]),
                    ]], ["id"], ["name","email","role","no_hp","jabatan","unit_departemen","no_batch","status","updated_at"]);
                    $total++;
                } catch (\Throwable $e) {
                    $this->command->warn("  Skip user id={$r[1]}: " . $e->getMessage());
                }
            }
        }
        DB::statement("SELECT setval(\"users_id_seq\", (SELECT MAX(id) FROM users))");
        $this->command->info("  -> users: {$total} baris di-upsert.");
    }

    private function importObservasiBbs(): void
    {
        $this->command->info("Importing observasi_bbs dari file SQL...");

        $sqlFile = base_path("bbs (3).sql");
        if (!file_exists($sqlFile)) {
            $this->command->error("File bbs (3).sql tidak ditemukan.");
            return;
        }

        $content = file_get_contents($sqlFile);
        preg_match_all('/INSERT INTO `observasi_bbs`[^;]+;/s', $content, $matches);

        if (empty($matches[0])) {
            $this->command->warn("Tidak ada INSERT observasi_bbs ditemukan.");
            return;
        }

        $total = 0;
        foreach ($matches[0] as $block) {
            // Pisahkan value per baris dengan pendekatan sederhana
            // Ambil semua yang ada di antara VALUES dan akhir blok
            $block = preg_replace('/INSERT INTO `observasi_bbs`[^V]*VALUES\s*/s', '', $block);
            $block = rtrim($block, ';');

            // Split per record - pisahkan berdasarkan ),( tapi hati-hati dengan nilai di dalam
            // Gunakan pendekatan baris demi baris dari SQL original
            $lines = preg_split('/\),\s*\n\(/', $block);

            foreach ($lines as $line) {
                $line = ltrim($line, '(');
                $line = rtrim($line, ')');

                // Parse dengan regex yang lebih sederhana - ambil field satu per satu
                // Format: id, tanggal, user_id, lokasi_id, unit_departemen, jenis_perilaku, rekomendasi_perilaku, kategori_id, item_states, observasi_lainnya, source_ref, ketika, ditemukan, sebab, saran, tingkat_risiko, rekomendasi_risiko, risiko_hes, risiko_hes_oleh, risiko_hes_pada, keputusan_hes_id, status_tindak_lanjut, catatan_tindak_lanjut, created_at, updated_at
                if (!preg_match('/^(\d+),\s*\'(\d{4}-\d{2}-\d{2})\',\s*(\d+),\s*(\d+),/s', $line, $head)) {
                    continue;
                }

                $id = (int) $head[1];
                $tanggal = $head[2];
                $userId = (int) $head[3];
                $lokasiId = (int) $head[4];

                // Extract source_ref karena itu unique
                if (!preg_match("/'(CEP-SMI-[^']+)'/", $line, $srcMatch)) {
                    continue;
                }
                $sourceRef = $srcMatch[1];

                // Extract jenis_perilaku
                preg_match("/'(safe|at_risk)'/", $line, $jpMatch);
                $jenisPer = $jpMatch[1] ?? "safe";

                // Extract tingkat_risiko
                preg_match("/'(rendah|sedang|tinggi)'.*'(rendah|sedang|tinggi)'/s", $line, $trMatch);
                $tingkatRisiko = $trMatch[1] ?? "rendah";
                $risikoHes = $trMatch[2] ?? "rendah";

                // Extract kategori_id (angka setelah ke-4 koma)
                preg_match('/^\d+,\s*\'\d{4}-\d{2}-\d{2}\',\s*\d+,\s*\d+,\s*\'[^\']+\',\s*\'[^\']+\',\s*(?:NULL|\'[^\']*\'),\s*(\d+)/s', $line, $katMatch);
                $kategoriId = isset($katMatch[1]) ? (int) $katMatch[1] : 1;

                // Extract status_tindak_lanjut
                preg_match("/'(open|closed|in_progress)'/", $line, $statusMatch);
                $status = $statusMatch[1] ?? "open";

                // Extract timestamps di akhir
                preg_match_all("/'(\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2})'/", $line, $tsMatches);
                $timestamps = $tsMatches[1] ?? [];
                $createdAt = $timestamps[count($timestamps) - 2] ?? now()->toDateTimeString();
                $updatedAt = $timestamps[count($timestamps) - 1] ?? now()->toDateTimeString();

                // Extract item_states JSON
                preg_match('/(\{[^}]+\})/', $line, $itemMatch);
                $itemStates = isset($itemMatch[1]) ? stripslashes($itemMatch[1]) : null;

                try {
                    DB::table("observasi_bbs")->upsert([[
                        "id"                    => $id,
                        "tanggal"               => $tanggal,
                        "user_id"               => $userId,
                        "lokasi_id"             => $lokasiId,
                        "unit_departemen"       => null,
                        "jenis_perilaku"        => $jenisPer,
                        "rekomendasi_perilaku"  => null,
                        "kategori_id"           => $kategoriId,
                        "item_states"           => $itemStates,
                        "observasi_lainnya"     => null,
                        "source_ref"            => $sourceRef,
                        "ketika"                => null,
                        "ditemukan"             => null,
                        "sebab"                 => null,
                        "saran"                 => null,
                        "tingkat_risiko"        => $tingkatRisiko,
                        "rekomendasi_risiko"    => null,
                        "risiko_hes"            => $risikoHes,
                        "risiko_hes_oleh"       => null,
                        "risiko_hes_pada"       => null,
                        "keputusan_hes_id"      => null,
                        "status_tindak_lanjut"  => $status,
                        "catatan_tindak_lanjut" => null,
                        "created_at"            => $createdAt,
                        "updated_at"            => $updatedAt,
                    ]], ["id"], ["tanggal","jenis_perilaku","tingkat_risiko","status_tindak_lanjut","updated_at"]);
                    $total++;
                } catch (\Throwable $e) {
                    $this->command->warn("  Skip observasi id={$id}: " . $e->getMessage());
                }
            }
        }

        DB::statement("SELECT setval(\"observasi_bbs_id_seq\", (SELECT MAX(id) FROM observasi_bbs))");
        $this->command->info("  -> observasi_bbs: {$total} baris di-upsert.");
    }
}
