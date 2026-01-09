@extends('layouts.app')

@section('title', 'Dashboard - Class Online')

@section('content')
    <div class="dashboard-container">
        <!-- Navbar -->
        <nav class="dashboard-navbar">
            <div class="dashboard-navbar-container">
                <a href="{{ route('dashboard') }}" class="navbar-brand" style="color: var(--text-primary);">
                    <div class="navbar-brand-icon" style="background: var(--gradient-primary); color: white;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    Class Online
                </a>
                <div class="navbar-user">
                    <span class="user-role-badge {{ Auth::user()->role }}">
                        {{ Auth::user()->role === 'guru' ? '👨‍🏫 Guru' : '👨‍🎓 Mahasiswa' }}
                    </span>
                    <span class="user-name">{{ Auth::user()->name }}</span>
                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-secondary btn-sm">Logout</button>
                    </form>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="dashboard-main">
            <div class="dashboard-welcome">
                <h1>Selamat Datang, {{ Auth::user()->name }}! 👋</h1>
                <p>Anda login sebagai <strong>{{ Auth::user()->role === 'guru' ? 'Guru' : 'Mahasiswa' }}</strong></p>
            </div>

            <div class="dashboard-cards">
                @if(Auth::user()->role === 'guru')
                    <div class="dashboard-card">
                        <div class="card-icon">📚</div>
                        <h3>Kelas Saya</h3>
                        <p>Kelola kelas yang Anda ajar</p>
                        <span class="card-count">0 Kelas</span>
                    </div>
                    <div class="dashboard-card">
                        <div class="card-icon">👥</div>
                        <h3>Mahasiswa</h3>
                        <p>Lihat daftar mahasiswa</p>
                        <span class="card-count">0 Mahasiswa</span>
                    </div>
                    <div class="dashboard-card">
                        <div class="card-icon">📝</div>
                        <h3>Tugas</h3>
                        <p>Buat dan kelola tugas</p>
                        <span class="card-count">0 Tugas</span>
                    </div>
                @else
                    <div class="dashboard-card">
                        <div class="card-icon">📚</div>
                        <h3>Kelas Saya</h3>
                        <p>Kelas yang Anda ikuti</p>
                        <span class="card-count">0 Kelas</span>
                    </div>
                    <div class="dashboard-card">
                        <div class="card-icon">📝</div>
                        <h3>Tugas</h3>
                        <p>Tugas yang harus dikerjakan</p>
                        <span class="card-count">0 Tugas</span>
                    </div>
                    <div class="dashboard-card">
                        <div class="card-icon">📊</div>
                        <h3>Nilai</h3>
                        <p>Lihat nilai Anda</p>
                        <span class="card-count">-</span>
                    </div>
                @endif
            </div>
        </main>
    </div>

    <style>
        .dashboard-container {
            min-height: 100vh;
            background: var(--bg-light);
        }

        .dashboard-navbar {
            background: var(--bg-white);
            box-shadow: var(--shadow-md);
            padding: 1rem 2rem;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .dashboard-navbar-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .navbar-user {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .user-role-badge {
            padding: 0.375rem 0.75rem;
            border-radius: var(--radius-full);
            font-size: 0.875rem;
            font-weight: 500;
        }

        .user-role-badge.guru {
            background: linear-gradient(135deg, rgba(79, 70, 229, 0.1) 0%, rgba(124, 58, 237, 0.1) 100%);
            color: var(--primary);
        }

        .user-role-badge.mahasiswa {
            background: linear-gradient(135deg, rgba(6, 182, 212, 0.1) 0%, rgba(16, 185, 129, 0.1) 100%);
            color: var(--accent);
        }

        .user-name {
            font-weight: 500;
            color: var(--text-primary);
        }

        .dashboard-main {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }

        .dashboard-welcome {
            margin-bottom: 2rem;
        }

        .dashboard-welcome h1 {
            font-size: 1.875rem;
            margin-bottom: 0.5rem;
        }

        .dashboard-welcome p {
            color: var(--text-secondary);
        }

        .dashboard-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
        }

        .dashboard-card {
            background: var(--bg-white);
            border-radius: var(--radius-xl);
            padding: 1.5rem;
            box-shadow: var(--shadow-md);
            transition: all var(--transition-base);
        }

        .dashboard-card:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-lg);
        }

        .dashboard-card .card-icon {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }

        .dashboard-card h3 {
            font-size: 1.25rem;
            margin-bottom: 0.5rem;
        }

        .dashboard-card p {
            color: var(--text-secondary);
            font-size: 0.9375rem;
            margin-bottom: 1rem;
        }

        .dashboard-card .card-count {
            display: inline-block;
            padding: 0.375rem 0.75rem;
            background: var(--bg-light);
            border-radius: var(--radius-md);
            font-weight: 600;
            font-size: 0.875rem;
            color: var(--primary);
        }

        @media (max-width: 768px) {
            .dashboard-navbar {
                padding: 1rem;
            }

            .navbar-user {
                gap: 0.5rem;
            }

            .user-name {
                display: none;
            }

            .dashboard-main {
                padding: 1rem;
            }
        }
    </style>
@endsection