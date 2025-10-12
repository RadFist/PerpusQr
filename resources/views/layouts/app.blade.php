<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Perpustakaan')</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f7f9fc;
            margin: 0;
            overflow-x: hidden;
        }

        .sidebar {
            background: linear-gradient(180deg, #145DA0, #4A90E2);
            color: white;
            width: 240px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            display: flex;
            flex-direction: column;
            padding: 1.5rem 1rem;
            transition: 0.3s;
        }

        .sidebar .brand {
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 2rem;
            text-align: center;
        }

        .sidebar a {
            color: #f1f1f1;
            text-decoration: none;
            display: block;
            padding: 10px 15px;
            border-radius: 8px;
            margin-bottom: 8px;
            transition: background 0.3s;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background: rgba(255, 255, 255, 0.2);
        }

        .sidebar i {
            margin-right: 8px;
        }

        .content {
            margin-left: 250px;
            padding: 2rem;
            transition: 0.3s;
        }

        .navbar {
            background: #fff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            padding: 0.75rem 2rem;
            border-radius: 0.5rem;
        }

        .navbar .btn {
            border-radius: 8px;
        }


        footer {
            text-align: center;
            color: #777;
            margin-top: 2rem;
            font-size: 0.9rem;
        }

        .btn-logout:hover {
            background-color: red !important;
            color: white !important;
        }

        @media (max-width: 992px) {
            .sidebar {
                position: absolute;
                left: -250px;
                z-index: 1000;
            }

            .sidebar.active {
                left: 0;
            }

            .content {
                margin-left: 0;
            }


        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="brand mb-4">
            📚 <span>Perpustakaan</span>
        </div>
        <a href="/dashboard" class="{{ request()->is('dashboard') ? 'active' : '' }}">
            <i class="bi bi-house-door-fill"></i> Dashboard
        </a>

        <a href="/books" class="{{ request()->is('books*') ? 'active' : '' }}">
            <i class="bi bi-book"></i> Data Buku
        </a>

        <a href="/members" class="{{ request()->is('members*') ? 'active' : '' }}">
            <i class="bi bi-people"></i> Data Anggota
        </a>

        <a href="/borrow" class="{{ request()->is('borrow*') ? 'active' : '' }}">
            <i class="bi bi-journal-text"></i> Peminjaman
        </a>

        <a href="/reports" class="{{ request()->is('reports*') ? 'active' : '' }}">
            <i class="bi bi-file-earmark-bar-graph"></i> Laporan
        </a>

        <hr style="border-color: rgba(255,255,255,0.3);">
        <form id="logout-form" action="/logout" method="POST" class="mt-0 d-flex justify-content-center">
            @csrf
            <button type="submit" class=" btn-logout btn btn-link text-danger text-decoration-none p-2 ">
                <i class="bi bi-box-arrow-right"></i> Keluar
            </button>
        </form>
    </div>

    <!-- Content -->
    <div class="content">
        <nav class="navbar d-flex justify-content-between align-items-center mb-4">
            <button class="btn btn-outline-primary d-lg-none" id="toggleSidebar">
                <i class="bi bi-list"></i>
            </button>
            <h5 class="mb-0 fw-semibold">@yield('title')</h5>
            <span class="text-muted small">Halo, {{ Auth::user()->name ?? 'User' }}</span>
        </nav>

        <main>
            @yield('content')
        </main>

        <footer>
            &copy; {{ date('Y') }} Sistem Perpustakaan — Rifansyah
        </footer>
    </div>

    <!-- JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>



    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/modal.js') }}"></script>

</body>
</body>

</html>