<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Similarity Monitoring</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            color: #334155;
            background-color: #f8fafc;
        }

        /* Navbar Styling */
        .navbar {
            backdrop-filter: blur(10px);
            background-color: rgba(255, 255, 255, 0.9) !important;
            border-bottom: 1px solid rgba(226, 232, 240, 0.8);
            transition: all 0.3s ease;
        }

        .navbar-brand {
            font-weight: 800;
            background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-size: 1.5rem;
            letter-spacing: -0.5px;
        }

        .btn-custom {
            border-radius: 8px;
            font-weight: 600;
            padding: 0.5rem 1.5rem;
            transition: all 0.3s ease;
        }

        .btn-outline-primary {
            color: #4e73df;
            border-color: #4e73df;
        }

        .btn-outline-primary:hover {
            background-color: #4e73df;
            border-color: #4e73df;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(78, 115, 223, 0.2);
        }

        .btn-primary {
            background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
            border: none;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #3a5bc7 0%, #1a3a9a 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(78, 115, 223, 0.3);
        }

        /* Hero Section Styling */
        .hero-section {
            padding: 120px 0 80px;
            position: relative;
            overflow: hidden;
            background: #ffffff;
        }
        
        .hero-shape {
            position: absolute;
            top: -10%;
            right: -5%;
            width: 50vw;
            height: 50vw;
            background: radial-gradient(circle, rgba(78, 115, 223, 0.08) 0%, rgba(255, 255, 255, 0) 70%);
            border-radius: 50%;
            z-index: 0;
        }

        .hero-content {
            position: relative;
            z-index: 1;
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 1.5rem;
            color: #0f172a;
            letter-spacing: -1px;
        }
        
        .hero-title span {
            color: #4e73df;
            position: relative;
            display: inline-block;
        }
        
        .hero-title span::after {
            content: '';
            position: absolute;
            bottom: 8px;
            left: 0;
            width: 100%;
            height: 8px;
            background-color: rgba(78, 115, 223, 0.2);
            z-index: -1;
            border-radius: 4px;
        }

        .hero-subtitle {
            font-size: 1.2rem;
            font-weight: 400;
            color: #64748b;
            margin-bottom: 2.5rem;
            line-height: 1.6;
        }

        .hero-image-container {
            position: relative;
            animation: float 6s ease-in-out infinite;
        }

        .hero-image {
            width: 100%;
            max-width: 600px;
            height: auto;
            position: relative;
            z-index: 2;
        }
        
        .hero-image-backdrop {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 80%;
            height: 80%;
            background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%);
            filter: blur(40px);
            border-radius: 50%;
            z-index: 1;
            opacity: 0.6;
        }

        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-15px); }
            100% { transform: translateY(0px); }
        }

        /* Features Section */
        .features-section {
            padding: 80px 0;
            background-color: #f8fafc;
        }

        .section-header {
            margin-bottom: 60px;
        }

        .section-tag {
            display: inline-block;
            padding: 0.35rem 1rem;
            background-color: #e0e7ff;
            color: #4338ca;
            border-radius: 50px;
            font-size: 0.875rem;
            font-weight: 600;
            margin-bottom: 1rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .feature-card {
            background: #ffffff;
            border-radius: 20px;
            padding: 2.5rem 2rem;
            height: 100%;
            transition: all 0.4s ease;
            border: 1px solid #e2e8f0;
            position: relative;
            overflow: hidden;
            z-index: 1;
        }

        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, #4e73df, #36b9cc);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.4s ease;
            z-index: 2;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.05);
            border-color: transparent;
        }

        .feature-card:hover::before {
            transform: scaleX(1);
        }

        .icon-box {
            width: 70px;
            height: 70px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            margin-bottom: 1.5rem;
            transition: all 0.3s ease;
        }

        .icon-box.blue {
            background: #eff6ff;
            color: #3b82f6;
        }

        .icon-box.purple {
            background: #f5f3ff;
            color: #8b5cf6;
        }

        .icon-box.green {
            background: #f0fdf4;
            color: #22c55e;
        }

        .feature-card:hover .icon-box.blue {
            background: #3b82f6;
            color: #ffffff;
        }
        
        .feature-card:hover .icon-box.purple {
            background: #8b5cf6;
            color: #ffffff;
        }
        
        .feature-card:hover .icon-box.green {
            background: #22c55e;
            color: #ffffff;
        }

        .feature-title {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: #0f172a;
        }

        .feature-desc {
            color: #64748b;
            line-height: 1.6;
            margin: 0;
        }

        /* Stats Section */
        .stats-section {
            padding: 60px 0;
            background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
            color: white;
        }

        .stat-item {
            text-align: center;
            padding: 1rem;
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            font-size: 1rem;
            font-weight: 500;
            opacity: 0.9;
        }

        /* Footer */
        footer {
            background-color: #ffffff;
            border-top: 1px solid #e2e8f0;
            padding: 2rem 0;
        }

        /* Responsive */
        @media (max-width: 991.98px) {
            .hero-title {
                font-size: 2.5rem;
            }
            .hero-section {
                padding: 100px 0 60px;
                text-align: center;
            }
            .hero-image-container {
                margin-top: 3rem;
            }
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <i class="fas fa-layer-group me-2 text-primary"></i>
                SIMON
            </a>
            
            <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <div class="ms-auto mt-3 mt-lg-0 d-flex flex-column flex-lg-row gap-2">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="btn btn-primary btn-custom shadow-sm">
                                <i class="fas fa-columns me-2"></i>Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-outline-primary btn-custom">
                                Login
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="btn btn-primary btn-custom shadow-sm">
                                    Daftar Akun
                                </a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-shape"></div>
        <div class="container hero-content">
            <div class="row align-items-center">
                
                <div class="col-lg-6 mb-5 mb-lg-0 pe-lg-5">
                    <span class="section-tag mb-3 d-inline-block"><i class="fas fa-star me-1"></i> Sistem Repositori Terpadu</span>
                    <h1 class="hero-title">
                        Kelola Dokumen <span>Turnitin</span> Anda dengan Mudah & Aman
                    </h1>
                    <p class="hero-subtitle">
                        Platform digital untuk menyimpan, mengelola, dan melacak hasil pemeriksaan similarity dokumen akademik Anda secara terpusat dan efisien.
                    </p>
                    
                    <div class="d-flex flex-column flex-sm-row gap-3">
                        <a href="{{ route('login') }}" class="btn btn-primary btn-custom btn-lg shadow">
                            Mulai Sekarang <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                        <a href="#fitur" class="btn btn-light btn-custom btn-lg border font-weight-bold text-secondary">
                            Pelajari Fitur
                        </a>
                    </div>
                    
                    <div class="mt-5 d-flex align-items-center gap-4 text-muted small fw-semibold">
                        <div class="d-flex align-items-center"><i class="fas fa-check-circle text-success me-2"></i> Cepat</div>
                        <div class="d-flex align-items-center"><i class="fas fa-check-circle text-success me-2"></i> Aman</div>
                        <div class="d-flex align-items-center"><i class="fas fa-check-circle text-success me-2"></i> Terpusat</div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="hero-image-container text-center">
                        <div class="hero-image-backdrop"></div>
                        <img src="{{ asset('img/welcome_hero.png') }}" alt="Repositori Turnitin" class="hero-image">
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4 mb-md-0">
                    <div class="stat-item">
                        <div class="stat-number">Digital</div>
                        <div class="stat-label">Pengelolaan Dokumen File</div>
                    </div>
                </div>
                <div class="col-md-4 mb-4 mb-md-0">
                    <div class="stat-item">
                        <div class="stat-number">24/7</div>
                        <div class="stat-label">Akses Kapan Saja</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-item">
                        <div class="stat-number">Aman</div>
                        <div class="stat-label">Penyimpanan Terenkripsi</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="fitur" class="features-section">
        <div class="container">
            
            <div class="row section-header text-center justify-content-center">
                <div class="col-lg-8">
                    <span class="section-tag">Keunggulan</span>
                    <h2 class="fw-bold mb-3 display-6 text-dark">Mengapa Menggunakan Sistem Ini?</h2>
                    <p class="text-muted lead">Sistem Repositori Turnitin dirancang khusus untuk mempermudah alur kerja akademik dari pengecekan hingga pengarsipan.</p>
                </div>
            </div>

            <div class="row g-4">
                
                <!-- Feature 1 -->
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="icon-box blue">
                            <i class="fas fa-cloud-upload-alt"></i>
                        </div>
                        <h3 class="feature-title">Unggah Terpusat</h3>
                        <p class="feature-desc">Operator dapat dengan mudah mengunggah hasil pemeriksaan similarity dengan antarmuka yang intuitif dan cepat.</p>
                    </div>
                </div>

                <!-- Feature 2 -->
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="icon-box purple">
                            <i class="fas fa-download"></i>
                        </div>
                        <h3 class="feature-title">Akses Instan</h3>
                        <p class="feature-desc">Mahasiswa dan dosen dapat langsung mengunduh hasil Turnitin tanpa perlu menunggu proses manual yang memakan waktu.</p>
                    </div>
                </div>

                <!-- Feature 3 -->
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="icon-box green">
                            <i class="fas fa-server"></i>
                        </div>
                        <h3 class="feature-title">Arsip Digital Aman</h3>
                        <p class="feature-desc">Seluruh dokumen laporan Turnitin tersimpan rapi, terorganisir dengan baik, dan aman dalam basis data server repositori.</p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                    <a class="navbar-brand d-inline-flex align-items-center text-decoration-none" href="#">
                        <i class="fas fa-layer-group me-2 text-primary fs-5"></i>
                        <span class="fs-5 fw-bold text-dark">SIMON</span>
                    </a>
                </div>
                <div class="col-md-6 text-center text-md-end text-muted small">
                    &copy; {{ date('Y') }} Sistem Repositori Hasil Turnitin. All rights reserved.
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('shadow-sm');
            } else {
                navbar.classList.remove('shadow-sm');
            }
        });
    </script>
</body>

</html>