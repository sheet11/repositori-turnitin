<p class="mb-4 text-sm text-gray-600">
    Pastikan akun Anda menggunakan kata sandi acak yang panjang agar tetap aman.
</p>

<form method="post" action="{{ route('password.update') }}">
    @csrf
    @method('put')

    <div class="form-group">
        <label for="update_password_current_password">Password Saat Ini</label>
        <input id="update_password_current_password" name="current_password" type="password" class="form-control @error('current_password', 'updatePassword') is-invalid @enderror" autocomplete="current-password">
        @error('current_password', 'updatePassword')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group">
        <label for="update_password_password">Password Baru</label>
        <input id="update_password_password" name="password" type="password" class="form-control @error('password', 'updatePassword') is-invalid @enderror" autocomplete="new-password">
        @error('password', 'updatePassword')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group">
        <label for="update_password_password_confirmation">Konfirmasi Password Baru</label>
        <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="form-control @error('password_confirmation', 'updatePassword') is-invalid @enderror" autocomplete="new-password">
        @error('password_confirmation', 'updatePassword')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="d-flex align-items-center mt-4">
        <button type="submit" class="btn btn-primary">Ubah Password</button>

        @if (session('status') === 'password-updated')
            <span class="text-success ml-3"><i class="fas fa-check-circle"></i> Berhasil diubah.</span>
        @endif
    </div>
</form>
