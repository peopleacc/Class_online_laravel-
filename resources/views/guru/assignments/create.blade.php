@extends('layouts.guru')

@section('title', 'Buat Tugas - Class Online')
@section('page-title', 'Buat Tugas')

@section('content')
    <div class="form-card">
        <div class="card-header">
            <h2 class="card-title">Buat Tugas untuk {{ $class->name }}</h2>
        </div>
        <div class="card-body">
            <form action="{{ route('guru.assignments.store', $class) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label class="form-label" for="title">Judul Tugas *</label>
                    <input type="text" id="title" name="title" class="form-input"
                        placeholder="Contoh: Tugas 1 - Membuat Website Sederhana" value="{{ old('title') }}" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="description">Deskripsi Tugas</label>
                    <textarea id="description" name="description" class="form-input" rows="4"
                        placeholder="Jelaskan instruksi tugas...">{{ old('description') }}</textarea>
                </div>

                <div class="form-group">
                    <label class="form-label" for="due_date">Batas Waktu Pengumpulan</label>
                    <input type="datetime-local" id="due_date" name="due_date" class="form-input"
                        value="{{ old('due_date') }}">
                    <small style="color: var(--text-secondary);">Kosongkan jika tidak ada batas waktu.</small>
                </div>

                <div class="form-group">
                    <label class="form-label">Upload File Tugas (PDF) *</label>
                    <label class="file-upload" id="fileUpload">
                        <div class="file-upload-icon">📄</div>
                        <div class="file-upload-text">
                            <strong>Klik untuk upload</strong> atau drag & drop<br>
                            <span>PDF (max 10MB)</span>
                        </div>
                        <input type="file" name="file" id="fileInput" accept=".pdf" required>
                    </label>
                    <div id="fileName" style="margin-top: 0.5rem; color: var(--primary); font-weight: 500;"></div>
                </div>

                <div style="display: flex; gap: 1rem;">
                    <button type="submit" class="btn btn-primary">
                        Buat Tugas
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
        </script>
    @endpush
@endsection