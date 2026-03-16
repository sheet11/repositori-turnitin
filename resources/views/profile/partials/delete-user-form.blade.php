<p class="mb-4 text-sm text-gray-600">
    Setelah akun Anda dihapus, semua sumber daya dan datanya akan dihapus secara permanen. Harap unduh data atau informasi apa pun yang ingin Anda simpan sebelum menghapus akun.
</p>

<!-- Button trigger modal -->
<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteAccountModal">
    Hapus Akun
</button>

<!-- Modal -->
<div class="modal fade" id="deleteAccountModal" tabindex="-1" role="dialog" aria-labelledby="deleteAccountModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content border-left-danger">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold text-danger" id="deleteAccountModalLabel">Apakah Anda yakin ingin menghapus akun?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="{{ route('profile.destroy') }}">
                @csrf
                @method('delete')
                
                <div class="modal-body">
                    <p class="text-sm text-gray-600 mb-3">
                        Setelah akun Anda dihapus, semua sumber daya dan datanya akan dihapus secara permanen.<br><br>Masukkan kata sandi Anda untuk mengonfirmasi bahwa Anda ingin menghapus akun Anda.
                    </p>

                    <div class="form-group">
                        <label for="delete_password" class="sr-only">Password</label>
                        <input id="delete_password" name="password" type="password" class="form-control @error('password', 'userDeletion') is-invalid @enderror" placeholder="Password saat ini" required>
                        @error('password', 'userDeletion')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Hapus Permanen</button>
                </div>
            </form>
        </div>
    </div>
</div>

@if($errors->userDeletion->isNotEmpty())
<script>
    document.addEventListener('DOMContentLoaded', function() {
        $('#deleteAccountModal').modal('show');
    });
</script>
@endif
