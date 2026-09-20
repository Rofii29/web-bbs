@extends('layouts.admin')

@section('title', 'Data Observasi BBS')
@section('page-title', 'Data Observasi BBS')

@section('content')
    <!-- Filter -->
    <div class="card" style="margin-bottom: 1.25rem;">
        <form action="{{ route('admin.observasi.index') }}" method="GET" style="display: flex; gap: 0.875rem; align-items: flex-end; flex-wrap: wrap;">
            <div style="flex: 1; min-width: 180px;">
                <label class="form-label">Jenis Perilaku</label>
                <select name="jenis_perilaku" class="form-control">
                    <option value="">Semua Perilaku</option>
                    <option value="safe" {{ request('jenis_perilaku') === 'safe' ? 'selected' : '' }}>SAFE</option>
                    <option value="at_risk" {{ request('jenis_perilaku') === 'at_risk' ? 'selected' : '' }}>AT-RISK</option>
                </select>
            </div>
            <div style="flex: 1; min-width: 180px;">
                <label class="form-label">Tingkat Risiko C4.5</label>
                <select name="tingkat_risiko" class="form-control">
                    <option value="">Semua Risiko</option>
                    <option value="rendah" {{ request('tingkat_risiko') === 'rendah' ? 'selected' : '' }}>Rendah</option>
                    <option value="sedang" {{ request('tingkat_risiko') === 'sedang' ? 'selected' : '' }}>Sedang</option>
                    <option value="tinggi" {{ request('tingkat_risiko') === 'tinggi' ? 'selected' : '' }}>Tinggi</option>
                </select>
            </div>
            <div style="flex: 1; min-width: 160px;">
                <label class="form-label">Dari Tanggal</label>
                <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
            </div>
            <div style="flex: 1; min-width: 160px;">
                <label class="form-label">Sampai Tanggal</label>
                <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
            </div>
            <div style="display: flex; gap: 0.5rem;">
                <button type="submit" class="btn btn-primary">🔍 Filter</button>
                <a href="{{ route('admin.observasi.index') }}" onclick="window.location.href='{{ route('admin.observasi.index') }}'; return false;" class="btn btn-secondary">Reset</a>
            </div>
        </form>
    </div>

    <!-- Table -->
    <div class="card">
        <div class="card-header">
            <span class="card-title">📋 Daftar Observasi BBS ({{ $observasiList->total() }})</span>
            <a href="{{ route('admin.laporan.index') }}" class="btn btn-sm btn-secondary">🖨️ Cetak Laporan</a>
        </div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Observer</th>
                        <th>Lokasi</th>
                        <th>Kategori</th>
                        <th>Perilaku</th>
                        <th>Risiko C4.5</th>
                        <th>Tindak Lanjut</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($observasiList as $obs)
                        <tr>
                            <td style="font-size: 0.825rem;">{{ date('d M Y', strtotime($obs->tanggal)) }}</td>
                            <td><strong>{{ $obs->user->name ?? '-' }}</strong></td>
                            <td style="font-size: 0.825rem;">{{ $obs->lokasi->nama_lokasi ?? '-' }}</td>
                            <td style="font-size: 0.825rem;">{{ Str::limit($obs->kategori->nama_kategori ?? '-', 20) }}</td>
                            <td><span class="badge badge-{{ $obs->jenis_perilaku }}">{{ strtoupper($obs->jenis_perilaku) }}</span></td>
                            <td><span class="badge badge-{{ $obs->tingkat_risiko }}">{{ strtoupper($obs->tingkat_risiko) }}</span></td>
                            <td style="font-size: 0.8rem; color: #64748b;">{{ strtoupper($obs->status_tindak_lanjut) }}</td>
                            <td><a href="{{ route('admin.observasi.detail', $obs->id) }}" class="btn btn-sm btn-secondary">Detail</a></td>
                        </tr>
                    @empty
                        <tr><td colspan="8" style="text-align:center; color:#94a3b8; padding: 2rem;">Tidak ada data observasi.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div style="margin-top: 1.25rem;">{{ $observasiList->links() }}</div>
    </div>
@endsection
