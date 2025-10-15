@extends('layouts.app')

@section('title', isset($members) ? 'Edit Anggota' : 'Tambah Anggota')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-semibold text-primary">
        @if(isset($members))
        <i class="bi bi-pencil-square me-2"></i>Edit Anggota
        @else
        <i class="bi bi-person-plus-fill me-2"></i>Tambah Anggota
        @endif
    </h3>
    <a href="{{ route('members.index') }}" class="btn btn-secondary btn-sm">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <form method="POST"
            action="{{ isset($members) ? route('members.update', $members->id) : route('members.store') }}">
            @csrf
            @if(isset($members))
            @method('PUT')
            @endif

            <div class="mb-3">
                <label for="nama" class="form-label fw-semibold">Nama Lengkap</label>
                <input type="text"
                    name="nama"
                    id="nama"
                    class="form-control"
                    value="{{ old('nama', $members->nama ?? '') }}"
                    required>
                @error('nama') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label fw-semibold">Email</label>
                <input type="email"
                    name="email"
                    id="email"
                    class="form-control"
                    value="{{ old('email', $members->email ?? '') }}"
                    required>
                @error('email') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="mb-3">
                <label for="telepon" class="form-label fw-semibold">Nomor Telepon</label>
                <input type="text"
                    name="telepon"
                    id="telepon"
                    class="form-control"
                    value="{{ old('telepon', $members->telepon ?? '') }}">
                @error('telepon') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="mb-3">
                <label for="alamat" class="form-label fw-semibold">Alamat</label>
                <textarea name="alamat"
                    id="alamat"
                    rows="3"

                    class="form-control">{{ old('alamat', $members->alamat ?? '') }}</textarea>
                @error('alamat') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="mb-3">
                <label for="tanggal_daftar" class="form-label fw-semibold">Tanggal Daftar</label>
                <input name="tanggal_daftar"
                    id="tanggal_daftar"
                    type="date"
                    rows="3"
                    value="{{ old('tanggal_daftar', $members->tanggal_daftar ?? '') }}"
                    class="form-control"></input>
                @error('alamat') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="text-end">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-1"></i>
                    {{ isset($members) ? 'Perbarui' : 'Simpan' }}
                </button>
            </div>
        </form>
    </div>
</div>
@include('components.modalNotif')
@endsection