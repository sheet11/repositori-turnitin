<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pengaturan Awal Akun - SIMON</title>

    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Outfit', 'Nunito', sans-serif;
            background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
        }

        .card-setup {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
            border: none;
        }

        .gradient-brand {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 3rem;
        }

        .form-control-setup {
            border-radius: 10px;
            padding: 1.5rem 1.2rem;
            font-size: 0.9rem;
            border: 1.5px solid #d1d3e2;
            transition: all 0.2s ease-in-out;
        }

        .form-control-setup:focus {
            border-color: #4e73df;
            box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.15);
        }

        .btn-setup {
            border-radius: 10px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            background: #4e73df;
            border: none;
            transition: all 0.3s ease;
        }

        .btn-setup:hover {
            background: #2e59d9;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(78, 115, 223, 0.4);
        }

        .input-group-text-setup {
            border-top-left-radius: 10px;
            border-bottom-left-radius: 10px;
            background-color: #f8f9fc;
            border: 1.5px solid #d1d3e2;
            border-right: none;
        }

        .form-control-setup.with-icon {
            border-top-left-radius: 0;
            border-bottom-left-radius: 0;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-9 col-lg-11 col-md-10">
                <div class="card card-setup my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <!-- Left Info Panel (Hidden on mobile) -->
                            <div class="col-lg-5 d-none d-lg-flex gradient-brand text-center text-lg-left">
                                <div class="mb-4">
                                    <span class="badge badge-warning px-3 py-2" style="font-size: 0.8rem; border-radius: 30px;">
                                        <i class="fas fa-shield-alt mr-1"></i> Pengamanan Akun
                                    </span>
                                </div>
                                <h1 class="h3 font-weight-bold mb-3">Selamat Datang di SIMON!</h1>
                                <p class="text-white-50 mb-4" style="font-size: 0.95rem; line-height: 1.6;">
                                    Untuk menjamin keamanan dan kenyamanan penggunaan sistem repositori, Anda wajib melengkapi informasi profil pada login pertama Anda.
                                </p>
                                <div class="text-left text-white-50 small mt-auto">
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="bg-white-10 rounded-circle p-2 mr-3 text-center" style="width: 35px; height: 35px; background: rgba(255,255,255,0.1);">
                                            <i class="fas fa-lock text-warning"></i>
                                        </div>
                                        <span>Ganti password bawaan dengan password baru.</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="bg-white-10 rounded-circle p-2 mr-3 text-center" style="width: 35px; height: 35px; background: rgba(255,255,255,0.1);">
                                            <i class="fas fa-envelope text-info"></i>
                                        </div>
                                        <span>Konfirmasi atau perbarui alamat email untuk notifikasi pengajuan.</span>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-white-10 rounded-circle p-2 mr-3 text-center" style="width: 35px; height: 35px; background: rgba(255,255,255,0.1);">
                                            <i class="fab fa-whatsapp text-success"></i>
                                        </div>
                                        <span>Input nomor WhatsApp aktif untuk keperluan informasi.</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Right Form Panel -->
                            <div class="col-lg-7">
                                <div class="p-5">
                                    <div class="d-lg-none text-center mb-4">
                                        <h2 class="h4 font-weight-bold text-gray-900">Selamat Datang di SIMON</h2>
                                        <p class="text-muted small">Lengkapi pengaturan awal akun Anda</p>
                                    </div>

                                    <div class="text-center text-lg-left mb-4">
                                        <h2 class="h4 font-weight-bold text-gray-900 d-none d-lg-block">Lengkapi Akun Anda</h2>
                                        <p class="text-muted small">Semua field di bawah ini wajib diisi dengan benar.</p>
                                    </div>

                                    <form method="POST" action="{{ route('mahasiswa.first-login.update') }}">
                                        @csrf

                                        <!-- Alamat Email -->
                                        <div class="form-group mb-4">
                                            <label class="text-gray-700 font-weight-semibold small mb-1" for="email">
                                                <i class="fas fa-envelope mr-1 text-gray-500"></i> Konfirmasi Alamat Email
                                            </label>
                                            <input type="email" name="email" id="email" 
                                                class="form-control form-control-setup @error('email') is-invalid @enderror" 
                                                placeholder="Masukkan email aktif Anda" 
                                                value="{{ old('email', $user->email) }}" required>
                                            @error('email')
                                                <div class="invalid-feedback mt-1">{{ $message }}</div>
                                            @else
                                                <small class="form-text text-muted">Pastikan email aktif untuk notifikasi pengajuan.</small>
                                            @enderror
                                        </div>

                                        <!-- Nomor WhatsApp -->
                                        <div class="form-group mb-4">
                                            <label class="text-gray-700 font-weight-semibold small mb-1" for="whatsapp">
                                                <i class="fab fa-whatsapp mr-1 text-success"></i> Nomor WhatsApp
                                            </label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text input-group-text-setup"><i class="fas fa-phone text-gray-500"></i></span>
                                                </div>
                                                <input type="text" name="whatsapp" id="whatsapp" 
                                                    class="form-control form-control-setup with-icon @error('whatsapp') is-invalid @enderror" 
                                                    placeholder="Contoh: 081234567890" 
                                                    value="{{ old('whatsapp', $user->mahasiswa->whatsapp ?? '') }}" required>
                                                @error('whatsapp')
                                                    <div class="invalid-feedback mt-1 d-block">{{ $message }}</div>
                                                @else
                                                    <small class="form-text text-muted d-block w-100 mt-1">Masukkan nomor WhatsApp aktif untuk keperluan informasi.</small>
                                                @enderror
                                            </div>
                                        </div>

                                        <hr class="my-4">

                                        <!-- Password Baru -->
                                        <div class="form-group mb-4">
                                            <label class="text-gray-700 font-weight-semibold small mb-1" for="password">
                                                <i class="fas fa-key mr-1 text-gray-500"></i> Password Baru
                                            </label>
                                            <input type="password" name="password" id="password" 
                                                class="form-control form-control-setup @error('password') is-invalid @enderror" 
                                                placeholder="Minimal 8 karakter" required>
                                            @error('password')
                                                <div class="invalid-feedback mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Konfirmasi Password Baru -->
                                        <div class="form-group mb-4">
                                            <label class="text-gray-700 font-weight-semibold small mb-1" for="password_confirmation">
                                                <i class="fas fa-check-double mr-1 text-gray-500"></i> Ulangi Password Baru
                                            </label>
                                            <input type="password" name="password_confirmation" id="password_confirmation" 
                                                class="form-control form-control-setup" 
                                                placeholder="Konfirmasi password baru" required>
                                        </div>

                                        <!-- Submit Button -->
                                        <button type="submit" class="btn btn-primary btn-block btn-setup py-3 mt-4 text-white">
                                            Simpan & Lanjutkan <i class="fas fa-arrow-right ml-2"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>
