@extends('layouts.mahasiswa')

@section('content')

    <div class="row">
        <div class="col-lg-8 mx-auto">
            <h1 class="h3 font-weight-bold text-gray-800 mb-4">Edit Dokumen</h1>

            <div class="card shadow mb-4">
                <div class="card-header py-3 bg-primary">
                    <h6 class="m-0 font-weight-bold text-white">Form Edit Dokumen</h6>
                </div>
                <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Error!</strong> Harap memperbaiki error di bawah ini:
                        <ul class="mt-2 mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form action="{{ route('mahasiswa.dokumen.update', $dokumen->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="judul" class="form-label">Judul Dokumen <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('judul') is-invalid @enderror" id="judul"
                            name="judul" placeholder="Masukkan judul dokumen" value="{{ old('judul', $dokumen->judul) }}"
                            required>
                        @error('judul')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="jenis_dokumen" class="form-label">Jenis Dokumen <span
                                class="text-danger">*</span></label>
                        <select class="form-control @error('jenis_dokumen') is-invalid @enderror" id="jenis_dokumen"
                            name="jenis_dokumen" required>
                            <option value="">-- Pilih Jenis Dokumen --</option>
                            <option value="Skripsi"
                                {{ old('jenis_dokumen', $dokumen->jenis_dokumen) == 'Skripsi' ? 'selected' : '' }}>
                                Skripsi</option>
                            <option value="Jurnal"
                                {{ old('jenis_dokumen', $dokumen->jenis_dokumen) == 'Jurnal' ? 'selected' : '' }}>
                                Jurnal</option>
                            <option value="Proposal"
                                {{ old('jenis_dokumen', $dokumen->jenis_dokumen) == 'Proposal' ? 'selected' : '' }}>
                                Proposal</option>
                            <option value="KTI"
                                {{ old('jenis_dokumen', $dokumen->jenis_dokumen) == 'KTI' ? 'selected' : '' }}>KTI</option>
                        </select>
                        @error('jenis_dokumen')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="nim" class="form-label">NIM <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nim') is-invalid @enderror" id="nim"
                            name="nim" placeholder="Masukkan NIM" value="{{ old('nim', $dokumen->nim) }}" readonly>
                        @error('nim')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- File Asli -->
                    <div class="mb-3">
                        <label for="file_asli" class="form-label">Unggah Ulang File Asli (Opsional)</label>
                        <input type="file" class="form-control @error('file_asli') is-invalid @enderror" id="file_asli"
                            name="file_asli" accept=".pdf,.doc,.docx">
                        <small class="form-text text-muted">Format file: PDF, DOC, DOCX. Ukuran maks: 25MB. Kosongkan jika tidak ingin mengubah file.</small>
                        @error('file_asli')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                        @if ($dokumen->file_asli)
                            <div class="mt-2 text-xs">
                                <span class="text-secondary font-weight-bold">File aktif saat ini:</span>
                                <a href="{{ Storage::url($dokumen->file_asli) }}" target="_blank" class="text-primary font-weight-semibold">
                                    <i class="fas fa-external-link-alt mr-1"></i> {{ basename($dokumen->file_asli) }}
                                </a>
                            </div>
                        @endif
                    </div>

                    <!-- Bukti Pembayaran -->
                    <div class="mb-3">
                        <label for="bukti_bayar" class="form-label">Unggah Ulang Bukti Pembayaran (Opsional)</label>
                        <input type="file" class="form-control @error('bukti_bayar') is-invalid @enderror" id="bukti_bayar"
                            name="bukti_bayar" accept=".pdf,.jpg,.jpeg,.png">
                        <small class="form-text text-muted">Format file: PDF, JPG, JPEG, PNG. Ukuran maks: 5MB. Kosongkan jika tidak ingin mengubah bukti pembayaran.</small>
                        @error('bukti_bayar')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                        @if ($dokumen->bukti_bayar)
                            <div class="mt-2 text-xs">
                                <span class="text-secondary font-weight-bold">Bukti pembayaran saat ini:</span>
                                <a href="{{ Storage::url($dokumen->bukti_bayar) }}" target="_blank" class="text-primary font-weight-semibold">
                                    <i class="fas fa-external-link-alt mr-1"></i> {{ basename($dokumen->bukti_bayar) }}
                                </a>
                            </div>
                        @endif
                    </div>

                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan Perubahan
                        </button>
                        <a href="{{ route('mahasiswa.dokumen.show', $dokumen->id) }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
