<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Sistem Observasi BBS</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f8fafc;
            background-image: 
                radial-gradient(at 100% 0%, rgba(79, 70, 229, 0.07) 0px, transparent 50%),
                radial-gradient(at 0% 100%, rgba(59, 130, 246, 0.07) 0px, transparent 50%);
            color: #0f172a;
            padding: 2rem 1.5rem;
            position: relative;
        }

        .register-card {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 560px;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 24px;
            padding: 2.5rem;
            box-shadow: 0 20px 40px -15px rgba(15, 23, 42, 0.07);
            animation: fadeIn 0.5s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(16px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .brand-header {
            text-align: center;
            margin-bottom: 1.75rem;
        }

        .brand-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 0.35rem;
        }

        .brand-subtitle {
            font-size: 0.875rem;
            color: #64748b;
        }

        .alert {
            padding: 0.875rem 1rem;
            border-radius: 12px;
            font-size: 0.875rem;
            margin-bottom: 1.25rem;
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #991b1b;
            font-weight: 500;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .form-group {
            margin-bottom: 1.15rem;
        }

        .form-group.full-width {
            grid-column: span 2;
        }

        .form-label {
            display: block;
            font-size: 0.85rem;
            font-weight: 600;
            color: #334155;
            margin-bottom: 0.4rem;
        }

        .form-input {
            width: 100%;
            padding: 0.75rem 1rem;
            background: #ffffff;
            border: 1px solid #cbd5e1;
            border-radius: 12px;
            color: #0f172a;
            font-size: 0.9rem;
            outline: none;
            transition: all 0.2s ease;
        }

        .form-input:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.15);
        }

        .role-selector {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.75rem;
        }

        .role-option input {
            position: absolute;
            opacity: 0;
        }

        .role-card {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 0.75rem;
            background: #f8fafc;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            cursor: pointer;
            text-align: center;
            transition: all 0.2s ease;
        }

        .role-card span {
            font-size: 0.875rem;
            font-weight: 600;
            color: #334155;
        }

        .role-card small {
            font-size: 0.725rem;
            color: #64748b;
        }

        .role-option input:checked + .role-card {
            border-color: #4f46e5;
            background: #eff6ff;
        }

        .btn-submit {
            width: 100%;
            padding: 0.875rem;
            background: linear-gradient(135deg, #4f46e5, #2563eb);
            border: none;
            border-radius: 12px;
            color: #ffffff;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 8px 20px -4px rgba(79, 70, 229, 0.35);
            transition: all 0.2s ease;
            margin-top: 0.5rem;
        }

        .btn-submit:hover {
            background: linear-gradient(135deg, #4338ca, #1d4ed8);
            transform: translateY(-1px);
        }

        .footer-text {
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.875rem;
            color: #64748b;
        }

        .footer-text a {
            color: #4f46e5;
            text-decoration: none;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="register-card">
        <div class="brand-header">
            <h1 class="brand-title">Pendaftaran Akun BBS</h1>
            <p class="brand-subtitle">Sistem Observasi Keselamatan Kerja (BBS & C4.5)</p>
        </div>

        @if($errors->any())
            <div class="alert">
                <span>{{ $errors->first() }}</span>
            </div>
        @endif

        <form action="{{ route('register.post') }}" method="POST">
            @csrf

            <div class="form-grid">
                <div class="form-group full-width">
                    <label for="name" class="form-label">Nama Lengkap</label>
                    <input type="text" id="name" name="name" class="form-input" placeholder="Masukkan nama lengkap" value="{{ old('name') }}" required autofocus>
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">Alamat Email</label>
                    <input type="email" id="email" name="email" class="form-input" placeholder="nama@perusahaan.com" value="{{ old('email') }}" required>
                </div>

                <div class="form-group">
                    <label for="no_hp" class="form-label">No. Telepon / HP</label>
                    <input type="text" id="no_hp" name="no_hp" class="form-input" placeholder="081234567890" value="{{ old('no_hp') }}" required>
                </div>

                <div class="form-group">
                    <label for="jabatan" class="form-label">Jabatan / Posisi</label>
                    <input type="text" id="jabatan" name="jabatan" class="form-input" placeholder="Contoh: Teknisi Lapangan" value="{{ old('jabatan') }}" required>
                </div>

                <div class="form-group">
                    <label for="unit_departemen" class="form-label">Unit / Departemen</label>
                    <input type="text" id="unit_departemen" name="unit_departemen" class="form-input" placeholder="Contoh: Operasional Plant A" value="{{ old('unit_departemen') }}" required>
                </div>

                <div class="form-group full-width">
                    <label class="form-label">Role Pengguna</label>
                    <div class="role-selector">
                        <label class="role-option">
                            <input type="radio" name="role" value="karyawan" {{ old('role', 'karyawan') === 'karyawan' ? 'checked' : '' }} required>
                            <div class="role-card">
                                <span>Karyawan</span>
                                <small>Observator (Perlu Verifikasi)</small>
                            </div>
                        </label>

                        <label class="role-option">
                            <input type="radio" name="role" value="admin" {{ old('role') === 'admin' ? 'checked' : '' }} required>
                            <div class="role-card">
                                <span>Admin / HES</span>
                                <small>Pengelola & Analyst</small>
                            </div>
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" id="password" name="password" class="form-input" placeholder="Minimal 8 karakter" required>
                </div>

                <div class="form-group">
                    <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-input" placeholder="Ulangi password" required>
                </div>
            </div>

            <button type="submit" class="btn-submit">Kirim Pendaftaran Akun</button>
        </form>

        <p class="footer-text">
            Sudah memiliki akun? <a href="{{ route('login') }}">Masuk di sini</a>
        </p>
    </div>
</body>
</html>
