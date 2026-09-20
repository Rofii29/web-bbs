@extends('layouts.admin')

@section('title', 'Laporan Rekapitulasi')
@section('page-title', 'Laporan Rekapitulasi Observasi BBS')

@section('styles')
<style>
    @media print {
        .sidebar, .topbar, .no-print { display: none !important; }
        .main-content { margin: 0 !important; padding: 0 !important; }
        .content-body { padding: 0 !important; }
    }
</style>
@endsection

@section('content')
    <div class="card" style="margin-bottom: 1.25rem;" class="no-print">
        <div class="card-header">
            <span class="card-title">🖨️ Filter Periode Laporan</span>
            <button onclick="window.print()" class="btn btn-success no-print">🖨️ Cetak / Export PDF</button>
        </div>
        <form action="{{ route('admin.laporan.index') }}" method="GET" style="display: flex; gap: 1rem; align-items: flex-end; flex-wrap: wrap;" class="no-print">
            <div>
                <label class="form-label">Dari Tanggal</label>
                <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
            </div>
            <span style="align-self: flex-end; padding-bottom: 0.7rem; color: #64748b;">s/d</span>
            <div>
                <label class="form-label">Sampai Tanggal</label>
                <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
            </div>
            <button type="submit" class="btn btn-primary">Tampilkan Rekap</button>
            <a href="{{ route('admin.laporan.index') }}" onclick="window.location.href='{{ route('admin.laporan.index') }}'; return false;" class="btn btn-secondary">Reset</a>
        </form>
    </div>

    <div class="card">
        <div class="card-header">
            <span class="card-title">📋 Rekapitulasi Laporan Observasi BBS ({{ count($observasiList) }} Data)</span>
        </div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Observer</th>
                        <th>Unit</th>
                        <th>Lokasi Area</th>
                        <th>Kategori BBS</th>
                        <th>Perilaku</th>
                        <th>Risiko C4.5</th>
                        <th>Temuan Observasi</th>
                        <th>Tindak Lanjut</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($observasiList as $index => $obs)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ date('d/m/Y', strtotime($obs->tanggal)) }}</td>
                            <td><strong>{{ $obs->user->name ?? '-' }}</strong></td>
                            <td>{{ $obs->unit_departemen }}</td>
                            <td>{{ $obs->lokasi->nama_lokasi ?? '-' }}</td>
                            <td>{{ Str::limit($obs->kategori->nama_kategori ?? '-', 20) }}</td>
                            <td><span class="badge badge-{{ $obs->jenis_perilaku }}">{{ strtoupper($obs->jenis_perilaku) }}</span></td>
                            <td><span class="badge badge-{{ $obs->tingkat_risiko }}">{{ strtoupper($obs->tingkat_risiko) }}</span></td>
                            <td>{{ Str::limit($obs->ditemukan, 35) }}</td>
                            <td>{{ strtoupper($obs->status_tindak_lanjut) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" style="text-align: center; color: #94a3b8; padding: 2rem;">Tidak ada laporan untuk periode ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
