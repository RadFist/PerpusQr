<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Register Perpustakaan')</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #4A90E2, #145DA0);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            border-top-left-radius: 1rem;
            border-top-right-radius: 1rem;
            background: #145DA0;
        }

        .card-header h4 {
            font-weight: 600;
            margin: 0;
        }

        .form-control {
            border-radius: 0.5rem;
        }

        .btn-register {
            background: #145DA0;
            color: white;
            border-radius: 0.5rem;
            transition: 0.3s;
            font-weight: 500;
        }

        .btn-register:hover {
            background: #0d3c73;
            transform: translateY(-1px);
        }

        .small-text {
            font-size: 0.9rem;
            color: #666;
        }

        .logo {
            width: 60px;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <div class="container">

        <div class="row justify-content-center align-items-center vh-100">
            <div class="col-md-5">
                <div class="card">
                    <div class="card-header text-center text-white py-3">
                        <img src="https://cdn-icons-png.flaticon.com/512/2232/2232688.png" alt="Logo" class="logo">
                        <h4>Daftar Akun Perpustakaan</h4>
                    </div>
                    <div class="card-body px-4 py-4">
                        @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @else
                        <p class="text-center small-text mb-4">Buat akun baru untuk mengakses sistem perpustakaan</p>
                        @endif

                        <form method="POST" action="/register">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Lengkap</label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="Nama lengkap Anda" required autofocus>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Alamat Email</label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="contoh@email.com" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Kata Sandi</label>
                                <input type="password" name="password" id="password" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Konfirmasi Kata Sandi</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Ulangi kata sandi" required>
                            </div>



                            <button type="submit" class="btn btn-register w-100">
                                <i class="bi bi-person-plus-fill me-1"></i> Daftar
                            </button>
                        </form>
                        <div class="text-center mt-3 small-text">
                            Sudah punya akun? <a href="/login" class="text-decoration-none text-primary fw-semibold">Masuk</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS + Icons -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</body>

</html>