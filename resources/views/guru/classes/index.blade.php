@extends('layouts.guru')

@section('title', 'Kelas Saya - Class Online')
@section('page-title', 'Kelas Saya')

@section('content')
    <div class="card-header" style="background: none; border: none; padding: 0; margin-bottom: 1.5rem;">
        <div></div>
        <a href="{{ route('guru.classes.create') }}" class="btn btn-primary">
            ➕ Buat Kelas Baru
        </a>
    </div>

    @if($classes->isEmpty())
        <div class="content-card">
            <div class="card-body">
                <div class="empty-state">
                    <div class="empty-icon">📚</div>
                    <h3 class="empty-title">Belum Ada Kelas</h3>
                    <p class="empty-description">Anda belum membuat kelas apapun. Mulai dengan membuat kelas pertama Anda!</p>
                    <a href="{{ route('guru.classes.create') }}" class="btn btn-primary">Buat Kelas Pertama</a>
                </div>
            </div>
        </div>
    @else
        <div class="class-grid">
            @foreach($classes as $class)
                <div class="class-card">
                    <div class="class-card-header">
                        <h3>{{ $class->name }}</h3>
                        <div class="class-code">
                            🔑 {{ $class->code }}
                        </div>
                    </div>
                    <div class="class-card-body">
                        <p class="class-description">
                            {{ $class->description ? Str::limit($class->description, 100) : 'Tidak ada deskripsi' }}
                        </p>
                        <div class="class-stats">
                            <span class="class-stat">👥 {{ $class->students_count }} Mahasiswa</span>
                            <span class="class-stat">📄 {{ $class->materials_count }} Materi</span>
                            <span class="class-stat">📝 {{ $class->assignments_count }} Tugas</span>
                        </div>
                    </div>
                    <div class="class-card-footer">
                        <a href="{{ route('guru.classes.show', $class) }}" class="btn btn-primary btn-sm">Lihat Kelas</a>
                        <a href="{{ route('guru.classes.edit', $class) }}" class="btn btn-secondary btn-sm">Edit</a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection