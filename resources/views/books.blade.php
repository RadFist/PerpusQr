@extends('layouts.app')

@section('title', 'Daftar Buku')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-semibold text-primary">
        <i class="bi bi-book-fill me-2"></i>Daftar Buku
    </h3>
    <a href="{{ route('books.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-1"></i>Tambah Buku
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <table class="table table-hover align-middle">
            <thead class="table-primary">
                <tr>
                    <th scope="col" width="5%">#</th>
                    <th scope="col">Judul Buku</th>
                    <th scope="col">Penulis</th>
                    <th scope="col">Penerbit</th>
                    <th scope="col">Stok</th>
                    <th scope="col" width="15%">Tahun Terbit</th>
                    <th scope="col" width="20%" class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($books as $index => $book)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $book->judul }}</td>
                    <td>{{ $book->penulis }}</td>
                    <td>{{ $book->penerbit }}</td>
                    <td>{{ $book->stok }}</td>
                    <td>{{ $book->tahun_terbit }}</td>
                    <td class="text-center">
                        <a href="{{ route('books.show', $book->id) }}" class="btn btn-sm btn-info text-white">
                            <i class="bi bi-eye"></i>
                        </a>
                        <a href="{{ route('books.edit', $book->id) }}" class="btn btn-sm btn-warning text-white">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                        <form action="{{ route('books.destroy', $book->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"
                                onclick="return confirm('Yakin ingin menghapus buku ini?')">
                                <i class="bi bi-trash3"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">
                        <i class="bi bi-journal-x display-6 d-block mb-2"></i>
                        Belum ada data buku.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection