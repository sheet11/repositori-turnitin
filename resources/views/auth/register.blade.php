<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register</title>

    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">
</head>

<body class="bg-gradient-primary">

    <div class="container">

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <div class="row">

                    <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>

                    <div class="col-lg-7">
                        <div class="p-5">

                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Create an Account</h1>
                            </div>

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form method="POST" action="{{ route('register') }}">
                                @csrf

                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user" name="name"
                                        placeholder="Full Name" value="{{ old('name') }}" required>
                                </div>

                                <div class="form-group">
                                    <input type="email" class="form-control form-control-user" name="email"
                                        placeholder="Email Address" value="{{ old('email') }}" required>
                                </div>

                                <div class="form-group">
                                    <select name="role_id" id="role_id" class="form-control">
                                        <option value="">Pilih Role</option>
                                        <option value="3">Mahasiswa</option>
                                        <option value="4">Dosen</option>
                                    </select>
                                </div>

                                <div class="form-group" id="nim-field" style="display:none;">
                                    <input type="text" class="form-control form-control-user" name="nim"
                                        id="nim" placeholder="NIM">
                                </div>

                                <div class="form-group" id="program-studi-field" style="display:none;">
                                    <select name="program_studi_id" id="program_studi_id" class="form-control">
                                        <option value="">Pilih Program Studi</option>
                                        @foreach ($programStudis as $prodi)
                                            <option value="{{ $prodi->id }}">{{ $prodi->nama_prodi }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group" id="nidn-field" style="display:none;">
                                    <input type="text" class="form-control form-control-user" name="nidn"
                                        id="nidn" placeholder="NIDN">
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="password" class="form-control form-control-user" name="password"
                                            placeholder="Password" required>
                                    </div>

                                    <div class="col-sm-6">
                                        <input type="password" class="form-control form-control-user"
                                            name="password_confirmation" placeholder="Repeat Password" required>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary btn-user btn-block">
                                    Register Account
                                </button>

                            </form>

                            <hr>

                            <div class="text-center">
                                <a class="small" href="{{ route('login') }}">
                                    Already have an account? Login!
                                </a>
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

    <script>
        document.getElementById('role_id').addEventListener('change', function() {

            let role = this.value;

            let nim = document.getElementById('nim-field');
            let nidn = document.getElementById('nidn-field');
            let prodi = document.getElementById('program-studi-field');

            if (role == 3) {
                nim.style.display = 'block';
                prodi.style.display = 'block';
                nidn.style.display = 'none';
            } else if (role == 4) {
                nim.style.display = 'none';
                prodi.style.display = 'none';
                nidn.style.display = 'block';
            } else {
                nim.style.display = 'none';
                nidn.style.display = 'none';
                prodi.style.display = 'none';
            }

        });
    </script>

</body>

</html>
