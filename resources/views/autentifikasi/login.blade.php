<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Portal Multi-Role</title>
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
            background: #0f172a;
            background-image: 
                radial-gradient(at 0% 0%, rgba(99, 102, 241, 0.15) 0px, transparent 50%),
                radial-gradient(at 100% 100%, rgba(168, 85, 247, 0.15) 0px, transparent 50%);
            color: #f8fafc;
            padding: 1.5rem;
            position: relative;
            overflow-x: hidden;
        }

        .bg-glow {
            position: absolute;
            width: 350px;
            height: 350px;
            background: linear-gradient(135deg, #6366f1, #a855f7);
            filter: blur(140px);
            border-radius: 50%;
            opacity: 0.35;
            z-index: 0;
        }

        .login-card {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 440px;
            background: rgba(30, 41, 59, 0.7);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 24px;
            padding: 2.5rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            animation: fadeIn 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .brand-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .brand-icon {
            width: 56px;
            height: 56px;
            background: linear-gradient(135deg, #6366f1, #a855f7);
            border-radius: 16px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
            box-shadow: 0 10px 25px -5px rgba(99, 102, 241, 0.4);
        }

        .brand-icon svg {
            width: 28px;
            height: 28px;
            fill: #ffffff;
        }

        .brand-title {
            font-size: 1.5rem;
            font-weight: 700;
            letter-spacing: -0.025em;
            color: #ffffff;
            margin-bottom: 0.25rem;
        }

        .brand-subtitle {
            font-size: 0.875rem;
            color: #94a3b8;
        }

        .alert {
            padding: 0.875rem 1rem;
            border-radius: 12px;
            font-size: 0.875rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .alert-error {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.2);
            color: #fca5a5;
        }

        .alert-success {
            background: rgba(34, 197, 94, 0.1);
            border: 1px solid rgba(34, 197, 94, 0.2);
            color: #86efac;
        }

        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 500;
            color: #cbd5e1;
            margin-bottom: 0.5rem;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper svg {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            width: 20px;
            height: 20px;
            color: #64748b;
            transition: color 0.2s;
        }

        .form-input {
            width: 100%;
            padding: 0.875rem 1rem 0.875rem 2.875rem;
            background: rgba(15, 23, 42, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            color: #ffffff;
            font-size: 0.95rem;
            outline: none;
            transition: all 0.2s ease;
        }

        .form-input:focus {
            border-color: #818cf8;
            box-shadow: 0 0 0 3px rgba(129, 140, 248, 0.25);
            background: rgba(15, 23, 42, 0.8);
        }

        .form-input:focus + svg {
            color: #818cf8;
        }

        .remember-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
            font-size: 0.875rem;
        }

        .checkbox-label {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #94a3b8;
            cursor: pointer;
        }

        .checkbox-label input {
            accent-color: #6366f1;
            width: 16px;
            height: 16px;
        }

        .btn-submit {
            width: 100%;
            padding: 0.875rem;
            background: linear-gradient(135deg, #6366f1, #a855f7);
            border: none;
            border-radius: 12px;
            color: #ffffff;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 10px 20px -5px rgba(99, 102, 241, 0.4);
            transition: all 0.2s ease;
        }

        .btn-submit:hover {
            opacity: 0.95;
            transform: translateY(-1px);
            box-shadow: 0 14px 24px -5px rgba(99, 102, 241, 0.5);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        .footer-text {
            text-align: center;
            margin-top: 1.75rem;
            font-size: 0.875rem;
            color: #94a3b8;
        }

        .footer-text a {
            color: #a78bfa;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s;
        }

        .footer-text a:hover {
            color: #c4b5fd;
            text-decoration: underline;
        }

        /* Demo accounts box */
        .demo-box {
            margin-top: 1.5rem;
            padding: 1rem;
            background: rgba(15, 23, 42, 0.4);
            border: 1px dashed rgba(255, 255, 255, 0.15);
            border-radius: 12px;
            font-size: 0.8rem;
            color: #94a3b8;
        }

        .demo-box p {
            font-weight: 600;
            color: #cbd5e1;
            margin-bottom: 0.5rem;
        }

        .demo-pill {
            display: flex;
            justify-content: space-between;
            padding: 0.35rem 0.6rem;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 6px;
            margin-bottom: 0.35rem;
        }

        .demo-pill:last-child {
            margin-bottom: 0;
        }
    </style>
</head>
<body>
    <div class="bg-glow"></div>

    <div class="login-card">
        <div class="brand-header">
            <div class="brand-icon">
                <svg viewBox="0 0 24 24">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 4c1.93 0 3.5 1.57 3.5 3.5S13.93 13 12 13s-3.5-1.57-3.5-3.5S10.07 6 12 6zm0 14c-2.03 0-4.43-.82-6.14-2.88 1.84-1.67 4.31-2.62 6.14-2.62s4.3 0.95 6.14 2.62C16.43 19.18 14.03 20 12 20z"/>
                </svg>
            </div>
            <h1 class="brand-title">Selamat Datang</h1>
            <p class="brand-subtitle">Masuk ke sistem dengan akun Admin atau Karyawan</p>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">
                <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-error">
                <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                <span>{{ $errors->first() }}</span>
            </div>
        @endif

        <form action="{{ route('login.post') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="email" class="form-label">Alamat Email</label>
                <div class="input-wrapper">
                    <input type="email" id="email" name="email" class="form-input" placeholder="nama@perusahaan.com" value="{{ old('email') }}" required autofocus>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                        <polyline points="22,6 12,13 2,6"></polyline>
                    </svg>
                </div>
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <div class="input-wrapper">
                    <input type="password" id="password" name="password" class="form-input" placeholder="••••••••" required>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                        <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                    </svg>
                </div>
            </div>

            <div class="remember-row">
                <label class="checkbox-label">
                    <input type="checkbox" name="remember">
                    <span>Ingat Saya</span>
                </label>
            </div>

            <button type="submit" class="btn-submit">Masuk ke Akun</button>
        </form>

        <div class="demo-box">
            <p>💡 Akun Demo bawaan:</p>
            <div class="demo-pill">
                <span><strong>Admin:</strong> admin@example.com</span>
                <span>password</span>
            </div>
            <div class="demo-pill">
                <span><strong>Karyawan:</strong> karyawan@example.com</span>
                <span>password</span>
            </div>
        </div>

        <p class="footer-text">
            Belum memiliki akun? <a href="{{ route('register') }}">Daftar di sini</a>
        </p>
    </div>
</body>
</html>
