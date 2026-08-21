<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Tampilkan form login.
     */
    public function showLogin()
    {
        if (Auth::check()) {
            return $this->redirectBasedOnRole(Auth::user());
        }

        return view('autentifikasi.login');
    }

    /**
     * Proses autentikasi login.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $user = Auth::user();

            // Cek status verifikasi akun (pending / rejected)
            if ($user->status === 'pending') {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Akun Anda masih dalam tahap peninjauan/verifikasi Admin HES. Silakan tunggu persetujuan.',
                ])->onlyInput('email');
            }

            if ($user->status === 'rejected') {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Permohonan akun Anda telah ditolak oleh Admin HES. Hubungi divisi HES untuk informasi lebih lanjut.',
                ])->onlyInput('email');
            }

            $request->session()->regenerate();

            return $this->redirectBasedOnRole($user, 'Selamat datang kembali, ' . $user->name . '!');
        }

        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    /**
     * Tampilkan form registrasi.
     */
    public function showRegister()
    {
        if (Auth::check()) {
            return $this->redirectBasedOnRole(Auth::user());
        }

        return view('autentifikasi.register');
    }

    /**
     * Proses pendaftaran pengguna baru.
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'no_hp' => ['required', 'string', 'max:20'],
            'jabatan' => ['required', 'string', 'max:255'],
            'unit_departemen' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'in:admin,karyawan'],
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'no_hp.required' => 'Nomor HP wajib diisi.',
            'jabatan.required' => 'Jabatan wajib diisi.',
            'unit_departemen.required' => 'Unit / Departemen wajib diisi.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'role.required' => 'Silakan pilih role.',
        ]);

        $status = ($request->role === 'admin') ? 'active' : 'pending';

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'jabatan' => $request->jabatan,
            'unit_departemen' => $request->unit_departemen,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'status' => $status,
        ]);

        if ($status === 'pending') {
            return redirect()->route('login')->with('success', 'Pendaftaran berhasil! Akun Anda sedang menunggu verifikasi oleh Admin HES sebelum dapat digunakan untuk login.');
        }

        Auth::login($user);
        $request->session()->regenerate();

        return $this->redirectBasedOnRole($user, 'Registrasi Admin berhasil! Selamat datang, ' . $user->name . '.');
    }

    /**
     * Proses logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda telah berhasil keluar.');
    }

    /**
     * Helper untuk mengarahkan pengguna sesuai role.
     */
    private function redirectBasedOnRole(User $user, ?string $message = null)
    {
        $redirect = $user->role === 'admin'
            ? redirect()->route('admin.index')
            : redirect()->route('karyawan.index');

        if ($message) {
            $redirect->with('success', $message);
        }

        return $redirect;
    }
}
