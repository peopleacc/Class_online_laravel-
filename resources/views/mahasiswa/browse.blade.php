@extends('layouts.mahasiswa')

@section('title', 'Cari Kelas - Class Online')
@section('page-title', 'Cari Kelas')

@section('content')
    <!-- Join with Code -->
    <div class="content-card" style="margin-bottom: 1.5rem;">
        <div class="card-header">
            <h2 class="card-title">🔑 Gabung dengan Kode Kelas</h2>
        </div>
        <div class="card-body">
            <p style="color: var(--text-secondary); margin-bottom: 1rem;">
                Minta kode kelas dari guru Anda, kemudian masukkan di bawah ini.
            </p>
            <form action="{{ route('mahasiswa.join') }}" method="POST" class="join-form">
                @csrf
                <input type="text" name="code" class="form-input" placeholder="Masukkan kode (6 karakter)" maxlength="6"
                    required>
                <button type="submit" class="btn btn-primary">Gabung Kelas</button>
            </form>
        </div>
    </div>

    <!-- Available Classes -->
    <div class="content-card">
        <div class="card-header">
            <h2 class="card-title">📚 Kelas Tersedia</h2>
        </div>
        <div class="card-body">
            @if($classes->isEmpty())
                <div class="empty-state">
                    <div class="empty-icon">🔍</div>
                    <h3 class="empty-title">Tidak Ada Kelas Tersedia</h3>
                    <p class="empty-description">Semua kelas sudah Anda ikuti atau belum ada kelas yang dibuat.</p>
                </div>
            @else
                <div class="class-grid">
                    @foreach($classes as $class)
                        <div class="class-card">
                            <div class="class-card-header" style="background: linear-gradient(135deg, #1e1b4b 0%, #312e81 100%);">
                                <h3>{{ $class->name }}</h3>
                                <p style="opacity: 0.9; font-size: 0.875rem;">👨‍🏫 {{ $class->guru->name }}</p>
                            </div>
                            <div class="class-card-body">
                                <p class="class-description">
                                    {{ $class->description ? Str::limit($class->description, 100) : 'Tidak ada deskripsi' }}
                                </p>
                                <div class="class-stats">
                                    <span class="class-stat">👥 {{ $class->students_count }} Mahasiswa</span>
                                </div>
                            </div>
                            <div class="class-card-footer">
                                <form action="{{ route('mahasiswa.join') }}" method="POST" style="display: inline;">
                                    @csrf
                                    <input type="hidden" name="code" value="{{ $class->code }}">
                                    <button type="submit" class="btn btn-primary btn-sm">Gabung Kelas</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection