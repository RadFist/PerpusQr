@extends('layouts.app')

@section('title', $title)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-semibold text-primary">
        <i class="bi {{ isset($books) ? 'bi-pencil-square' : 'bi-plus-circle' }} me-2"></i>
        {{ $title }}
    </h3>
    <a href="{{ route('books.index') }}" class="btn btn-secondary btn-sm">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form
            action="{{ isset($books) ? route('books.update', $books->id) : route('books.store') }}"
            method="POST"
            enctype="multipart/form-data">
            @csrf
            @if (isset($books))
            @method('PUT')
            @endif

            <div class="mb-3">
                <label for="judul" class="form-label fw-semibold">Judul Buku</label>
                <input
                    type="text"
                    class="form-control"
                    id="judul"
                    name="judul"
                    placeholder="Masukkan judul buku"
                    value="{{ old('judul', $books->judul ?? '') }}"
                    required>
            </div>

            <div class="mb-3">
                <label for="penulis" class="form-label fw-semibold">Penulis</label>
                <input
                    type="text"
                    class="form-control"
                    id="penulis"
                    name="penulis"
                    placeholder="Masukkan nama penulis"
                    value="{{ old('penulis', $books->penulis ?? '') }}"
                    required>
            </div>

            <div class="mb-3">
                <label for="penerbit" class="form-label fw-semibold">Penerbit</label>
                <input
                    type="text"
                    class="form-control"
                    id="penerbit"
                    name="penerbit"
                    placeholder="Masukkan nama penerbit"
                    value="{{ old('penerbit', $books->penerbit ?? '') }}"
                    required>
            </div>

            <div class="mb-3">
                <label for="tahun_terbit" class="form-label fw-semibold">Tahun Terbit</label>
                <input
                    type="number"
                    class="form-control"
                    id="tahun_terbit"
                    name="tahun_terbit"
                    placeholder="Misal: 2024"
                    value="{{ old('tahun_terbit', $books->tahun_terbit ?? '') }}"
                    min="1901"
                    max="{{ date('Y') }}"
                    required>
            </div>

            <div class="mb-3">
                <label for="stok" class="form-label fw-semibold">Stok Buku</label>
                <input
                    type="number"
                    class="form-control"
                    id="stok"
                    name="stok"
                    placeholder="Masukkan jumlah stok"
                    value="{{ old('stok', $books->stok ?? '') }}"
                    min="0"
                    required>
            </div>

            <div class="mb-3">
                <label for="cover_image" class="form-label fw-semibold">Cover Buku</label>
                <input
                    type="file"
                    class="form-control"
                    id="cover_image"
                    name="cover_image"
                    accept="image/*">
                <small class="text-muted">Opsional, format JPG/PNG, maksimal 2MB.</small>

                @if (isset($books) && $books->cover_image)
                <div class="mt-2">
                    <img src="{{ asset('img/covers/' . $books->cover_image) }}"
                        alt="Cover Buku"
                        class="img-thumbnail"
                        width="120">
                </div>
                @endif
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-{{ isset($books) ? 'warning' : 'primary' }}">
                    <i class="bi {{ isset($books) ? 'bi-pencil' : 'bi-save' }}"></i>
                    {{ isset($books) ? 'Perbarui Buku' : 'Simpan Buku' }}
                </button>
            </div>
        </form>
    </div>
</div>

@include('components.modalNotif')
@endsection