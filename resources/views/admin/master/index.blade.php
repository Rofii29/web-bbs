@extends('layouts.admin')

@section('title', 'Master Data')
@section('page-title', 'Kelola Master Data')

@section('content')
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem;">
        <!-- Master Kategori -->
        <div class="card">
            <div class="card-title" style="margin-bottom: 1.25rem;">📂 Master Kategori Perilaku BBS</div>

            <form action="{{ route('admin.master.kategori.store') }}" method="POST" style="background: #f8fafc; padding: 1rem; border-radius: 10px; border: 1px solid #e2e8f0; margin-bottom: 1.25rem;">
                @csrf
                <div class="form-group">
                    <label class="form-label">Nama Kategori Baru</label>
                    <input type="text" name="nama_kategori" class="form-control" placeholder="Contoh: Alat Pelindung Diri (APD)" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Deskripsi Singkat</label>
                    <input type="text" name="deskripsi" class="form-control" placeholder="Deskripsi kelayakan atau kepatuhan...">
                </div>
                <button type="submit" class="btn btn-primary btn-sm">+ Tambah Kategori</button>
            </form>

            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Nama Kategori</th>
                            <th>Total Obs.</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kategoriList as $kat)
                            <tr>
                                <td><strong>{{ $kat->nama_kategori }}</strong></td>
                                <td>{{ $kat->observasi_count }}</td>
                                <td>
                                    <form action="{{ route('admin.master.kategori.delete', $kat->id) }}" method="POST" onsubmit="return confirm('Hapus kategori ini?')">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Master Lokasi -->
        <div class="card">
            <div class="card-title" style="margin-bottom: 1.25rem;">📍 Master Lokasi Area Kerja</div>

            <form action="{{ route('admin.master.lokasi.store') }}" method="POST" style="background: #f8fafc; padding: 1rem; border-radius: 10px; border: 1px solid #e2e8f0; margin-bottom: 1.25rem;">
                @csrf
                <div class="form-group">
                    <label class="form-label">Nama Lokasi Area</label>
                    <input type="text" name="nama_lokasi" class="form-control" placeholder="Contoh: Area Workshop Plant A" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Nama Zona / Kode Area</label>
                    <input type="text" name="area" class="form-control" placeholder="Contoh: Zona 1">
                </div>
                <button type="submit" class="btn btn-primary btn-sm">+ Tambah Lokasi</button>
            </form>

            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Nama Lokasi</th>
                            <th>Zona</th>
                            <th>Obs.</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($lokasiList as $lok)
                            <tr>
                                <td><strong>{{ Str::limit($lok->nama_lokasi, 22) }}</strong></td>
                                <td>{{ $lok->area ?? '-' }}</td>
                                <td>{{ $lok->observasi_count }}</td>
                                <td>
                                    <form action="{{ route('admin.master.lokasi.delete', $lok->id) }}" method="POST" onsubmit="return confirm('Hapus lokasi ini?')">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
