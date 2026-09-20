@extends('layouts.admin')

@section('title', 'Verifikasi Karyawan')
@section('page-title', 'Verifikasi Registrasi Karyawan')

@section('content')
    <div class="card">
        <div class="card-header">
            <span class="card-title">👥 Daftar Pendaftaran Karyawan Menunggu Verifikasi</span>
            <span class="badge badge-pending">{{ $pendingUsers->count() }} Pending</span>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>No. HP</th>
                        <th>Jabatan</th>
                        <th>Unit / Dept</th>
                        <th>No. Batch</th>
                        <th>Terdaftar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pendingUsers as $user)
                        <tr>
                            <td><strong>{{ $user->name }}</strong></td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->no_hp }}</td>
                            <td>{{ $user->jabatan }}</td>
                            <td>{{ $user->unit_departemen }}</td>
                            <td>
                                @if($user->no_batch)
                                    <span style="background:#eff6ff; color:#3b82f6; padding:0.2rem 0.6rem; border-radius:6px; font-size:0.8rem; font-weight:600;">{{ $user->no_batch }}</span>
                                @else
                                    <span style="color:#94a3b8; font-size:0.8rem;">—</span>
                                @endif
                            </td>
                            <td style="font-size: 0.8rem; color: #64748b;">{{ $user->created_at->format('d M Y') }}</td>
                            <td>
                                <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                                    <form action="{{ route('admin.verifikasi.approve', $user->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm">✅ Setujui</button>
                                    </form>
                                    <form action="{{ route('admin.verifikasi.reject', $user->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm">❌ Tolak</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" style="text-align: center; color: #94a3b8; padding: 2rem;">
                                🎉 Tidak ada pendaftaran yang menunggu verifikasi.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
