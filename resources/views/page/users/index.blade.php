@extends('layouts.userApp')

@section('title', 'Profil Saya')

@section('content')
<div class="container py-4">
    <div class="row g-4">
        <!-- Bagian kiri -->
        <div class="col-md-8">
            <div class="card shadow-sm border-0 p-4">
                <h5 class="fw-semibold mb-3">Statistik Akun</h5>
                <div class="row text-center">
                    <div class="col-md-4 mb-3">
                        <i class="bi bi-book fs-2 text-primary mb-2"></i>
                        <h3 class="fw-bold text-primary">{{ $borrowCount ?? 0 }}</h3>
                        <p class="text-muted mb-0">Buku Dipinjam</p>
                    </div>
                    <div class="col-md-4 mb-3">
                        <i class="bi bi-arrow-return-left fs-2 text-success mb-2"></i>
                        <h3 class="fw-bold text-success">{{ $returnedCount ?? 0 }}</h3>
                        <p class="text-muted mb-0">Buku Dikembalikan</p>
                    </div>
                    <div class="col-md-4 mb-3">
                        <i class="bi bi-alarm-fill fs-2 text-warning mb-2"></i>
                        <h3 class="fw-bold text-warning">{{ $lateCount ?? 0 }}</h3>
                        <p class="text-muted mb-0">Terlambat</p>
                    </div>
                </div>


                <hr>

                <h6 class="fw-semibold mt-4 mb-2">Status Akun</h6>
                <div class="progress mb-2" style="height: 8px;">

                    @php
                    $total = $borrowCount + $returnedCount + $lateCount;
                    $percent = $total > 0 ? (($returnedCount + $borrowCount) / $total) * 100 : 0;
                    if ($percent >= 75) {
                    $message = "Aktivitas akun kamu sangat baik! Terus pertahankan 📚";
                    $color = "success";
                    } elseif ($percent >= 50) {
                    $message = "Aktivitas akun kamu cukup baik, tetap tingkatkan ya! 💪";
                    $color = "warning";
                    } else {
                    $message = "Aktivitas akun kamu perlu diperbaiki ⚠️ sering terjadi keterlambatan.";
                    $color = "danger";
                    }
                    @endphp
                    <div class="progress-bar bg-{{ $color }}" role="progressbar" style="width: {{ $percent }}%;"
                        aria-valuenow="{{ $percent }}" aria-valuemin="0" aria-valuemax="100"></div>/
                </div>
                <small class="text-muted">
                    {{ $message }} ({{ number_format($percent, 1) }}%)
                </small>
            </div>
        </div>

        <!-- Bagian kanan -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0 text-center p-4">
                <div class="d-flex flex-column align-items-center">
                    <div class="rounded-circle overflow-hidden border border-3 border-primary mb-3"
                        style="width: 120px; height: 120px;">
                        <img src="{{ Auth::user()->avatar ?? 'data:image/jpeg;base64,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' }}"
                            alt="Foto Profil" class="img-fluid w-100 h-100 object-fit-cover">
                    </div>
                    <h6 class="fw-semibold mb-1">{{ Auth::user()->name }}</h6>
                    <p class="text-muted small mb-3">{{ Auth::user()->email }}</p>

                    <button class="btn btn-outline-primary btn-sm mb-2" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                        <i class="bi bi-pencil"></i> Ubah Profil
                    </button>
                </div>
            </div>
        </div>

        <!-- List Buku Dipinjam -->
        <div class="container my-5">
            <h4 class="fw-bold text-primary mb-4">
                <i class="bi bi-journal-bookmark me-2"></i> Buku yang Sedang Kamu Pinjam
            </h4>

            <div class="row g-4">
                @forelse($books as $borrow)
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm border-0 pt-3">
                        <!-- Cover Buku -->
                        @if(file_exists(public_path('img/covers/' . $borrow->book->cover_image)))
                        <img
                            src="{{ asset('img/covers/' . $borrow->book->cover_image) }}"
                            alt="cover book"
                            class="card-img-top rounded-top"
                            style="height: 400px;  object-fit: contain;">
                        @else
                        <div
                            class="d-flex justify-content-center align-items-center bg-light text-muted"
                            style="height: 400px; border-top-left-radius: .5rem; border-top-right-radius: .5rem;">
                            <i class="bi bi-book fs-1"></i>
                        </div>
                        @endif

                        <!-- Detail Buku -->
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title fw-semibold text-dark mb-2">{{ $borrow->book->judul }}</h5>
                            <p class="card-text text-muted mb-1">
                                <i class="bi bi-person me-1"></i> {{ $borrow->book->penulis }}
                            </p>
                            <p class="card-text text-muted mb-3">
                                <i class="bi bi-calendar-event me-1"></i>
                                Pinjam: {{ \Carbon\Carbon::parse($borrow->tanggal_pinjam)->format('d M Y') }}
                            </p>

                            @if($borrow->tanggal_kembali)
                            <span class="badge bg-success align-self-start mb-3">
                                <i class="bi bi-check-circle me-1"></i> Dikembalikan
                            </span>
                            @elseif(\Carbon\Carbon::parse($borrow->tanggal_pinjam)->addWeek()->isPast())
                            <span class="badge bg-danger align-self-start mb-3">
                                <i class="bi bi-exclamation-triangle me-1"></i> Terlambat
                            </span>
                            @else
                            <span class="badge bg-warning text-dark align-self-start mb-3">
                                <i class="bi bi-hourglass-split me-1"></i> Sedang Dipinjam
                            </span>
                            @endif


                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center py-5">
                    <i class="bi bi-emoji-frown text-secondary fs-1"></i>
                    <p class="text-muted mt-3">Kamu belum meminjam buku apa pun saat ini.</p>
                </div>
                @endforelse
            </div>
        </div>

    </div>
</div>

<!-- Modal Ubah Profil -->
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <form class="modal-content" method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="modal-header">
                <h5 class="modal-title" id="editProfileModalLabel">Ubah Profil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <input type="text" name="name" value="{{ Auth::user()->name }}" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" value="{{ Auth::user()->email }}" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Foto Profil</label>
                    <input type="file" name="avatar" class="form-control">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection