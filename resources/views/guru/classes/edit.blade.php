@extends('layouts.guru')

@section('title', 'Edit Kelas - Class Online')
@section('page-title', 'Edit Kelas')

@section('content')
    <div class="form-card">
        <div class="card-header">
            <h2 class="card-title">Edit Informasi Kelas</h2>
        </div>
        <div class="card-body">
            <form action="{{ route('guru.classes.update', $class) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label class="form-label" for="name">Nama Kelas *</label>
                    <input type="text" id="name" name="name" class="form-input" value="{{ old('name', $class->name) }}"
                        required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="description">Deskripsi Kelas</label>
                    <textarea id="description" name="description" class="form-input"
                        rows="4">{{ old('description', $class->description) }}</textarea>
                </div>

                <div class="form-group">
                    <label class="form-label">Kode Kelas</label>
                    <input type="text" class="form-input" value="{{ $class->code }}" disabled
                        style="background: var(--bg-light); font-family: monospace; font-weight: 600;">
                    <small style="color: var(--text-secondary);">Kode kelas tidak dapat diubah.</small>
                </div>

                <div style="display: flex; gap: 1rem; margin-top: 1.5rem;">
                    <button type="submit" class="btn btn-primary">
                        Simpan Perubahan
                    </button>
                    <a href="{{ route('guru.classes.show', $class) }}" class="btn btn-secondary">
                        Batal
                    </a>
                </div>
            </form>

            <hr style="margin: 2rem 0; border: none; border-top: 1px solid #e5e7eb;">

            <div
                style="background: rgba(239, 68, 68, 0.05); padding: 1.5rem; border-radius: var(--radius-lg); border: 1px solid rgba(239, 68, 68, 0.2);">
                <h4 style="color: var(--danger); margin-bottom: 0.5rem;">⚠️ Zona Berbahaya</h4>
                <p style="color: var(--text-secondary); font-size: 0.875rem; margin-bottom: 1rem;">
                    Menghapus kelas akan menghapus semua materi, tugas, dan data mahasiswa terdaftar.
                </p>
                <form action="{{ route('guru.classes.destroy', $class) }}" method="POST"
                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus kelas ini? Semua data akan hilang!')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-secondary"
                        style="color: var(--danger); border-color: var(--danger);">
                        🗑️ Hapus Kelas
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection