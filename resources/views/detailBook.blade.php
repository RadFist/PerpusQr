@extends('layouts.app')

@section('title', 'Detail Buku')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-semibold text-primary">
        <i class="bi bi-book me-2"></i>Detail Buku
    </h3>
    <a href="{{ route('books.index') }}" class="btn btn-outline-primary btn-sm">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="row g-0">
        <!-- Gambar Cover Buku -->
        <div class="col-md-4 text-center p-4">
            @if ($cover_image)
            <img src="{{$cover_image}}" alt="Cover Buku" class="img-fluid rounded shadow-sm" style="max-height: 350px; object-fit: cover;">
            <!-- <img src="{{ asset('storage/' . $cover_image) }}" alt="Cover Buku" class="img-fluid rounded shadow-sm" style="max-height: 350px; object-fit: cover;"> -->
            @else
            <img src="https://cdn-icons-png.flaticon.com/512/29/29302.png" alt="No Cover" class="img-fluid rounded" style="max-height: 350px;">
            @endif
        </div>

        <!-- Detail Buku -->
        <div class="col-md-8">
            <div class="card-body p-4">
                <h4 class="fw-bold text-primary mb-3">{{ $judul }}</h4>

                <table class="table table-borderless mb-4">
                    <tr>
                        <th width="30%">Penulis</th>
                        <td>: {{ $penulis }}</td>
                    </tr>
                    <tr>
                        <th>Penerbit</th>
                        <td>: {{ $penerbit }}</td>
                    </tr>
                    <tr>
                        <th>Tahun Terbit</th>
                        <td>: {{ $tahun_terbit }}</td>
                    </tr>
                    <tr>
                        <th>Stok</th>
                        <td>: {{ $stok }}</td>
                    </tr>
                </table>

                <a href="#" class="btn btn-primary me-2">
                    <i class="bi bi-journal-plus"></i> Pinjam Buku
                </a>
                <a href="{{ route('books.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali ke Daftar
                </a>
            </div>
        </div>
    </div>
</div>
@endsection