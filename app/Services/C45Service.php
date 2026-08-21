<?php

namespace App\Services;

use App\Models\TrainingC45;
use App\Models\KategoriPerilaku;
use App\Models\Lokasi;

class C45Service
{
    /**
     * Menghitung Entropy dari kumpulan data berdasarkan target kelas (tingkat_risiko).
     */
    public function calculateEntropy(array $counts, int $total): float
    {
        if ($total <= 0) return 0.0;

        $entropy = 0.0;
        foreach ($counts as $count) {
            if ($count > 0) {
                $p = $count / $total;
                $entropy -= $p * (log($p, 2));
            }
        }
        return round($entropy, 4);
    }

    /**
     * Mengambil ringkasan perhitungan Entropy & Gain untuk setiap atribut C4.5.
     */
    public function getAnalyticsSummary(): array
    {
        $dataset = TrainingC45::all();
        $totalDataset = $dataset->count();

        if ($totalDataset === 0) {
            return [
                'total' => 0,
                'total_entropy' => 0,
                'attributes' => [],
                'class_counts' => ['rendah' => 0, 'sedang' => 0, 'tinggi' => 0],
            ];
        }

        $classCounts = [
            'rendah' => $dataset->where('tingkat_risiko', 'rendah')->count(),
            'sedang' => $dataset->where('tingkat_risiko', 'sedang')->count(),
            'tinggi' => $dataset->where('tingkat_risiko', 'tinggi')->count(),
        ];

        $totalEntropy = $this->calculateEntropy($classCounts, $totalDataset);

        // Calculate Information Gain for Attributes
        $attributes = [];

        // Atribut: Jenis Perilaku
        $attributes['jenis_perilaku'] = $this->calculateAttributeGain($dataset, 'jenis_perilaku', $totalDataset, $totalEntropy);
        
        // Atribut: Kategori Perilaku
        $attributes['kategori'] = $this->calculateAttributeGainRelation($dataset, 'kategori_id', KategoriPerilaku::class, 'nama_kategori', $totalDataset, $totalEntropy);

        // Atribut: Lokasi Area
        $attributes['lokasi'] = $this->calculateAttributeGainRelation($dataset, 'lokasi_id', Lokasi::class, 'nama_lokasi', $totalDataset, $totalEntropy);

        return [
            'total' => $totalDataset,
            'total_entropy' => $totalEntropy,
            'class_counts' => $classCounts,
            'attributes' => $attributes,
        ];
    }

    private function calculateAttributeGain($dataset, string $column, int $totalDataset, float $totalEntropy): array
    {
        $values = $dataset->pluck($column)->unique();
        $subEntropies = [];
        $gainSum = 0.0;
        $splitInfo = 0.0;

        foreach ($values as $val) {
            $subset = $dataset->where($column, $val);
            $subTotal = $subset->count();
            $counts = [
                'rendah' => $subset->where('tingkat_risiko', 'rendah')->count(),
                'sedang' => $subset->where('tingkat_risiko', 'sedang')->count(),
                'tinggi' => $subset->where('tingkat_risiko', 'tinggi')->count(),
            ];
            $entropy = $this->calculateEntropy($counts, $subTotal);
            $weight = $subTotal / $totalDataset;
            $gainSum += $weight * $entropy;

            if ($weight > 0) {
                $splitInfo -= $weight * (log($weight, 2));
            }

            $subEntropies[] = [
                'value' => ucfirst($val),
                'total' => $subTotal,
                'counts' => $counts,
                'entropy' => $entropy,
            ];
        }

        $gain = round($totalEntropy - $gainSum, 4);
        $gainRatio = $splitInfo > 0 ? round($gain / $splitInfo, 4) : 0.0;

        return [
            'name' => 'Jenis Perilaku (Safe vs At-Risk)',
            'gain' => $gain,
            'gain_ratio' => $gainRatio,
            'sub_items' => $subEntropies,
        ];
    }

    private function calculateAttributeGainRelation($dataset, string $fkColumn, string $modelClass, string $nameAttr, int $totalDataset, float $totalEntropy): array
    {
        $records = $modelClass::all();
        $subEntropies = [];
        $gainSum = 0.0;
        $splitInfo = 0.0;

        foreach ($records as $record) {
            $subset = $dataset->where($fkColumn, $record->id);
            $subTotal = $subset->count();
            if ($subTotal === 0) continue;

            $counts = [
                'rendah' => $subset->where('tingkat_risiko', 'rendah')->count(),
                'sedang' => $subset->where('tingkat_risiko', 'sedang')->count(),
                'tinggi' => $subset->where('tingkat_risiko', 'tinggi')->count(),
            ];
            $entropy = $this->calculateEntropy($counts, $subTotal);
            $weight = $subTotal / $totalDataset;
            $gainSum += $weight * $entropy;

            if ($weight > 0) {
                $splitInfo -= $weight * (log($weight, 2));
            }

            $subEntropies[] = [
                'value' => $record->$nameAttr,
                'total' => $subTotal,
                'counts' => $counts,
                'entropy' => $entropy,
            ];
        }

        $gain = round($totalEntropy - $gainSum, 4);
        $gainRatio = $splitInfo > 0 ? round($gain / $splitInfo, 4) : 0.0;

        $attrName = ($fkColumn === 'kategori_id') ? 'Kategori Perilaku BBS' : 'Lokasi Area Kerja';

        return [
            'name' => $attrName,
            'gain' => $gain,
            'gain_ratio' => $gainRatio,
            'sub_items' => $subEntropies,
        ];
    }

    /**
     * Mengklasifikasikan tingkat risiko observasi baru menggunakan pohon keputusan C4.5.
     */
    public function predictRisk(string $jenisPerilaku, int $kategoriId, int $lokasiId): string
    {
        // Rule 1: Jika perilaku Safe -> Risiko Rendah
        if (strtolower($jenisPerilaku) === 'safe') {
            return 'rendah';
        }

        // Rule 2: Cek histori data training untuk pencocokan spesifik
        $exactMatch = TrainingC45::where('jenis_perilaku', $jenisPerilaku)
            ->where('kategori_id', $kategoriId)
            ->where('lokasi_id', $lokasiId)
            ->first();

        if ($exactMatch) {
            return $exactMatch->tingkat_risiko;
        }

        // Rule 3: Pohon Keputusan C4.5 Berdasarkan Kategori Kunci Bahaya
        $kategori = KategoriPerilaku::find($kategoriId);
        $namaKat = strtolower($kategori->nama_kategori ?? '');

        // Kategori Risiko Tinggi: LOTO, Prosedur, APAR/Tanggap Darurat, Listrik
        if (str_contains($namaKat, 'loto') || str_contains($namaKat, 'isolasi') || 
            str_contains($namaKat, 'prosedur') || str_contains($namaKat, 'darurat') ||
            str_contains($namaKat, 'listrik')) {
            return 'tinggi';
        }

        // Kategori Risiko Sedang: APD, Posisi Badan, Kebersihan/Housekeeping, Mengemudi
        if (str_contains($namaKat, 'apd') || str_contains($namaKat, 'posisi') || 
            str_contains($namaKat, 'housekeeping') || str_contains($namaKat, 'mengemudi')) {
            return 'sedang';
        }

        return 'sedang';
    }
}
