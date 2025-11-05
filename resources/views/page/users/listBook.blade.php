@extends('layouts.userApp')

@section('title', 'List Buku')

@section('content')
<div class="container mt-3">
    <!-- Header -->
    <div class="text-center mb-5">
        <h2 class="fw-bold text-primary">📚 Daftar Buku</h2>
        <p class="text-muted">Temukan berbagai koleksi buku yang tersedia di perpustakaan kami.</p>
    </div>

    <!-- Search Bar -->
    <div class="row justify-content-center mb-4">
        <div class="col-md-6">
            <form method="GET" action="{{ url('/list-book') }}">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Cari judul atau penulis..."
                        value="{{ request('search') }}">
                    <button class="btn btn-primary" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Daftar Buku -->
    <div class="row">
        @forelse($books as $book)

        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm border-0 pt-3">
                @if(file_exists(public_path('img/covers/' . $book->cover_image)))
                <img
                    src="{{ asset('img/covers/' . $book->cover_image) }}"
                    alt="cover book"
                    class="card-img-top"
                    style="height: 400px;  object-fit: contain;">
                @else
                <div
                    class="d-flex justify-content-center align-items-center bg-light text-muted"
                    style="height: 400px; border: 1px dashed #ccc;">
                    400x416
                </div>
                @endif

                <div class="card-body d-flex flex-column">
                    <h5 class="card-title text-primary fw-semibold">{{ $book->judul }}</h5>
                    <p class="card-text text-muted mb-1">
                        <i class="bi bi-person"></i> {{ $book->penulis }}
                    </p>
                    <p class="card-text text-muted mb-2">
                        <i class="bi bi-book"></i> {{ $book->stok }}
                    </p>
                    <p class="text-secondary flex-grow-1">{{ Str::limit($book->deskripsi, 80) }}</p>

                    <a href="{{ route('detaiBookUser', $book->id) }}" class="btn btn-outline-primary mt-auto w-100">
                        <i class="bi bi-eye"></i> Lihat Detail
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center mt-4">
            <i class="bi bi-emoji-frown text-secondary fs-1"></i>
            <p class="text-muted mt-2">Belum ada buku yang tersedia.</p>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        {{ $books->links('pagination::bootstrap-5') }}
    </div>
</div>

@include('components.modalNotif')
@endsection