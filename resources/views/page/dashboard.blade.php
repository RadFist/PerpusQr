@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-semibold text-primary">
        <i class="bi bi-house-door-fill me-2"></i>Dashboard
    </h3>
</div>

<div class="row g-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <i class="bi bi-book-fill text-primary display-5 mb-3"></i>
                <h5 class="fw-semibold">Jumlah Buku</h5>
                <p class="text-muted mb-0">{{$countBooks}} Buku Tersedia</p>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <i class="bi bi-people-fill text-success display-5 mb-3"></i>
                <h5 class="fw-semibold">Anggota Terdaftar</h5>
                <p class="text-muted mb-0">{{$countMembers}} Anggota</p>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <i class="bi bi-journal-text text-warning display-5 mb-3"></i>
                <h5 class="fw-semibold">Peminjaman Aktif</h5>
                <p class="text-muted mb-0">{{$countBorrowing}} Buku Sedang Dipinjam</p>
            </div>
        </div>
    </div>
</div>

<div class="mt-5">
    <h5 class="fw-semibold mb-3 text-primary">
        <i class="bi bi-clock-history me-2"></i>Riwayat Aktivitas Terbaru
    </h5>
    <ul class="list-group">
        @foreach ($dataLog as $index => $data)
        @php
        $log = $data->log;
        if (str_contains($log, 'ditambahkan')) {
        $icon = 'bi-plus-circle-fill text-primary';
        } elseif (str_contains($log, 'dihapus')) {
        $icon = 'bi-trash-fill text-danger';
        } elseif (str_contains($log, 'diedit')) {
        $icon = 'bi-exclamation-circle-fill text-warning';
        } else {
        $icon = 'bi-info-circle text-secondary';
        }
        @endphp

        <li class="list-group-item">
            <i class="bi {{ $icon }} me-2"></i> {{ $log }}
        </li>
        @endforeach
    </ul>
</div>
@endsection