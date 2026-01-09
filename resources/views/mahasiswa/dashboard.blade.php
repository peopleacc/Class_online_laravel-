@extends('layouts.mahasiswa')

@section('title', 'Dashboard Mahasiswa - Class Online')
@section('page-title', 'Dashboard')

@section('content')
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon blue">📚</div>
            <div class="stat-info">
                <span class="stat-value">{{ Auth::user()->enrolledClasses()->count() }}</span>
                <span class="stat-label">Kelas Diikuti</span>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon orange">📄</div>
            <div class="stat-info">
                @php
                    $totalMaterials = 0;
                    foreach (Auth::user()->enrolledClasses as $class) {
                        $totalMaterials += $class->materials->count();
                    }
                @endphp
                <span class="stat-value">{{ $totalMaterials }}</span>
                <span class="stat-label">Materi Tersedia</span>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon purple">📝</div>
            <div class="stat-info">
                @php
                    $totalAssignments = 0;
                    foreach (Auth::user()->enrolledClasses as $class) {
                        $totalAssignments += $class->assignments->count();
                    }
                @endphp
                <span class="stat-value">{{ $totalAssignments }}</span>
                <span class="stat-label">Tugas</span>
            </div>
        </div>
    </div>

    <!-- Quick Join -->
    <div class="content-card" style="margin-bottom: 1.5rem;">
        <div class="card-header">
            <h2 class="card-title">🔑 Gabung Kelas dengan Kode</h2>
        </div>
        <div class="card-body">
            <form action="{{ route('mahasiswa.join') }}" method="POST" class="join-form">
                @csrf
                <input type="text" name="code" class="form-input" placeholder="XXXXXX" maxlength="6" required>
                <button type="submit" class="btn btn-primary">Gabung</button>
            </form>
        </div>
    </div>

    <!-- My Classes -->
    <div class="content-card">
        <div class="card-header">
            <h2 class="card-title">Kelas Saya</h2>
            <a href="{{ route('mahasiswa.classes.index') }}" class="btn btn-secondary btn-sm">Lihat Semua</a>
        </div>
        <div class="card-body">
            @php
                $myClasses = Auth::user()->enrolledClasses()->with('guru')->withCount(['materials', 'assignments'])->take(3)->get();
            @endphp

            @if($myClasses->isEmpty())
                <div class="empty-state">
                    <div class="empty-icon">📚</div>
                    <h3 class="empty-title">Belum Bergabung ke Kelas</h3>
                    <p class="empty-description">Masukkan kode kelas dari guru Anda untuk mulai belajar.</p>
                    <a href="{{ route('mahasiswa.browse') }}" class="btn btn-primary">Cari Kelas</a>
                </div>
            @else
                <div class="class-grid">
                    @foreach($myClasses as $class)
                        <div class="class-card">
                            <div class="class-card-header" style="background: linear-gradient(135deg, #047857 0%, #10b981 100%);">
                                <h3>{{ $class->name }}</h3>
                                <p style="opacity: 0.9; font-size: 0.875rem;">👨‍🏫 {{ $class->guru->name }}</p>
                            </div>
                            <div class="class-card-body">
                                <div class="class-stats">
                                    <span class="class-stat">📄 {{ $class->materials_count }} Materi</span>
                                    <span class="class-stat">📝 {{ $class->assignments_count }} Tugas</span>
                                </div>
                            </div>
                            <div class="class-card-footer">
                                <a href="{{ route('mahasiswa.classes.show', $class) }}" class="btn btn-primary btn-sm">Masuk
                                    Kelas</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection