@extends('layouts.app')

@section('title', isset($borrow) ? 'Edit Peminjaman' : 'Tambah Peminjaman')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-semibold text-primary">
        <i class="bi bi-journal-text me-2"></i>
        {{ isset($borrow) ? 'Edit Peminjaman Buku' : 'Tambah Peminjaman Buku' }}
    </h3>
    <a href="{{ route('borrow.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

@if ($errors->any())
<div class="alert alert-danger">
    <ul class="mb-0">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <form action="{{ isset($borrow) ? route('borrow.update', $borrow->id) : route('borrow.store') }}" method="POST">
            @csrf
            @if (isset($borrow))
            @method('PUT')
            @endif

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="member_id" class="form-label fw-semibold">Nama Anggota</label>
                    <select name="member_id" id="member_id" class="form-select" required>
                        <option value="">-- Pilih Anggota --</option>
                        @foreach ($members as $member)
                        <option value="{{ $member->id }}"
                            {{ isset($borrow) && $borrow->member_id == $member->id ? 'selected' : '' }}>
                            {{ $member->nama }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label for="book_id" class="form-label fw-semibold">Judul Buku</label>
                    <select name="book_id" id="book_id" class="form-select" required>
                        <option value="">-- Pilih Buku --</option>
                        @foreach ($books as $book)
                        <option value="{{ $book->id }}"
                            {{ isset($borrow) && $borrow->book_id == $book->id ? 'selected' : '' }}>
                            {{ $book->judul }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="tanggal_pinjam" class="form-label fw-semibold">Tanggal Pinjam</label>
                    <input type="date" name="tanggal_pinjam" id="tanggal_pinjam"
                        class="form-control"
                        value="{{ old('tanggal_pinjam', isset($borrow) ? $borrow->tanggal_pinjam : now()->toDateString()) }}"
                        required>
                </div>

                @if (isset($borrow))
                <div class="col-md-6">
                    <label for="tanggal_kembali" class="form-label fw-semibold">Tanggal Kembali</label>
                    <input type="date" name="tanggal_kembali" id="tanggal_kembali"
                        class="form-control"
                        value="{{ old('tanggal_kembali', isset($borrow) ? $borrow->tanggal_kembali : '') }}">
                </div>
                @endif
            </div>

            <div class="mb-3">
                <label for="status" class="form-label fw-semibold">Status</label>
                <select name="status" id="status" class="form-select">
                    <option value="dipinjam" {{ isset($borrow) && $borrow->status == 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                    @if (isset($borrow))
                    <option value="dikembalikan" {{ isset($borrow) && $borrow->status == 'dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                    @endif
                </select>
            </div>

            <div class="text-end">
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-save"></i>
                    {{ isset($borrow) ? 'Perbarui Data' : 'Simpan Data' }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection