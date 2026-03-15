<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Login Sistem Turnitin</title>

    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">

                        <div class="row">

                            <div class="col-lg-6 d-none d-lg-block bg-login-image" style="background-image: url('{{ asset('img/login_bg.png') }}'); background-position: center; background-size: cover;"></div>

                            <div class="col-lg-6">
                                <div class="p-5">

                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Login Sistem</h1>
                                    </div>

                                    <form method="POST" action="{{ route('login') }}" class="user">
                                        @csrf

                                        <div class="form-group">

                                            <input type="email" name="email" class="form-control form-control-user"
                                                placeholder="Email" value="{{ old('email') }}" required>

                                            @error('email')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror

                                        </div>

                                        <div class="form-group">

                                            <input type="password" name="password"
                                                class="form-control form-control-user" placeholder="Password" required>

                                            @error('password')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror

                                        </div>

                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small">

                                                <input type="checkbox" name="remember" class="custom-control-input"
                                                    id="remember">

                                                <label class="custom-control-label" for="remember">
                                                    Remember Me
                                                </label>

                                            </div>
                                        </div>

                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                            Login
                                        </button>

                                    </form>

                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="{{ route('register') }}">
                                            Create an Account!
                                        </a>
                                    </div>
                                    @if (Route::has('password.request'))
                                    <div class="text-center">
                                        <a class="small" href="{{ route('password.request') }}">
                                            Forgot Password?
                                        </a>
                                    </div>
                                    @endif

                                </div>
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
    <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>

</body>

</html>