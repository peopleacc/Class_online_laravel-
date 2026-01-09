@extends('layouts.guru')

@section('title', $class->name . ' - Class Online')
@section('page-title', $class->name)

@section('content')
    <!-- Class Info Card -->
    <div class="content-card" style="margin-bottom: 1.5rem;">
        <div class="card-header">
            <div>
                <h2 class="card-title">{{ $class->name }}</h2>
                <p style="color: var(--text-secondary); margin-top: 0.25rem;">
                    Kode Kelas: <strong style="font-family: monospace; color: var(--primary);">{{ $class->code }}</strong>
                </p>
            </div>
            <div style="display: flex; gap: 0.75rem;">
                <a href="{{ route('guru.classes.edit', $class) }}" class="btn btn-secondary btn-sm">✏️ Edit</a>
            </div>
        </div>
        @if($class->description)
            <div class="card-body">
                <p style="color: var(--text-secondary);">{{ $class->description }}</p>
            </div>
        @endif
    </div>

    <!-- Stats -->
    <div class="stats-grid" style="margin-bottom: 1.5rem;">
        <div class="stat-card">
            <div class="stat-icon green">👥</div>
            <div class="stat-info">
                <span class="stat-value">{{ $class->students->count() }}</span>
                <span class="stat-label">Mahasiswa Terdaftar</span>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon blue">📄</div>
            <div class="stat-info">
                <span class="stat-value">{{ $class->materials->count() }}</span>
                <span class="stat-label">Materi</span>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon orange">📝</div>
            <div class="stat-info">
                <span class="stat-value">{{ $class->assignments->count() }}</span>
                <span class="stat-label">Tugas</span>
            </div>
        </div>
    </div>

    <!-- Tabs -->
    <div class="tabs">
        <button class="tab active" onclick="showTab('materials')">📄 Materi</button>
        <button class="tab" onclick="showTab('assignments')">📝 Tugas</button>
        <button class="tab" onclick="showTab('students')">👥 Mahasiswa</button>
    </div>

    <!-- Materials Tab -->
    <div id="materials-tab" class="tab-content">
        <div class="content-card">
            <div class="card-header">
                <h3 class="card-title">Daftar Materi</h3>
                <a href="{{ route('guru.materials.create', $class) }}" class="btn btn-primary btn-sm">
                    ➕ Tambah Materi
                </a>
            </div>
            <div class="card-body">
                @if($class->materials->isEmpty())
                    <div class="empty-state">
                        <div class="empty-icon">📄</div>
                        <h3 class="empty-title">Belum Ada Materi</h3>
                        <p class="empty-description">Tambahkan materi pembelajaran untuk mahasiswa Anda.</p>
                        <a href="{{ route('guru.materials.create', $class) }}" class="btn btn-primary">Tambah Materi</a>
                    </div>
                @else
                    <div class="item-list">
                        @foreach($class->materials as $material)
                            <div class="item-card">
                                <div class="item-icon {{ $material->type }}">
                                    {{ $material->isPdf() ? '📄' : '🎬' }}
                                </div>
                                <div class="item-info">
                                    <h4 class="item-title">{{ $material->title }}</h4>
                                    <p class="item-meta">
                                        {{ $material->isPdf() ? 'PDF' : 'Video' }} •
                                        Ditambahkan {{ $material->created_at->diffForHumans() }}
                                    </p>
                                </div>
                                <div class="item-actions">
                                    <a href="{{ route('materials.download', $material) }}" class="btn btn-secondary btn-sm">⬇️
                                        Download</a>
                                    <form action="{{ route('guru.materials.destroy', $material) }}" method="POST"
                                        onsubmit="return confirm('Hapus materi ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-secondary btn-sm"
                                            style="color: var(--danger);">🗑️</button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Assignments Tab -->
    <div id="assignments-tab" class="tab-content" style="display: none;">
        <div class="content-card">
            <div class="card-header">
                <h3 class="card-title">Daftar Tugas</h3>
                <a href="{{ route('guru.assignments.create', $class) }}" class="btn btn-primary btn-sm">
                    ➕ Buat Tugas
                </a>
            </div>
            <div class="card-body">
                @if($class->assignments->isEmpty())
                    <div class="empty-state">
                        <div class="empty-icon">📝</div>
                        <h3 class="empty-title">Belum Ada Tugas</h3>
                        <p class="empty-description">Buat tugas untuk menguji pemahaman mahasiswa.</p>
                        <a href="{{ route('guru.assignments.create', $class) }}" class="btn btn-primary">Buat Tugas</a>
                    </div>
                @else
                    <div class="item-list">
                        @foreach($class->assignments as $assignment)
                            <div class="item-card">
                                <div class="item-icon assignment">📝</div>
                                <div class="item-info">
                                    <h4 class="item-title">{{ $assignment->title }}</h4>
                                    <p class="item-meta">
                                        @if($assignment->due_date)
                                            <span
                                                class="due-badge {{ $assignment->isOverdue() ? 'overdue' : ($assignment->due_date->diffInDays(now()) <= 3 ? 'soon' : 'upcoming') }}">
                                                📅 {{ $assignment->due_date->format('d M Y, H:i') }}
                                            </span>
                                        @else
                                            Tanpa batas waktu
                                        @endif
                                        • Dibuat {{ $assignment->created_at->diffForHumans() }}
                                    </p>
                                </div>
                                <div class="item-actions">
                                    <a href="{{ route('assignments.download', $assignment) }}" class="btn btn-secondary btn-sm">⬇️
                                        Download</a>
                                    <form action="{{ route('guru.assignments.destroy', $assignment) }}" method="POST"
                                        onsubmit="return confirm('Hapus tugas ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-secondary btn-sm"
                                            style="color: var(--danger);">🗑️</button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Students Tab -->
    <div id="students-tab" class="tab-content" style="display: none;">
        <div class="content-card">
            <div class="card-header">
                <h3 class="card-title">Mahasiswa Terdaftar</h3>
            </div>
            <div class="card-body">
                @if($class->students->isEmpty())
                    <div class="empty-state">
                        <div class="empty-icon">👥</div>
                        <h3 class="empty-title">Belum Ada Mahasiswa</h3>
                        <p class="empty-description">Bagikan kode kelas <strong>{{ $class->code }}</strong> kepada mahasiswa
                            untuk bergabung.</p>
                    </div>
                @else
                    <div class="item-list">
                        @foreach($class->students as $student)
                            <div class="item-card">
                                <div class="user-avatar mahasiswa" style="width: 48px; height: 48px; font-size: 1.25rem;">
                                    {{ substr($student->name, 0, 1) }}
                                </div>
                                <div class="item-info">
                                    <h4 class="item-title">{{ $student->name }}</h4>
                                    <p class="item-meta">{{ $student->email }}</p>
                                </div>
                                <div class="item-actions">
                                    <span class="item-meta">Bergabung {{ $student->pivot->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function showTab(tab) {
                // Hide all tabs
                document.querySelectorAll('.tab-content').forEach(el => el.style.display = 'none');
                document.querySelectorAll('.tab').forEach(el => el.classList.remove('active'));

                // Show selected tab
                document.getElementById(tab + '-tab').style.display = 'block';
                event.target.classList.add('active');
            }
        </script>
    @endpush
@endsection