<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Class Online - Platform Pembelajaran Digital</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>
    <div class="landing-page">
        <!-- Navbar -->
        <nav class="navbar" id="navbar">
            <div class="navbar-container">
                <a href="/" class="navbar-brand">
                    <div class="navbar-brand-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    Class Online
                </a>
                <div class="navbar-nav">
                    <a href="{{ route('login') }}" class="btn btn-outline btn-sm">Masuk</a>
                    <a href="{{ route('register') }}" class="btn btn-primary btn-sm">Daftar</a>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <section class="hero">
            <div class="hero-content">
                <div class="hero-badge">
                    🎓 Platform Pembelajaran Digital
                </div>
                <h1 class="hero-title">
                    Belajar Lebih Mudah
                    <span>Kapan Saja, Di Mana Saja</span>
                </h1>
                <p class="hero-description">
                    Class Online menghubungkan guru dan mahasiswa dalam satu platform pembelajaran yang interaktif.
                    Kelola kelas, bagikan materi, dan belajar bersama dengan mudah.
                </p>
                <div class="hero-buttons">
                    <a href="{{ route('register') }}" class="btn btn-primary btn-lg">
                        Mulai Sekarang
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>
                    </a>
                    <a href="{{ route('login') }}" class="btn btn-outline btn-lg">
                        Sudah Punya Akun
                    </a>
                </div>
                <div class="hero-stats">
                    <div class="stat-item">
                        <span class="stat-number">500+</span>
                        <span class="stat-label">Kelas Aktif</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">1000+</span>
                        <span class="stat-label">Pengguna</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">50+</span>
                        <span class="stat-label">Guru Ahli</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section class="features">
            <div class="features-container">
                <div class="section-header">
                    <h2 class="section-title">Fitur <span class="text-gradient">Unggulan</span></h2>
                    <p class="section-description">
                        Semua yang Anda butuhkan untuk pengalaman belajar online yang efektif
                    </p>
                </div>
                <div class="features-grid">
                    <div class="feature-card">
                        <div class="feature-icon">📚</div>
                        <h3 class="feature-title">Kelola Kelas</h3>
                        <p class="feature-description">
                            Buat dan kelola kelas dengan mudah. Undang mahasiswa dan atur jadwal pembelajaran.
                        </p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon">📄</div>
                        <h3 class="feature-title">Materi Digital</h3>
                        <p class="feature-description">
                            Upload dan bagikan materi pembelajaran dalam berbagai format dokumen dan video.
                        </p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon">📝</div>
                        <h3 class="feature-title">Tugas & Quiz</h3>
                        <p class="feature-description">
                            Buat tugas dan quiz interaktif untuk menguji pemahaman mahasiswa.
                        </p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon">💬</div>
                        <h3 class="feature-title">Diskusi</h3>
                        <p class="feature-description">
                            Forum diskusi untuk tanya jawab dan interaksi antara guru dan mahasiswa.
                        </p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon">📊</div>
                        <h3 class="feature-title">Progress Tracking</h3>
                        <p class="feature-description">
                            Pantau progress belajar dan lihat statistik performa secara real-time.
                        </p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon">🔔</div>
                        <h3 class="feature-title">Notifikasi</h3>
                        <p class="feature-description">
                            Dapatkan pemberitahuan untuk jadwal kelas, tugas baru, dan pengumuman.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="footer">
            <p class="footer-text">
                &copy; {{ date('Y') }} <a href="/">Class Online</a>. All rights reserved.
            </p>
        </footer>
    </div>

    <script>
        // Navbar scroll effect
        window.addEventListener('scroll', function () {
            const navbar = document.getElementById('navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
    </script>
</body>

</html>