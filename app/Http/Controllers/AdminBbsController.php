<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ObservasiBbs;
use App\Models\KategoriPerilaku;
use App\Models\Lokasi;
use App\Models\TrainingC45;
use App\Services\C45Service;
use Illuminate\Http\Request;

class AdminBbsController extends Controller
{
    protected $c45Service;

    public function __construct(C45Service $c45Service)
    {
        $this->c45Service = $c45Service;
    }

    /**
     * Dashboard Admin / HES
     */
    public function index()
    {
        $totalObservasi = ObservasiBbs::count();
        $safeCount = ObservasiBbs::where('jenis_perilaku', 'safe')->count();
        $atRiskCount = ObservasiBbs::where('jenis_perilaku', 'at_risk')->count();

        $risikoRendah = ObservasiBbs::where('tingkat_risiko', 'rendah')->count();
        $risikoSedang = ObservasiBbs::where('tingkat_risiko', 'sedang')->count();
        $risikoTinggi = ObservasiBbs::where('tingkat_risiko', 'tinggi')->count();
        $highRiskCount = $risikoTinggi;

        $pendingUsers = User::where('status', 'pending')->count();
        $pendingUserCount = $pendingUsers;
        $tindakLanjutOpen = ObservasiBbs::where('status_tindak_lanjut', 'open')->count();

        $recentObservasi = ObservasiBbs::with(['user', 'lokasi', 'kategori'])
            ->latest()
            ->take(6)
            ->get();

        $riskDistribution = [
            'rendah' => $risikoRendah,
            'sedang' => $risikoSedang,
            'tinggi' => $risikoTinggi,
        ];

        return view('admin.index', compact(
            'totalObservasi',
            'safeCount',
            'atRiskCount',
            'risikoRendah',
            'risikoSedang',
            'risikoTinggi',
            'highRiskCount',
            'pendingUsers',
            'pendingUserCount',
            'tindakLanjutOpen',
            'recentObservasi',
            'riskDistribution'
        ));
    }

    /**
     * Verifikasi Pendaftaran Akun Karyawan
     */
    public function verifikasiUser()
    {
        $pendingUsers = User::where('status', 'pending')->latest()->get();
        $allUsers = User::where('role', 'karyawan')->latest()->get();

        return view('admin.verifikasi_user', compact('pendingUsers', 'allUsers'));
    }

    public function approveUser($id)
    {
        $user = User::findOrFail($id);
        $user->update(['status' => 'active']);

        return back()->with('success', 'Akun karyawan "' . $user->name . '" telah berhasil disetujui & diaktifkan.');
    }

    public function rejectUser($id)
    {
        $user = User::findOrFail($id);
        $user->update(['status' => 'rejected']);

        return back()->with('success', 'Pendaftaran akun karyawan "' . $user->name . '" telah ditolak.');
    }

    /**
     * Kelola Data Observasi BBS
     */
    public function kelolaObservasi(Request $request)
    {
        $query = ObservasiBbs::with(['user', 'lokasi', 'kategori']);

        if ($request->filled('lokasi_id')) {
            $query->where('lokasi_id', $request->lokasi_id);
        }
        if ($request->filled('jenis_perilaku')) {
            $query->where('jenis_perilaku', $request->jenis_perilaku);
        }
        if ($request->filled('tingkat_risiko')) {
            $query->where('tingkat_risiko', $request->tingkat_risiko);
        }

        $observasiList = $query->latest()->paginate(15);
        $lokasiList = Lokasi::all();
        $kategoriList = KategoriPerilaku::all();

        return view('admin.observasi.index', compact('observasiList', 'lokasiList', 'kategoriList'));
    }

    /**
     * Detail Observasi & Tindak Lanjut
     */
    public function detailObservasi($id)
    {
        $observasi = ObservasiBbs::with(['user', 'lokasi', 'kategori'])->findOrFail($id);

        return view('admin.observasi.detail', compact('observasi'));
    }

    public function updateTindakLanjut(Request $request, $id)
    {
        $request->validate([
            'status_tindak_lanjut' => ['required', 'in:open,in_progress,closed'],
            'catatan_tindak_lanjut' => ['nullable', 'string'],
        ]);

        $observasi = ObservasiBbs::findOrFail($id);
        $observasi->update([
            'status_tindak_lanjut' => $request->status_tindak_lanjut,
            'catatan_tindak_lanjut' => $request->catatan_tindak_lanjut,
        ]);

        return back()->with('success', 'Status tindak lanjut Steering Committee berhasil diperbarui.');
    }

    /**
     * Modul Analytics & Pohon Keputusan C4.5
     */
    public function modulC45()
    {
        $c45Data = $this->c45Service->getAnalyticsSummary();
        $trainingList = TrainingC45::with(['kategori', 'lokasi'])->latest()->get();

        return view('admin.c45.index', compact('c45Data', 'trainingList'));
    }

    /**
     * Master Data (Kategori & Lokasi)
     */
    public function masterData()
    {
        $kategoriList = KategoriPerilaku::withCount('observasi')->get();
        $lokasiList = Lokasi::withCount('observasi')->get();

        return view('admin.master.index', compact('kategoriList', 'lokasiList'));
    }

    public function storeKategori(Request $request)
    {
        $request->validate([
            'nama_kategori' => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
        ]);

        KategoriPerilaku::create($request->only('nama_kategori', 'deskripsi'));

        return back()->with('success', 'Kategori Perilaku BBS berhasil ditambahkan.');
    }

    public function deleteKategori($id)
    {
        KategoriPerilaku::findOrFail($id)->delete();
        return back()->with('success', 'Kategori Perilaku berhasil dihapus.');
    }

    public function storeLokasi(Request $request)
    {
        $request->validate([
            'nama_lokasi' => ['required', 'string', 'max:255'],
            'area' => ['nullable', 'string', 'max:255'],
        ]);

        Lokasi::create($request->only('nama_lokasi', 'area'));

        return back()->with('success', 'Lokasi Area Kerja berhasil ditambahkan.');
    }

    public function deleteLokasi($id)
    {
        Lokasi::findOrFail($id)->delete();
        return back()->with('success', 'Lokasi Area Kerja berhasil dihapus.');
    }

    /**
     * Export Laporan Rekapitulasi Observasi
     */
    public function laporan(Request $request)
    {
        $query = ObservasiBbs::with(['user', 'lokasi', 'kategori']);

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('tanggal', [$request->start_date, $request->end_date]);
        }

        $observasiList = $query->latest()->get();

        return view('admin.laporan', compact('observasiList'));
    }
}
