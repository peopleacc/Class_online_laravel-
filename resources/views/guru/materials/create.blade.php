@extends('layouts.guru')

@section('title', 'Tambah Materi - Class Online')
@section('page-title', 'Tambah Materi')

@section('content')
    <div class="form-card">
        <div class="card-header">
            <h2 class="card-title">Tambah Materi ke {{ $class->name }}</h2>
        </div>
        <div class="card-body">
            <form action="{{ route('guru.materials.store', $class) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label class="form-label">Jenis Materi *</label>
                    <div class="type-selector">
                        <label class="type-option">
                            <input type="radio" name="type" value="pdf" {{ old('type', 'pdf') == 'pdf' ? 'checked' : '' }}>
                            <div class="type-card">
                                <span class="type-icon">📄</span>
                                <span class="type-label">PDF</span>
                            </div>
                        </label>
                        <label class="type-option">
                            <input type="radio" name="type" value="video" {{ old('type') == 'video' ? 'checked' : '' }}>
                            <div class="type-card">
                                <span class="type-icon">🎬</span>
                                <span class="type-label">Video</span>
                            </div>
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="title">Judul Materi *</label>
                    <input type="text" id="title" name="title" class="form-input" placeholder="Contoh: Pengenalan HTML"
                        value="{{ old('title') }}" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="description">Deskripsi</label>
                    <textarea id="description" name="description" class="form-input" rows="3"
                        placeholder="Jelaskan tentang materi ini...">{{ old('description') }}</textarea>
                </div>

                <div class="form-group">
                    <label class="form-label">Upload File *</label>
                    <label class="file-upload" id="fileUpload">
                        <div class="file-upload-icon">📁</div>
                        <div class="file-upload-text">
                            <strong>Klik untuk upload</strong> atau drag & drop<br>
                            <span id="fileHint">PDF (max 50MB) atau Video MP4/WebM (max 50MB)</span>
                        </div>
                        <input type="file" name="file" id="fileInput" accept=".pdf,.mp4,.webm,.mov" required>
                    </label>
                    <div id="fileName" style="margin-top: 0.5rem; color: var(--primary); font-weight: 500;"></div>
                </div>

                <div style="display: flex; gap: 1rem;">
                    <button type="submit" class="btn btn-primary">
                        Upload Materi
                    </button>
                    <a href="{{ route('guru.classes.show', $class) }}" class="btn btn-secondary">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            document.getElementById('fileInput').addEventListener('change', function (e) {
                if (e.target.files.length > 0) {
                    document.getElementById('fileName').textContent = '📎 ' + e.target.files[0].name;
                }
            });

            // Update file hint based on selected type
            document.querySelectorAll('input[name="type"]').forEach(radio => {
                radio.addEventListener('change', function () {
                    const hint = document.getElementById('fileHint');
                    const input = document.getElementById('fileInput');
                    if (this.value === 'pdf') {
                        hint.textContent = 'PDF (max 50MB)';
                        input.accept = '.pdf';
                    } else {
                        hint.textContent = 'Video MP4, WebM, atau MOV (max 50MB)';
                        input.accept = '.mp4,.webm,.mov';
                    }
                });
            });
        </script>
    @endpush
@endsection