<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Perpustakaan')</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

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

        .navbar {

            padding: 1rem 2rem;
        }

        .navbar-brand {
            color: blue !important;
            font-weight: 600;
            font-size: 1.25rem;
            margin: 0;
        }

        .navbar-nav .nav-link {
            color: blue !important;
            margin-right: 1rem;
            transition: 0.3s;
        }

        .navbar-nav .nav-link:hover,
        .navbar-nav .nav-link.active {
            color: blue !important;
            text-decoration: underline;
        }

        .btn-logout {
            color: red !important;
            background-color: rgba(255, 255, 255, 0.2);
            border: none;
            transition: 0.3s;
        }

        .btn-logout:hover {
            color: #ffff !important;
            background-color: red !important;
        }



        main {
            padding: 2rem;
            margin-top: 80px;
        }

        footer {
            text-align: center;
            color: #777;
            margin-top: 2rem;
            font-size: 0.9rem;
        }
    </style>
</head>

<body>

    <!-- Header / Navbar -->
    <nav class="navbar navbar-expand-lg ">
        <div class="w-100 d-flex justify-content-between align-items-center">

            <!-- Brand kiri -->
            <a class="navbar-brand d-none d-lg-block" href="/home">📚 Perpustakaan</a>

            <!-- Menu tengah -->
            <div id="navbarNav">
                <ul class="d-flex align-items-center gap-3 mt-2  list-unstyled">
                    <li class="nav-item">
                        <a class="btn btn-outline-primary" href="/home">
                            <i class="bi bi-house-door"></i> Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-outline-primary" href="/list-book">
                            <i class="bi bi-book"></i> Buku
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Profil kanan -->
            <div class="nav-item dropdown ms-3">
                <a
                    class="nav-link dropdown-toggle d-flex flex-column align-items-center text-white"
                    href="#"
                    id="profileDropdown"
                    role="button"
                    data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <div
                        class="rounded-circle bg-light d-flex justify-content-center align-items-center"
                        style="width: 40px; height: 40px;">
                        <i class="bi bi-person-fill text-primary fs-4"></i>
                    </div>
                    <small class="text-primary mt-1">{{ Auth::user()->name ?? 'User' }}</small>
                </a>

                <ul class="dropdown-menu dropdown-menu-end text-center" aria-labelledby="profileDropdown">
                    <li class="dropdown-item-text fw-semibold">{{ Auth::user()->email ?? 'email@user.com' }}</li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <form action="/logout" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger">
                                <i class="bi bi-box-arrow-right"></i> Keluar
                            </button>
                        </form>
                    </li>
                </ul>
            </div>

        </div>
    </nav>

    <!-- Main Content -->
    <main class="{{ Request::is('user/book/*') ? 'm-0 pt-0' : 'p-4' }}">
        @yield('content')
    </main>


    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('js/modal.js') }}"></script>

</body>

</html>