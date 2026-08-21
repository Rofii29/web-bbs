@extends('layouts.karyawan')

@section('title', 'Dashboard Saya')
@section('page-title', 'Dashboard Karyawan')

@section('content')
    <!-- Welcome Banner -->
    <div style="background: linear-gradient(135deg, #0284c7, #2563eb); border-radius: 18px; padding: 1.75rem 2rem; color: #fff; margin-bottom: 1.75rem; box-shadow: 0 10px 25px -5px rgba(2,132,199,0.3); display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h1 style="font-size: 1.4rem; font-weight: 800; margin-bottom: 0.35rem;">Selamat Datang, {{ Auth::user()->name }}! 👋</h1>
            <p style="color: rgba(255,255,255,0.85); font-size: 0.875rem;">{{ Auth::user()->jabatan ?? 'Karyawan' }} · {{ Auth::user()->unit_departemen ?? '-' }}</p>
        </div>
        <a href="{{ route('karyawan.observasi.create') }}" style="background: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.25); color: #fff; padding: 0.625rem 1.25rem; border-radius: 10px; font-weight: 700; font-size: 0.875rem; text-decoration: none; backdrop-filter: blur(4px);">+ Input Observasi Baru</a>
    </div>

    <!-- Stats -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon" style="background: #e0f2fe; color: #0284c7;">📋</div>
            <div>
                <div style="font-size: 1.6rem; font-weight: 800;">{{ $totalObservasi }}</div>
                <div style="font-size: 0.8rem; color: #64748b;">Total Observasi Saya</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background: #dcfce7; color: #16a34a;">✅</div>
            <div>
                <div style="font-size: 1.6rem; font-weight: 800;">{{ $safeCount }}</div>
                <div style="font-size: 0.8rem; color: #64748b;">Perilaku Safe</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background: #fee2e2; color: #dc2626;">⚠️</div>
            <div>
                <div style="font-size: 1.6rem; font-weight: 800;">{{ $atRiskCount }}</div>
                <div style="font-size: 0.8rem; color: #64748b;">Perilaku At-Risk</div>
            </div>
        </div>
    </div>

    <!-- Recent Observations -->
    <div class="card">
        <div class="card-header">
            <span class="card-title">📊 Observasi BBS Saya Terbaru</span>
            <a href="{{ route('karyawan.observasi.index') }}" class="btn btn-sm btn-secondary">Lihat Semua →</a>
        </div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Lokasi</th>
                        <th>Kategori</th>
                        <th>Perilaku</th>
                        <th>Risiko (C4.5)</th>
                        <th>Tindak Lanjut</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($myObservasi as $obs)
                        <tr>
                            <td>{{ date('d M Y', strtotime($obs->tanggal)) }}</td>
                            <td>{{ $obs->lokasi->nama_lokasi ?? '-' }}</td>
                            <td>{{ Str::limit($obs->kategori->nama_kategori ?? '-', 20) }}</td>
                            <td><span class="badge badge-{{ $obs->jenis_perilaku }}">{{ strtoupper($obs->jenis_perilaku) }}</span></td>
                            <td><span class="badge badge-{{ $obs->tingkat_risiko }}">{{ strtoupper($obs->tingkat_risiko) }}</span></td>
                            <td style="font-size: 0.8rem; color: #64748b;">{{ strtoupper($obs->status_tindak_lanjut) }}</td>
                            <td><a href="{{ route('karyawan.observasi.detail', $obs->id) }}" class="btn btn-sm btn-secondary">Detail</a></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align: center; color: #94a3b8; padding: 2rem;">
                                Belum ada observasi. <a href="{{ route('karyawan.observasi.create') }}" style="color: #0284c7; font-weight: 600;">Input sekarang →</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
