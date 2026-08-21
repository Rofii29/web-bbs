@extends('layouts.admin')

@section('title', 'Detail Observasi #' . $observasi->id)
@section('page-title', 'Detail Observasi BBS #' . $observasi->id)

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.25rem;" class="no-print">
        <a href="{{ route('admin.observasi.index') }}" class="btn btn-secondary btn-sm">← Kembali ke List Observasi</a>
        <button onclick="window.print()" class="btn btn-primary btn-sm">🖨️ Cetak Formulir BBS Resmi (PDF)</button>
    </div>

    <div style="display: grid; grid-template-columns: 3fr 1fr; gap: 1.5rem; align-items: start;">
        <!-- Left: Official BBS Form Matching Gambar 1 -->
        <div>
            @include('partials.bbs_formulir')
        </div>

        <!-- Right: Action Panel Admin / HES -->
        <div class="card no-print">
            <div class="card-title" style="margin-bottom: 1rem;">📌 Status Tindak Lanjut HES</div>
            <form action="{{ route('admin.observasi.tindak_lanjut', $observasi->id) }}" method="POST">
                @csrf
                <div class="form-group" style="margin-bottom: 1rem;">
                    <label class="form-label">Status Tindak Lanjut</label>
                    <select name="status_tindak_lanjut" class="form-control" required>
                        <option value="open" {{ $observasi->status_tindak_lanjut === 'open' ? 'selected' : '' }}>OPEN - Belum Ditindaklanjuti</option>
                        <option value="in_progress" {{ $observasi->status_tindak_lanjut === 'in_progress' ? 'selected' : '' }}>IN PROGRESS - Sedang Ditangani</option>
                        <option value="closed" {{ $observasi->status_tindak_lanjut === 'closed' ? 'selected' : '' }}>CLOSED - Selesai</option>
                    </select>
                </div>
                <div class="form-group" style="margin-bottom: 1rem;">
                    <label class="form-label">Catatan / Instruksi Steering Committee</label>
                    <textarea name="catatan_tindak_lanjut" class="form-control" rows="4" placeholder="Masukkan catatan penanganan...">{{ $observasi->catatan_tindak_lanjut }}</textarea>
                </div>
                <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center;">Simpan Tindak Lanjut</button>
            </form>

            <div style="margin-top: 1.5rem; padding-top: 1rem; border-top: 1px solid #e2e8f0; font-size: 0.8rem; color: #64748b;">
                <strong>Klasifikasi C4.5:</strong>
                <div style="margin-top: 0.35rem;">
                    Tingkat Risiko: <span class="badge badge-{{ $observasi->tingkat_risiko }}">{{ strtoupper($observasi->tingkat_risiko) }}</span>
                </div>
            </div>
        </div>
    </div>
@endsection
