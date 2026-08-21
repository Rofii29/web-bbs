@extends('layouts.karyawan')

@section('title', 'Detail Observasi #' . $observasi->id)
@section('page-title', 'Detail Observasi BBS #' . $observasi->id)

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.25rem;" class="no-print">
        <a href="{{ route('karyawan.observasi.index') }}" class="btn btn-secondary btn-sm">← Kembali ke Riwayat</a>
        <button onclick="window.print()" class="btn btn-primary btn-sm">🖨️ Cetak Formulir BBS (PDF)</button>
    </div>

    <div style="max-width: 1100px; margin: 0 auto;">
        @include('partials.bbs_formulir')
    </div>
@endsection
