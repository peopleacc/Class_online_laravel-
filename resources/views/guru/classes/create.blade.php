@extends('layouts.guru')

@section('title', 'Buat Kelas - Class Online')
@section('page-title', 'Buat Kelas Baru')

@section('content')
    <div class="form-card">
        <div class="card-header">
            <h2 class="card-title">Informasi Kelas</h2>
        </div>
        <div class="card-body">
            <form action="{{ route('guru.classes.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label class="form-label" for="name">Nama Kelas *</label>
                    <input type="text" id="name" name="name" class="form-input" placeholder="Contoh: Pemrograman Web Lanjut"
                        value="{{ old('name') }}" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="description">Deskripsi Kelas</label>
                    <textarea id="description" name="description" class="form-input" rows="4"
                        placeholder="Jelaskan tentang kelas ini...">{{ old('description') }}</textarea>
                </div>

                <div style="display: flex; gap: 1rem;">
                    <button type="submit" class="btn btn-primary">
                        Buat Kelas
                    </button>
                    <a href="{{ route('guru.classes.index') }}" class="btn btn-secondary">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection