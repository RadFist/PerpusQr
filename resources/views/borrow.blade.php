@extends('layouts.app')

@section('title', 'Peminjaman Buku')

@section('content')



<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-semibold text-primary">
        <i class="bi bi-journal-text me-2"></i>Peminjaman Buku
    </h3>
    <div class="d-flex gap-2">
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#scannerModal">
            <i class="bi bi-upc-scan"></i> Scan Kode Peminjaman
        </button>
        <a href="{{ route('borrow.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah Peminjaman
        </a>
    </div>
</div>

@if (session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif
@if (session('error'))
<div class="alert alert-danger">{{ session('error') }}</div>
@endif

<div class="card shadow-sm border-0">
    <div class="card-body">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-primary">
                <tr class="text-center">
                    <th>#</th>
                    <th>Nama Anggota</th>
                    <th>Judul Buku</th>
                    <th>Tanggal Pinjam</th>
                    <th>Tanggal Kembali</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody id="tbody_borrowing">
                @forelse ($borrowings as $borrow)
                <tr>
                    <td class="text-center">{{ $borrowings->firstItem() + $loop->index  }}</td>
                    <td>{{ $borrow->member->nama }}</td>
                    <td>{{ $borrow->book->judul }}</td>
                    <td>{{ \Carbon\Carbon::parse($borrow->tanggal_pinjam)->format('d M Y') }}</td>
                    <td>{{ $borrow->tanggal_kembali ? \Carbon\Carbon::parse($borrow->tanggal_kembali)->format('d M Y') : '-' }}</td>
                    <td class="text-center">
                        @if ($borrow->status === 'dipinjam')
                        <span class="badge bg-warning text-dark">Dipinjam</span>
                        @else
                        <span class="badge bg-success">Dikembalikan</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <a href="{{ route('borrow.edit', $borrow->id) }}" class="btn btn-sm btn-outline-success">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                        <form action="{{ route('borrow.destroy', $borrow->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Yakin ingin menghapus?')">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted">Belum ada data peminjaman</td>
                </tr>
                @endforelse

                {{ $borrowings->links('pagination::bootstrap-5') }}

            </tbody>

        </table>
    </div>
</div>

@include('components.modalLoading')
@include('components.modalCamera')
@endsection