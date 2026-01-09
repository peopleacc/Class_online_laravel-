@extends('layouts.guru')

@section('title', 'Dashboard Guru - Class Online')
@section('page-title', 'Dashboard')

@section('content')
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon blue">📚</div>
            <div class="stat-info">
                <span class="stat-value">{{ Auth::user()->ownedClasses()->count() }}</span>
                <span class="stat-label">Total Kelas</span>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green">👥</div>
            <div class="stat-info">
                <span
                    class="stat-value">{{ Auth::user()->ownedClasses()->withCount('students')->get()->sum('students_count') }}</span>
                <span class="stat-label">Total Mahasiswa</span>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon orange">📄</div>
            <div class="stat-info">
                <span
                    class="stat-value">{{ Auth::user()->ownedClasses()->withCount('materials')->get()->sum('materials_count') }}</span>
                <span class="stat-label">Total Materi</span>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon purple">📝</div>
            <div class="stat-info">
                <span
                    class="stat-value">{{ Auth::user()->ownedClasses()->withCount('assignments')->get()->sum('assignments_count') }}</span>
                <span class="stat-label">Total Tugas</span>
            </div>
        </div>
    </div>

    <div class="content-card">
        <div class="card-header">
            <h2 class="card-title">Kelas Terbaru</h2>
            <a href="{{ route('guru.classes.create') }}" class="btn btn-primary btn-sm">
                ➕ Buat Kelas
            </a>
        </div>
        <div class="card-body">
            @php
                $recentClasses = Auth::user()->ownedClasses()->withCount(['students', 'materials', 'assignments'])->latest()->take(3)->get();
            @endphp

            @if($recentClasses->isEmpty())
                <div class="empty-state">
                    <div class="empty-icon">📚</div>
                    <h3 class="empty-title">Belum Ada Kelas</h3>
                    <p class="empty-description">Mulai buat kelas pertama Anda untuk mengajar mahasiswa.</p>
                    <a href="{{ route('guru.classes.create') }}" class="btn btn-primary">Buat Kelas Pertama</a>
                </div>
            @else
                <div class="class-grid">
                    @foreach($recentClasses as $class)
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
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection