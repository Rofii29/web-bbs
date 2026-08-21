@extends('layouts.admin')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard Overview')

@section('content')
    <!-- Welcome Banner -->
    <div style="background: linear-gradient(135deg, #4f46e5, #2563eb); border-radius: 18px; padding: 1.75rem 2rem; color: #fff; margin-bottom: 1.75rem; box-shadow: 0 10px 25px -5px rgba(79,70,229,0.3); display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h1 style="font-size: 1.5rem; font-weight: 800; margin-bottom: 0.35rem;">Selamat Datang, {{ Auth::user()->name }}! 👋</h1>
            <p style="color: rgba(255,255,255,0.85); font-size: 0.9rem;">Sistem Observasi Behavior Based Safety (BBS) + Algoritma C4.5</p>
        </div>
        <a href="{{ route('admin.observasi.index') }}" style="background: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.25); color: #fff; padding: 0.625rem 1.25rem; border-radius: 10px; font-weight: 700; font-size: 0.875rem; text-decoration: none; backdrop-filter: blur(4px);">Kelola Observasi →</a>
    </div>

    <!-- Stats Grid -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon" style="background: #ede9fe; color: #4f46e5;">📋</div>
            <div>
                <div style="font-size: 1.6rem; font-weight: 800; color: #0f172a;">{{ $totalObservasi }}</div>
                <div style="font-size: 0.8rem; color: #64748b;">Total Observasi BBS</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background: #dcfce7; color: #16a34a;">✅</div>
            <div>
                <div style="font-size: 1.6rem; font-weight: 800; color: #0f172a;">{{ $safeCount }}</div>
                <div style="font-size: 0.8rem; color: #64748b;">Perilaku Safe</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background: #fee2e2; color: #dc2626;">⚠️</div>
            <div>
                <div style="font-size: 1.6rem; font-weight: 800; color: #0f172a;">{{ $atRiskCount }}</div>
                <div style="font-size: 0.8rem; color: #64748b;">Perilaku At-Risk</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background: #fef9c3; color: #b45309;">⏳</div>
            <div>
                <div style="font-size: 1.6rem; font-weight: 800; color: #0f172a;">{{ $pendingUsers }}</div>
                <div style="font-size: 0.8rem; color: #64748b;">User Pending Verifikasi</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background: #fecaca; color: #991b1b;">🔴</div>
            <div>
                <div style="font-size: 1.6rem; font-weight: 800; color: #0f172a;">{{ $highRiskCount }}</div>
                <div style="font-size: 0.8rem; color: #64748b;">Risiko Tinggi (C4.5)</div>
            </div>
        </div>
    </div>

    <!-- Two Column -->
    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1.25rem;">
        <!-- Recent Observations -->
        <div class="card">
            <div class="card-header">
                <span class="card-title">📊 Observasi BBS Terbaru</span>
                <a href="{{ route('admin.observasi.index') }}" class="btn btn-sm btn-secondary">Lihat Semua</a>
            </div>
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Observer</th>
                            <th>Kategori</th>
                            <th>Perilaku</th>
                            <th>Risiko C4.5</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentObservasi as $obs)
                            <tr>
                                <td><strong>{{ $obs->user->name ?? '-' }}</strong><br><span style="font-size: 0.75rem; color: #64748b;">{{ date('d M Y', strtotime($obs->tanggal)) }}</span></td>
                                <td>{{ Str::limit($obs->kategori->nama_kategori ?? '-', 22) }}</td>
                                <td><span class="badge badge-{{ $obs->jenis_perilaku }}">{{ strtoupper($obs->jenis_perilaku) }}</span></td>
                                <td><span class="badge badge-{{ $obs->tingkat_risiko }}">{{ strtoupper($obs->tingkat_risiko) }}</span></td>
                                <td><a href="{{ route('admin.observasi.detail', $obs->id) }}" class="btn btn-sm btn-secondary">Detail</a></td>
                            </tr>
                        @empty
                            <tr><td colspan="5" style="text-align:center; color:#94a3b8; padding: 2rem;">Belum ada observasi.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- C4.5 Risk Distribution -->
        <div class="card">
            <div class="card-header">
                <span class="card-title">🧮 Distribusi Risiko C4.5</span>
            </div>
            @php
                $total = $riskDistribution['rendah'] + $riskDistribution['sedang'] + $riskDistribution['tinggi'];
            @endphp
            <div style="space-y: 0.75rem;">
                @foreach(['rendah' => ['#10b981', 'RENDAH 🟢'], 'sedang' => ['#f59e0b', 'SEDANG 🟡'], 'tinggi' => ['#ef4444', 'TINGGI 🔴']] as $level => [$color, $label])
                    @php $val = $riskDistribution[$level]; $pct = $total > 0 ? round(($val/$total)*100) : 0; @endphp
                    <div style="margin-bottom: 1rem;">
                        <div style="display:flex; justify-content:space-between; font-size:0.825rem; font-weight:600; margin-bottom:0.35rem;">
                            <span>{{ $label }}</span>
                            <span>{{ $val }} ({{ $pct }}%)</span>
                        </div>
                        <div style="height:8px; background:#f1f5f9; border-radius:99px; overflow:hidden;">
                            <div style="height:100%; width:{{ $pct }}%; background:{{ $color }}; border-radius:99px; transition: width 0.5s;"></div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div style="margin-top:1rem; padding-top:1rem; border-top: 1px solid #f1f5f9; text-align:center;">
                <a href="{{ route('admin.c45.index') }}" class="btn btn-primary" style="width:100%; justify-content:center;">Lihat Modul C4.5 →</a>
            </div>
        </div>
    </div>
@endsection
