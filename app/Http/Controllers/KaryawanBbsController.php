<?php

namespace App\Http\Controllers;

use App\Models\ObservasiBbs;
use App\Models\KategoriPerilaku;
use App\Models\Lokasi;
use App\Services\C45Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class KaryawanBbsController extends Controller
{
    protected $c45Service;

    public function __construct(C45Service $c45Service)
    {
        $this->c45Service = $c45Service;
    }

    /**
     * Dashboard Karyawan
     */
    public function index()
    {
        $user = Auth::user();

        $totalObservasi = ObservasiBbs::where('user_id', $user->id)->count();
        $safeCount = ObservasiBbs::where('user_id', $user->id)->where('jenis_perilaku', 'safe')->count();
        $atRiskCount = ObservasiBbs::where('user_id', $user->id)->where('jenis_perilaku', 'at_risk')->count();

        $myObservasi = ObservasiBbs::with(['lokasi', 'kategori'])
            ->where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        return view('karyawan.index', compact('totalObservasi', 'safeCount', 'atRiskCount', 'myObservasi'));
    }

    /**
     * Form Input Observasi BBS Baru
     */
    public function createObservasi()
    {
        $lokasiList = Lokasi::all();
        $kategoriList = KategoriPerilaku::all();

        return view('karyawan.observasi.create', compact('lokasiList', 'kategoriList'));
    }

    /**
     * Simpan Observasi BBS Baru & Jalankan Klasifikasi Risiko C4.5
     */
    public function storeObservasi(Request $request)
    {
        $request->validate([
            'tanggal' => ['required', 'date'],
            'lokasi_id' => ['nullable'],
            'area_observasi' => ['nullable', 'string', 'max:255'],
            'jenis_perilaku' => ['required', 'in:safe,at_risk'],
            'kategori_id' => ['nullable'],
            'ketika' => ['nullable', 'string'],
            'ditemukan' => ['required', 'string'],
            'sebab' => ['nullable', 'string'],
            'saran' => ['nullable', 'string'],
        ], [
            'tanggal.required' => 'Tanggal observasi wajib diisi.',
            'jenis_perilaku.required' => 'Silakan pilih jenis perilaku (Safe / At-Risk).',
            'ditemukan.required' => 'Deskripsi temuan observasi wajib diisi.',
        ]);

        $user = Auth::user();

        // Handle lokasi_id vs area_observasi custom input
        $lokasiId = $request->lokasi_id;
        if ($request->filled('area_observasi')) {
            $lokasi = Lokasi::firstOrCreate(
                ['nama_lokasi' => trim($request->area_observasi)],
                ['area' => 'Operasional Lapangan']
            );
            $lokasiId = $lokasi->id;
        }
        if (!$lokasiId) {
            $lokasiId = Lokasi::first()?->id ?? 1;
        }

        $kategoriId = $request->kategori_id ?: (KategoriPerilaku::first()?->id ?? 1);

        // Prediksi Otomatis Tingkat Risiko Menggunakan Algoritma C4.5
        $predictedRisk = $this->c45Service->predictRisk(
            $request->jenis_perilaku,
            $kategoriId,
            $lokasiId
        );

        $observasi = ObservasiBbs::create([
            'tanggal' => $request->tanggal,
            'user_id' => $user->id,
            'lokasi_id' => $lokasiId,
            'unit_departemen' => $user->unit_departemen ?? 'Operasional Lapangan',
            'jenis_perilaku' => $request->jenis_perilaku,
            'kategori_id' => $kategoriId,
            'ketika' => $request->ketika,
            'ditemukan' => $request->ditemukan,
            'sebab' => $request->sebab,
            'saran' => $request->saran,
            'tingkat_risiko' => $predictedRisk,
            'status_tindak_lanjut' => 'open',
        ]);

        return redirect()->route('karyawan.observasi.detail', $observasi->id)
            ->with('success', 'Observasi BBS berhasil dikirim! Sistem C4.5 secara otomatis mengklasifikasikan tingkat risiko temuan sebagai: ' . strtoupper($predictedRisk));
    }

    /**
     * Riwayat Observasi Saya
     */
    public function riwayatObservasi(Request $request)
    {
        $user = Auth::user();

        $query = ObservasiBbs::with(['lokasi', 'kategori'])->where('user_id', $user->id);

        if ($request->filled('jenis_perilaku')) {
            $query->where('jenis_perilaku', $request->jenis_perilaku);
        }
        if ($request->filled('tingkat_risiko')) {
            $query->where('tingkat_risiko', $request->tingkat_risiko);
        }

        $myObservasiList = $query->latest()->paginate(10);

        return view('karyawan.observasi.index', compact('myObservasiList'));
    }

    /**
     * Detail Observasi Karyawan
     */
    public function detailObservasi($id)
    {
        $user = Auth::user();

        $observasi = ObservasiBbs::with(['lokasi', 'kategori'])
            ->where('user_id', $user->id)
            ->findOrFail($id);

        return view('karyawan.observasi.detail', compact('observasi'));
    }

    /**
     * Profil Saya
     */
    public function profil()
    {
        $user = Auth::user();
        return view('karyawan.profil', compact('user'));
    }

    public function updateProfil(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'no_hp' => ['required', 'string', 'max:20'],
            'jabatan' => ['required', 'string', 'max:255'],
            'unit_departemen' => ['required', 'string', 'max:255'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        $data = [
            'name' => $request->name,
            'no_hp' => $request->no_hp,
            'jabatan' => $request->jabatan,
            'unit_departemen' => $request->unit_departemen,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return back()->with('success', 'Profil Anda telah berhasil diperbarui.');
    }
}
