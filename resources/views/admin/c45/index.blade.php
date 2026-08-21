@extends('layouts.admin')

@section('title', 'Modul C4.5')
@section('page-title', 'Modul Analitik Algoritma C4.5')

@section('styles')
<style>
    .tree-box { background: #1e293b; color: #f8fafc; padding: 1.5rem; border-radius: 14px; font-family: monospace; font-size: 0.9rem; line-height: 1.8; }
    .tree-node { color: #38bdf8; font-weight: bold; }
    .tree-leaf-rendah { color: #4ade80; font-weight: bold; }
    .tree-leaf-sedang { color: #fbbf24; font-weight: bold; }
    .tree-leaf-tinggi { color: #f87171; font-weight: bold; }
</style>
@endsection

@section('content')
    <div class="card" style="margin-bottom: 1.25rem;">
        <div class="card-header">
            <span class="card-title">🌳 Modul Analitik Algoritma C4.5 (Decision Tree Classifier)</span>
        </div>
        <p style="font-size: 0.875rem; color: #64748b; margin-bottom: 1.5rem; line-height: 1.6;">
            Algoritma C4.5 secara dinamis mengukur nilai <strong>Entropy Total</strong>, <strong>Information Gain</strong>, dan <strong>Gain Ratio</strong> dari atribut dataset pelatihan untuk membentuk Aturan Pohon Keputusan klasifikasi risiko keselamatan BBS.
        </p>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.5rem;">
            <div style="background: #f8fafc; padding: 1.1rem; border-radius: 12px; border: 1px solid #e2e8f0;">
                <div style="font-size: 0.725rem; font-weight: 700; color: #64748b; text-transform: uppercase; margin-bottom: 0.35rem;">Total Dataset Training</div>
                <div style="font-size: 1.75rem; font-weight: 800; color: #0f172a;">{{ $c45Data['total'] }} Baris</div>
                <div style="font-size: 0.8rem; color: #475569; margin-top: 0.25rem;">
                    Rendah: {{ $c45Data['class_counts']['rendah'] }} | Sedang: {{ $c45Data['class_counts']['sedang'] }} | Tinggi: {{ $c45Data['class_counts']['tinggi'] }}
                </div>
            </div>
            <div style="background: #f8fafc; padding: 1.1rem; border-radius: 12px; border: 1px solid #e2e8f0;">
                <div style="font-size: 0.725rem; font-weight: 700; color: #64748b; text-transform: uppercase; margin-bottom: 0.35rem;">Entropy Total S</div>
                <div style="font-size: 1.75rem; font-weight: 800; color: #4f46e5;">{{ $c45Data['total_entropy'] }}</div>
                <div style="font-size: 0.8rem; color: #475569; margin-top: 0.25rem;">Tingkat ketidakpastian awal kelas target.</div>
            </div>
        </div>

        <div style="font-size: 0.95rem; font-weight: 700; color: #0f172a; margin-bottom: 0.875rem;">📊 Perhitungan Information Gain Atribut</div>
        <div class="table-wrap" style="margin-bottom: 1.5rem;">
            <table>
                <thead>
                    <tr>
                        <th>Atribut Evaluasi C4.5</th>
                        <th>Information Gain</th>
                        <th>Gain Ratio</th>
                        <th>Status Node</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($c45Data['attributes'] as $attr)
                        <tr>
                            <td><strong>{{ $attr['name'] }}</strong></td>
                            <td style="font-weight: 700; color: #2563eb;">{{ $attr['gain'] }}</td>
                            <td style="font-weight: 700; color: #7c3aed;">{{ $attr['gain_ratio'] }}</td>
                            <td>
                                @if($attr['gain'] > 0.3)
                                    <span class="badge badge-tinggi">Root Node</span>
                                @else
                                    <span class="badge badge-rendah">Branch</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div style="font-size: 0.95rem; font-weight: 700; color: #0f172a; margin-bottom: 0.875rem;">🌲 Visualisasi Aturan Pohon Keputusan</div>
        <div class="tree-box">
            <div>IF <span class="tree-node">Jenis Perilaku == 'Safe'</span> THEN <span class="tree-leaf-rendah">Tingkat Risiko: RENDAH</span></div>
            <div>IF <span class="tree-node">Jenis Perilaku == 'At-Risk'</span> THEN</div>
            <div style="padding-left: 1.5rem;">├─ IF <span class="tree-node">Kategori IN ('LOTO', 'Prosedur & PTW', 'Listrik', 'Tanggap Darurat')</span> THEN <span class="tree-leaf-tinggi">TINGGI</span></div>
            <div style="padding-left: 1.5rem;">├─ IF <span class="tree-node">Kategori IN ('APD', 'Posisi Ergonomi', 'Housekeeping', 'Mengemudi')</span> THEN <span class="tree-leaf-sedang">SEDANG</span></div>
            <div style="padding-left: 1.5rem;">└─ ELSE THEN <span class="tree-leaf-sedang">SEDANG</span></div>
        </div>
    </div>

    <!-- Training Dataset Table -->
    <div class="card">
        <div class="card-header">
            <span class="card-title">📋 Dataset Pelatihan C4.5 ({{ count($trainingList) }} Record)</span>
        </div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Jenis Perilaku</th>
                        <th>Kategori BBS</th>
                        <th>Lokasi Area</th>
                        <th>Potensi Bahaya</th>
                        <th>Kepatuhan SOP</th>
                        <th>Label Risiko</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($trainingList as $index => $train)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ strtoupper($train->jenis_perilaku) }}</td>
                            <td>{{ Str::limit($train->kategori->nama_kategori ?? '-', 25) }}</td>
                            <td>{{ Str::limit($train->lokasi->nama_lokasi ?? '-', 22) }}</td>
                            <td>{{ strtoupper($train->tingkat_potensi_bahaya) }}</td>
                            <td>{{ strtoupper($train->kepatuhan_prosedur) }}</td>
                            <td><span class="badge badge-{{ $train->tingkat_risiko }}">{{ strtoupper($train->tingkat_risiko) }}</span></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
