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
            background-color: #f8fafc;
            background-image: 
                radial-gradient(at 0% 0%, rgba(79, 70, 229, 0.07) 0px, transparent 50%),
                radial-gradient(at 100% 100%, rgba(59, 130, 246, 0.07) 0px, transparent 50%);
            color: #0f172a;
            padding: 1.5rem;
            position: relative;
            overflow-x: hidden;
        }

        .bg-glow {
            position: absolute;
            width: 450px;
            height: 450px;
            background: linear-gradient(135deg, rgba(79, 70, 229, 0.12), rgba(59, 130, 246, 0.12));
            filter: blur(120px);
            border-radius: 50%;
            z-index: 0;
            pointer-events: none;
        }

        .login-card {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 440px;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 24px;
            padding: 2.5rem;
            box-shadow: 0 20px 40px -15px rgba(15, 23, 42, 0.07), 0 0 1px 1px rgba(15, 23, 42, 0.03);
            animation: fadeIn 0.5s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(16px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .brand-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .brand-icon {
            width: 56px;
            height: 56px;
            background: linear-gradient(135deg, #4f46e5, #2563eb);
            border-radius: 16px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
            box-shadow: 0 8px 20px -4px rgba(79, 70, 229, 0.35);
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
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-weight: 500;
        }

        .alert-error {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #991b1b;
        }

        .alert-success {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            color: #166534;
        }

        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 600;
            color: #334155;
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
            color: #94a3b8;
            transition: color 0.2s;
        }

        .form-input {
            width: 100%;
            padding: 0.875rem 1rem 0.875rem 2.875rem;
            background: #ffffff;
            border: 1px solid #cbd5e1;
            border-radius: 12px;
            color: #0f172a;
            font-size: 0.95rem;
            outline: none;
            transition: all 0.2s ease;
        }

        .form-input::placeholder {
            color: #94a3b8;
        }

        .form-input:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.15);
            background: #ffffff;
        }

        .form-input:focus + svg {
            color: #4f46e5;
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
            color: #475569;
            cursor: pointer;
            font-weight: 500;
        }

        .checkbox-label input {
            accent-color: #4f46e5;
            width: 16px;
            height: 16px;
            cursor: pointer;
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
        }

        .btn-submit:hover {
            background: linear-gradient(135deg, #4338ca, #1d4ed8);
            transform: translateY(-1px);
            box-shadow: 0 12px 24px -4px rgba(79, 70, 229, 0.4);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        .footer-text {
            text-align: center;
            margin-top: 1.75rem;
            font-size: 0.875rem;
            color: #64748b;
        }

        .footer-text a {
            color: #4f46e5;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s;
        }

        .footer-text a:hover {
            color: #3730a3;
            text-decoration: underline;
        }

        /* Demo accounts box */
        .demo-box {
            margin-top: 1.5rem;
            padding: 1rem;
            background: #f8fafc;
            border: 1px dashed #cbd5e1;
            border-radius: 14px;
            font-size: 0.825rem;
            color: #64748b;
        }

        .demo-box p {
            font-weight: 600;
            color: #334155;
            margin-bottom: 0.5rem;
        }

        .demo-pill {
            display: flex;
            justify-content: space-between;
            padding: 0.4rem 0.75rem;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            margin-bottom: 0.35rem;
            color: #334155;
        }

        .demo-pill:last-child {
            margin-bottom: 0;
        }

        .demo-pill strong {
            color: #0f172a;
        }

        /* Refined sign-in visual theme */
        body {
            background:
                radial-gradient(ellipse at 12% 12%, rgba(45,212,191,.22), transparent 28rem),
                radial-gradient(ellipse at 92% 88%, rgba(59,130,246,.3), transparent 32rem),
                linear-gradient(135deg, #081323 0%, #10253c 52%, #102c3b 100%);
        }
        body::before {
            content: "";
            position: fixed;
            inset: 0;
            pointer-events: none;
            opacity: .15;
            background-image: linear-gradient(rgba(255,255,255,.12) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,.12) 1px, transparent 1px);
            background-size: 42px 42px;
            mask-image: linear-gradient(to bottom, black, transparent 82%);
        }
        .bg-glow { width: 520px; height: 520px; filter: blur(135px); opacity: .8; }
        .login-card {
            max-width: 460px;
            overflow: hidden;
            border: 1px solid rgba(255,255,255,.72);
            border-radius: 28px;
            padding: 2.6rem;
            box-shadow: 0 32px 90px rgba(0,0,0,.3), 0 4px 18px rgba(15,23,42,.12);
            backdrop-filter: blur(18px);
        }
        .login-card::before {
            content: "";
            position: absolute;
            inset: 0 0 auto;
            height: 5px;
            background: linear-gradient(90deg, #2dd4bf, #38bdf8, #6366f1);
        }
        .brand-header { margin-bottom: 2.15rem; }
        .brand-icon {
            width: 64px;
            height: 64px;
            border-radius: 20px;
            background: linear-gradient(145deg, #14b8a6, #0284c7 62%, #4f46e5);
            box-shadow: 0 12px 28px rgba(2,132,199,.3);
        }
        .brand-title { font-size: 1.65rem; letter-spacing: -.045em; }
        .brand-subtitle { line-height: 1.6; }
        .form-group { margin-bottom: 1.35rem; }
        .form-label { color: #25364b; font-size: .82rem; }
        .form-input {
            min-height: 52px;
            background: #f8fafc;
            border-color: #dce5ee;
            border-radius: 14px;
            padding-top: .9rem;
            padding-bottom: .9rem;
        }
        .form-input:focus { border-color: #38bdf8; box-shadow: 0 0 0 4px rgba(14,165,233,.12); }
        .form-input:focus + svg { color: #0284c7; }
        .btn-submit {
            min-height: 52px;
            border-radius: 14px;
            background: linear-gradient(105deg, #0f766e, #0284c7 58%, #2563eb);
            box-shadow: 0 10px 24px rgba(2,132,199,.25);
        }
        .btn-submit:hover { background: linear-gradient(105deg, #0d6b64, #0369a1 58%, #1d4ed8); box-shadow: 0 14px 28px rgba(2,132,199,.3); }
        .demo-box { background: #f5f9fc; border: 1px solid #e4edf4; border-radius: 16px; }
        .demo-pill { border-radius: 10px; }
        .footer-text { line-height: 1.6; }
        .footer-text a { color: #087e8b; }
        .footer-text a:hover { color: #075985; }
        @media (max-width: 520px) {
            body { padding: 1rem; }
            .login-card { padding: 2rem 1.35rem; border-radius: 23px; }
            .demo-pill { gap: .5rem; font-size: .75rem; }
            .brand-title { font-size: 1.45rem; }
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

        <p class="footer-text">
            Belum memiliki akun? <a href="{{ route('register') }}">Daftar di sini</a>
        </p>
    </div>
</body>
</html>
