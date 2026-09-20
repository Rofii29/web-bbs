@extends('layouts.admin')

@section('title', 'Data Karyawan PT')
@section('page-title', 'Data Karyawan PT & Status Keaktifan')

@section('content')
    <!-- STATS SUMMARY CARDS -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon" style="background: #eff6ff; color: #2563eb;">👥</div>
            <div>
                <div style="font-size: 0.75rem; color: #64748b; font-weight: 600;">TOTAL KARYAWAN</div>
                <div style="font-size: 1.5rem; font-weight: 800; color: #0f172a;">{{ $totalKaryawan }}</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background: #f0fdf4; color: #166534;">✅</div>
            <div>
                <div style="font-size: 0.75rem; color: #64748b; font-weight: 600;">STATUS AKTIF</div>
                <div style="font-size: 1.5rem; font-weight: 800; color: #166534;">{{ $totalAktif }}</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background: #fef9c3; color: #854d0e;">⏳</div>
            <div>
                <div style="font-size: 0.75rem; color: #64748b; font-weight: 600;">PENDING VERIFIKASI</div>
                <div style="font-size: 1.5rem; font-weight: 800; color: #854d0e;">{{ $totalPending }}</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background: #fef2f2; color: #991b1b;">🚫</div>
            <div>
                <div style="font-size: 0.75rem; color: #64748b; font-weight: 600;">NONAKTIF / DITOLAK</div>
                <div style="font-size: 1.5rem; font-weight: 800; color: #991b1b;">{{ $totalRejected }}</div>
            </div>
        </div>
    </div>

    <!-- MAIN CARD & FILTER -->
    <div class="card">
        <div class="card-header" style="flex-wrap: wrap; gap: 1rem;">
            <div class="card-title">📋 Daftar Seluruh Karyawan PT</div>
            
            <form action="{{ route('admin.karyawan.index') }}" method="GET" style="display: flex; gap: 0.5rem; flex-wrap: wrap; align-items: center;">
                <select name="status" class="form-control" style="width: auto; padding: 0.45rem 0.75rem; font-size: 0.85rem;" onchange="this.form.submit()">
                    <option value="">-- Semua Status --</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Nonaktif / Ditolak</option>
                </select>

                <input type="text" name="search" class="form-control" placeholder="Cari nama, dept, batch..." value="{{ request('search') }}" style="width: 220px; padding: 0.45rem 0.75rem; font-size: 0.85rem;">

                <button type="submit" class="btn btn-primary btn-sm">🔍 Cari</button>
                @if(request()->filled('status') || request()->filled('search'))
                    <a href="{{ route('admin.karyawan.index') }}" onclick="window.location.href='{{ route('admin.karyawan.index') }}'; return false;" class="btn btn-secondary btn-sm">Reset</a>
                @endif
            </form>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th>Karyawan</th>
                        <th>No. HP</th>
                        <th>Jabatan & Dept</th>
                        <th>No. Batch</th>
                        <th>Status PT</th>
                        <th>Terdaftar</th>
                        <th style="text-align: center;">Aksi Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($karyawanList as $index => $user)
                        <tr>
                            <td>{{ $karyawanList->firstItem() + $index }}</td>
                            <td>
                                <div><strong>{{ $user->name }}</strong></div>
                                <div style="font-size: 0.78rem; color: #64748b;">{{ $user->email }}</div>
                            </td>
                            <td style="font-size: 0.85rem;">{{ $user->no_hp ?? '—' }}</td>
                            <td>
                                <div style="font-weight: 600; font-size: 0.85rem; color: #334155;">{{ $user->jabatan ?? '—' }}</div>
                                <div style="font-size: 0.78rem; color: #64748b;">{{ $user->unit_departemen ?? '—' }}</div>
                            </td>
                            <td>
                                @if($user->no_batch)
                                    <span style="background:#eff6ff; color:#2563eb; padding:0.25rem 0.6rem; border-radius:6px; font-size:0.8rem; font-weight:700; border: 1px solid #bfdbfe;">
                                        #{{ $user->no_batch }}
                                    </span>
                                @else
                                    <span style="color:#94a3b8; font-size:0.8rem;">—</span>
                                @endif
                            </td>
                            <td>
                                @if($user->status === 'active')
                                    <span class="badge badge-active">🟢 Aktif</span>
                                @elseif($user->status === 'pending')
                                    <span class="badge badge-pending">🟡 Pending</span>
                                @else
                                    <span class="badge badge-rejected">🔴 Nonaktif</span>
                                @endif
                            </td>
                            <td style="font-size: 0.8rem; color: #64748b;">
                                {{ $user->created_at ? $user->created_at->format('d M Y') : '—' }}
                            </td>
                            <td style="text-align: center;">
                                <div style="display: flex; gap: 0.4rem; justify-content: center; flex-wrap: wrap;">
                                    @if($user->status !== 'active')
                                        <form action="{{ route('admin.verifikasi.approve', $user->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm" title="Aktifkan Karyawan">
                                                ✅ Aktifkan
                                            </button>
                                        </form>
                                    @endif

                                    @if($user->status !== 'rejected')
                                        <form action="{{ route('admin.verifikasi.reject', $user->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Apakah Anda yakin ingin menonaktifkan/menolak karyawan ini?')">
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-sm" title="Nonaktifkan Karyawan">
                                                🚫 Nonaktifkan
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" style="text-align: center; color: #94a3b8; padding: 2.5rem;">
                                🔍 Tidak ada data karyawan yang sesuai dengan kriteria.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($karyawanList->hasPages())
            <div style="margin-top: 1.25rem; display: flex; justify-content: flex-end;">
                {{ $karyawanList->links() }}
            </div>
        @endif
    </div>
@endsection
