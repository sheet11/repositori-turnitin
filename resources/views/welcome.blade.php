<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Sistem Repositori Turnitin</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .hero {
            background: #f8f9fa;
            padding: 100px 0;
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">
                Sistem Repositori Turnitin
            </a>

            <div class="ms-auto">

                @if (Route::has('login'))

                @auth
                <a href="{{ url('/dashboard') }}" class="btn btn-primary">
                    Dashboard
                </a>
                @else

                <a href="{{ route('login') }}" class="btn btn-outline-primary me-2">
                    Login
                </a>

                @if (Route::has('register'))
                <a href="{{ route('register') }}" class="btn btn-primary">
                    Register
                </a>
                @endif

                @endauth

                @endif

            </div>
        </div>
    </nav>


    <!-- Hero -->
    <section class="hero text-center">
        <div class="container">

            <h1 class="display-5 fw-bold mb-3">
                Sistem Repositori Hasil Turnitin
            </h1>

            <p class="lead text-muted mb-4">
                Platform untuk menyimpan dan mengelola hasil pemeriksaan similarity Turnitin
                secara terpusat untuk mahasiswa dan dosen.
            </p>

            <a href="{{ route('login') }}" class="btn btn-primary btn-lg me-2">
                Login Sistem
            </a>

            @if (Route::has('register'))
            <a href="{{ route('register') }}" class="btn btn-outline-primary btn-lg">
                Daftar Akun
            </a>
            @endif

        </div>
    </section>


    <!-- Fitur -->
    <section class="py-5">
        <div class="container">

            <div class="row text-center">

                <div class="col-md-4">
                    <h5>Upload Hasil Turnitin</h5>
                    <p class="text-muted">
                        Operator dapat mengunggah hasil pemeriksaan similarity Turnitin.
                    </p>
                </div>

                <div class="col-md-4">
                    <h5>Akses Mahasiswa</h5>
                    <p class="text-muted">
                        Mahasiswa dapat mengunduh hasil Turnitin yang telah diunggah.
                    </p>
                </div>

                <div class="col-md-4">
                    <h5>Arsip Digital</h5>
                    <p class="text-muted">
                        Semua dokumen tersimpan secara rapi dalam repositori sistem.
                    </p>
                </div>

            </div>

        </div>
    </section>


    <!-- Footer -->
    <footer class="bg-light py-3">
        <div class="container text-center">
            <small class="text-muted">
                © {{ date('Y') }} Arsitin - Sistem Repositori Hasil Turnitin. All rights reserved.
            </small>
        </div>
    </footer>

</body>

</html>