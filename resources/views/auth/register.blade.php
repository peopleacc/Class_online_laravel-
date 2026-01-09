@extends('layouts.app')

@section('title', 'Daftar - Class Online')

@section('content')
    <div class="auth-container">
        <div class="auth-card card card-glass">
            <div class="auth-header">
                <div class="auth-logo">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
                <h1 class="auth-title">Buat Akun Baru</h1>
                <p class="auth-subtitle">Pilih peran dan daftar untuk memulai</p>
            </div>

            @if ($errors->any())
                <div class="alert alert-error">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form class="auth-form" method="POST" action="{{ route('register') }}">
                @csrf

                <div class="form-group">
                    <label class="form-label">Daftar Sebagai</label>
                    <div class="role-selector">
                        <label class="role-option">
                            <input type="radio" name="role" value="guru" {{ old('role') == 'guru' ? 'checked' : '' }}
                                required>
                            <div class="role-card">
                                <span class="role-icon">👨‍🏫</span>
                                <span class="role-title">Guru</span>
                                <span class="role-desc">Mengajar & kelola kelas</span>
                            </div>
                        </label>
                        <label class="role-option">
                            <input type="radio" name="role" value="mahasiswa" {{ old('role', 'mahasiswa') == 'mahasiswa' ? 'checked' : '' }}>
                            <div class="role-card">
                                <span class="role-icon">👨‍🎓</span>
                                <span class="role-title">Mahasiswa</span>
                                <span class="role-desc">Belajar & ikuti kelas</span>
                            </div>
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="name">Nama Lengkap</label>
                    <input type="text" id="name" name="name" class="form-input" placeholder="Masukkan nama lengkap Anda"
                        value="{{ old('name') }}" required autofocus>
                </div>

                <div class="form-group">
                    <label class="form-label" for="email">Email</label>
                    <input type="email" id="email" name="email" class="form-input" placeholder="Masukkan email Anda"
                        value="{{ old('email') }}" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="password">Password</label>
                    <input type="password" id="password" name="password" class="form-input" placeholder="Minimal 8 karakter"
                        required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="password_confirmation">Konfirmasi Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-input"
                        placeholder="Ulangi password Anda" required>
                </div>

                <button type="submit" class="btn btn-primary btn-lg" style="width: 100%;">
                    Daftar Sekarang
                </button>
            </form>

            <div class="auth-footer">
                <p>Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a></p>
            </div>
        </div>
    </div>
@endsection