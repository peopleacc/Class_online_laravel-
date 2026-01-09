@extends('layouts.mahasiswa')

@section('title', $class->name . ' - Class Online')
@section('page-title', $class->name)

@section('content')
    <!-- Class Info -->
    <div class="content-card" style="margin-bottom: 1.5rem;">
        <div class="card-header">
            <div>
                <h2 class="card-title">{{ $class->name }}</h2>
                <p style="color: var(--text-secondary); margin-top: 0.25rem;">
                    👨‍🏫 Pengajar: <strong>{{ $class->guru->name }}</strong>
                </p>
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
    </div>

    <!-- Materials Tab -->
    <div id="materials-tab" class="tab-content">
        <div class="content-card">
            <div class="card-header">
                <h3 class="card-title">Daftar Materi</h3>
            </div>
            <div class="card-body">
                @if($class->materials->isEmpty())
                    <div class="empty-state">
                        <div class="empty-icon">📄</div>
                        <h3 class="empty-title">Belum Ada Materi</h3>
                        <p class="empty-description">Guru belum menambahkan materi untuk kelas ini.</p>
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
                                    @if($material->description)
                                        <p style="color: var(--text-secondary); font-size: 0.875rem; margin-top: 0.5rem;">
                                            {{ $material->description }}
                                        </p>
                                    @endif
                                </div>
                                <div class="item-actions">
                                    <a href="{{ route('materials.download', $material) }}" class="btn btn-primary btn-sm">
                                        ⬇️ Download
                                    </a>
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
            </div>
            <div class="card-body">
                @if($class->assignments->isEmpty())
                    <div class="empty-state">
                        <div class="empty-icon">📝</div>
                        <h3 class="empty-title">Belum Ada Tugas</h3>
                        <p class="empty-description">Guru belum memberikan tugas untuk kelas ini.</p>
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
                                                📅 Deadline: {{ $assignment->due_date->format('d M Y, H:i') }}
                                                @if($assignment->isOverdue())
                                                    (Lewat)
                                                @endif
                                            </span>
                                        @else
                                            Tanpa batas waktu
                                        @endif
                                    </p>
                                    @if($assignment->description)
                                        <p style="color: var(--text-secondary); font-size: 0.875rem; margin-top: 0.5rem;">
                                            {{ $assignment->description }}
                                        </p>
                                    @endif
                                </div>
                                <div class="item-actions">
                                    <a href="{{ route('assignments.download', $assignment) }}" class="btn btn-primary btn-sm">
                                        ⬇️ Download Soal
                                    </a>
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
                document.querySelectorAll('.tab-content').forEach(el => el.style.display = 'none');
                document.querySelectorAll('.tab').forEach(el => el.classList.remove('active'));

                document.getElementById(tab + '-tab').style.display = 'block';
                event.target.classList.add('active');
            }
        </script>
    @endpush
@endsection