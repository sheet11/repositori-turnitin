<p class="mb-4 text-sm text-gray-600">
    Perbarui informasi profil dan alamat surel akun Anda.
</p>

<form id="send-verification" method="post" action="{{ route('verification.send') }}">
    @csrf
</form>

<form method="post" action="{{ route('profile.update') }}">
    @csrf
    @method('patch')

    <div class="form-group">
        <label for="name">Nama Lengkap</label>
        <input id="name" name="name" type="text" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
        @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group">
        <label for="email">Alamat Email</label>
        <input id="email" name="email" type="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required autocomplete="username">
        @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror

        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
            <div>
                <p class="text-sm mt-2 text-warning">
                    Alamat email Anda belum diverifikasi.
                    <button form="send-verification" class="btn btn-link p-0 m-0 align-baseline text-warning">
                        <u>Klik di sini untuk mengirim ulang email verifikasi.</u>
                    </button>
                </p>

                @if (session('status') === 'verification-link-sent')
                    <p class="mt-2 text-success">
                        Tautan verifikasi baru telah dikirimkan ke alamat email Anda.
                    </p>
                @endif
            </div>
        @endif
    </div>

    <div class="d-flex align-items-center mt-4">
        <button type="submit" class="btn btn-primary">Simpan Profil</button>

        @if (session('status') === 'profile-updated')
            <span class="text-success ml-3"><i class="fas fa-check-circle"></i> Berhasil disimpan.</span>
        @endif
    </div>
</form>
