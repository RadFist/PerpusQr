@extends('layouts.app')

@section('title', $title)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-semibold text-primary">
        <i class="bi bi-people-fill me-2"></i>{{ $title }}
    </h3>
    <a href="{{ route('members.create') }}" class="btn btn-primary">
        <i class="bi bi-person-plus"></i> Tambah Anggota
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-primary">
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Telepon</th>
                        <th>Alamat</th>
                        <th>Tanggal Daftar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($members as $index => $member)
                    <tr>
                        <td>{{ $members->firstItem() + $loop->index }}</td>
                        <td class="fw-semibold">{{ $member->nama }}</td>
                        <td>{{ $member->email }}</td>
                        <td>{{ $member->telepon ?? '-' }}</td>
                        <td>{{ $member->alamat ?? '-' }}</td>
                        <td>{{ \Carbon\Carbon::parse($member->tanggal_daftar)->format('d M Y') }}</td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ route('members.edit', $member->id) }}" class="btn btn-sm btn-outline-success">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <form action="{{ route('members.destroy', $member->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus anggota ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">
                            <i class="bi bi-journal-x display-6 d-block mb-2"></i>
                            Belum ada data anggota.
                        </td>
                    </tr>
                    @endforelse

                    {{ $members->links('pagination::bootstrap-5') }}

                </tbody>
            </table>
        </div>

    </div>
</div>
@include('components.modalNotif')
@endsection