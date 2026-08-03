<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Karyawan - Portal Multi-Role</title>
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
            background: #0f172a;
            color: #f8fafc;
            display: flex;
            flex-direction: column;
        }

        .navbar {
            background: rgba(30, 41, 59, 0.8);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding: 1rem 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .nav-brand {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-weight: 700;
            font-size: 1.25rem;
            color: #ffffff;
        }

        .nav-brand-icon {
            width: 38px;
            height: 38px;
            background: linear-gradient(135deg, #06b6d4, #3b82f6);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .nav-brand-icon svg {
            width: 22px;
            height: 22px;
            fill: #ffffff;
        }

        .user-menu {
            display: flex;
            align-items: center;
            gap: 1.25rem;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #38bdf8, #818cf8);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            color: #ffffff;
            font-size: 1rem;
            box-shadow: 0 4px 12px rgba(56, 189, 248, 0.3);
        }

        .user-details {
            display: flex;
            flex-direction: column;
        }

        .user-name {
            font-size: 0.925rem;
            font-weight: 600;
            color: #ffffff;
        }

        .role-badge {
            display: inline-block;
            padding: 0.15rem 0.6rem;
            background: rgba(6, 182, 212, 0.2);
            border: 1px solid rgba(6, 182, 212, 0.4);
            color: #67e8f9;
            border-radius: 20px;
            font-size: 0.725rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-top: 0.1rem;
            width: fit-content;
        }

        .btn-logout {
            background: rgba(239, 68, 68, 0.15);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #fca5a5;
            padding: 0.5rem 1rem;
            border-radius: 10px;
            font-size: 0.875rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-logout:hover {
            background: rgba(239, 68, 68, 0.25);
            color: #ffffff;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2.5rem 1.5rem;
            width: 100%;
            flex: 1;
        }

        .welcome-banner {
            background: linear-gradient(135deg, rgba(6, 182, 212, 0.2), rgba(59, 130, 246, 0.15));
            border: 1px solid rgba(6, 182, 212, 0.3);
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.4);
        }

        .welcome-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 0.5rem;
        }

        .welcome-subtitle {
            color: #cbd5e1;
            font-size: 0.95rem;
        }

        .alert-flash {
            padding: 1rem 1.25rem;
            background: rgba(34, 197, 94, 0.15);
            border: 1px solid rgba(34, 197, 94, 0.3);
            color: #86efac;
            border-radius: 14px;
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2.5rem;
        }

        .stat-card {
            background: rgba(30, 41, 59, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 16px;
            padding: 1.5rem;
            display: flex;
            align-items: center;
            gap: 1.25rem;
            transition: transform 0.2s ease;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            border-color: rgba(255, 255, 255, 0.15);
        }

        .stat-icon {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .stat-icon.cyan {
            background: rgba(6, 182, 212, 0.2);
            color: #67e8f9;
        }

        .stat-icon.emerald {
            background: rgba(16, 185, 129, 0.2);
            color: #6ee7b7;
        }

        .stat-icon.indigo {
            background: rgba(99, 102, 241, 0.2);
            color: #a5b4fc;
        }

        .stat-icon svg {
            width: 26px;
            height: 26px;
        }

        .stat-val {
            font-size: 1.35rem;
            font-weight: 700;
            color: #ffffff;
        }

        .stat-label {
            font-size: 0.85rem;
            color: #94a3b8;
        }

        .content-card {
            background: rgba(30, 41, 59, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 20px;
            padding: 2rem;
        }

        .card-header {
            font-size: 1.15rem;
            font-weight: 700;
            margin-bottom: 1.25rem;
            color: #ffffff;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.925rem;
        }

        .info-table th, .info-table td {
            padding: 0.875rem 1rem;
            text-align: left;
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
        }

        .info-table th {
            color: #94a3b8;
            font-weight: 500;
            background: rgba(15, 23, 42, 0.3);
        }

        .info-table td {
            color: #e2e8f0;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="nav-brand">
            <div class="nav-brand-icon">
                <svg viewBox="0 0 24 24">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 4c1.93 0 3.5 1.57 3.5 3.5S13.93 13 12 13s-3.5-1.57-3.5-3.5S10.07 6 12 6zm0 14c-2.03 0-4.43-.82-6.14-2.88 1.84-1.67 4.31-2.62 6.14-2.62s4.3 0.95 6.14 2.62C16.43 19.18 14.03 20 12 20z"/>
                </svg>
            </div>
            <span>Portal Karyawan</span>
        </div>

        <div class="user-menu">
            <div class="user-info">
                <div class="avatar">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div class="user-details">
                    <span class="user-name">{{ Auth::user()->name }}</span>
                    <span class="role-badge">KARYAWAN</span>
                </div>
            </div>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn-logout">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                        <polyline points="16 17 21 12 16 7"></polyline>
                        <line x1="21" y1="12" x2="9" y2="12"></line>
                    </svg>
                    Keluar
                </button>
            </form>
        </div>
    </nav>

    <div class="container">
        @if(session('success'))
            <div class="alert-flash">
                <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <div class="welcome-banner">
            <div>
                <h1 class="welcome-title">Selamat Datang, {{ Auth::user()->name }}! 👋</h1>
                <p class="welcome-subtitle">Anda login sebagai Karyawan. Selamat bekerja dan tingkatkan produktivitas hari ini!</p>
            </div>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon cyan">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"></circle>
                        <polyline points="12 6 12 12 16 14"></polyline>
                    </svg>
                </div>
                <div>
                    <div class="stat-val">Tepat Waktu</div>
                    <div class="stat-label">Status Presensi Hari Ini</div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon emerald">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                        <polyline points="22 4 12 14.01 9 11.01"></polyline>
                    </svg>
                </div>
                <div>
                    <div class="stat-val">Aktif</div>
                    <div class="stat-label">Status Kepegawaian</div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon indigo">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                        <line x1="16" y1="13" x2="8" y2="13"></line>
                        <line x1="16" y1="17" x2="8" y2="17"></line>
                        <polyline points="10 9 9 9 8 9"></polyline>
                    </svg>
                </div>
                <div>
                    <div class="stat-val">Karyawan</div>
                    <div class="stat-label">Role Pengguna</div>
                </div>
            </div>
        </div>

        <div class="content-card">
            <h2 class="card-header">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#67e8f9" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                </svg>
                Informasi Profil Karyawan
            </h2>
            <table class="info-table">
                <thead>
                    <tr>
                        <th>Parameter</th>
                        <th>Detail Informasi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Nama Lengkap</td>
                        <td><strong>{{ Auth::user()->name }}</strong></td>
                    </tr>
                    <tr>
                        <td>Email Karyawan</td>
                        <td>{{ Auth::user()->email }}</td>
                    </tr>
                    <tr>
                        <td>Jabatan / Role</td>
                        <td><span class="role-badge">KARYAWAN</span></td>
                    </tr>
                    <tr>
                        <td>Waktu Sesi Login</td>
                        <td>{{ date('d M Y, H:i') }} WIB</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
