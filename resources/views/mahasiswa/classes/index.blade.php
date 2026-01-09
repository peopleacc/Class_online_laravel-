@extends('layouts.mahasiswa')

@section('title', 'Kelas Saya - Class Online')
@section('page-title', 'Kelas Saya')

@section('content')
    @if($classes->isEmpty())
        <div class="content-card">
            <div class="card-body">
                <div class="empty-state">
                    <div class="empty-icon">📚</div>
                    <h3 class="empty-title">Belum Bergabung ke Kelas</h3>
                    <p class="empty-description">Anda belum terdaftar di kelas manapun. Cari kelas atau masukkan kode dari guru.
                    </p>
                    <a href="{{ route('mahasiswa.browse') }}" class="btn btn-primary">Cari Kelas</a>
                </div>
            </div>
        </div>
    @else
        <div class="class-grid">
            @foreach($classes as $class)
                <div class="class-card">
                    <div class="class-card-header" style="background: linear-gradient(135deg, #047857 0%, #10b981 100%);">
                        <h3>{{ $class->name }}</h3>
                        <p style="opacity: 0.9; font-size: 0.875rem;">👨‍🏫 {{ $class->guru->name }}</p>
                    </div>
                    <div class="class-card-body">
                        <p class="class-description">
                            {{ $class->description ? Str::limit($class->description, 100) : 'Tidak ada deskripsi' }}
                        </p>
                        <div class="class-stats">
                            <span class="class-stat">📄 {{ $class->materials_count }} Materi</span>
                            <span class="class-stat">📝 {{ $class->assignments_count }} Tugas</span>
                        </div>
                    </div>
                    <div class="class-card-footer">
                        <a href="{{ route('mahasiswa.classes.show', $class) }}" class="btn btn-primary btn-sm">Masuk Kelas</a>
                        <form action="{{ route('mahasiswa.leave', $class) }}" method="POST" style="display: inline;"
                            onsubmit="return confirm('Keluar dari kelas ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-secondary btn-sm">Keluar</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection