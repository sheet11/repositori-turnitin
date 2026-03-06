@extends('layouts.dashboard')

@section('content')

<div class="max-w-2xl mx-auto">
    <h1 class="text-2xl font-bold mb-6">Tambah Dokumen Baru</h1>

    <div class="card shadow">
        <div class="card-header py-3 bg-primary">
            <h6 class="m-0 font-weight-bold text-white">Form Input Dokumen</h6>
        </div>
        <div class="card-body">
            @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong> Harap memperbaiki error di bawah ini:
                <ul class="mt-2 mb-0">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <form action="{{ route('dokumen.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label for="judul" class="form-label">Judul Dokumen <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('judul') is-invalid @enderror" id="judul" name="judul"
                        placeholder="Masukkan judul dokumen" value="{{ old('judul') }}" required>
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
                        <option value="Skripsi" {{ old('jenis_dokumen')=='Skripsi' ? 'selected' : '' }}>Skripsi</option>
                        <option value="Jurnal" {{ old('jenis_dokumen')=='Jurnal' ? 'selected' : '' }}>Jurnal</option>
                        <option value="Proposal" {{ old('jenis_dokumen')=='Proposal' ? 'selected' : '' }}>Proposal
                        </option>
                        <option value="KTI" {{ old('jenis_dokumen')=='KTI' ? 'selected' : '' }}>KTI</option>
                    </select>
                    @error('jenis_dokumen')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Tampilkan NIM dari user yang login --}}
                <div class="mb-3">
                    <label for="nim" class="form-label">NIM <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="nim" name="nim" 
                        value="{{ Auth::user()->mahasiswa->nim ?? '-' }}" disabled readonly>
                    <small class="form-text text-muted">NIM diambil otomatis dari data profil Anda</small>
                </div>

                <div class="mb-3">
                    <label for="file_asli" class="form-label">File Asli (PDF) <span class="text-danger">*</span></label>
                    <input type="file" class="form-control @error('file_asli') is-invalid @enderror" id="file_asli"
                        name="file_asli" accept=".pdf,.doc,.docx" required>
                    @error('file_asli')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                    <small class="form-text text-muted">Format yang diterima: PDF, DOC, DOCX. Ukuran maksimal:
                        25MB</small>
                </div>

                <div class="mb-3">
                    <label for="bukti_bayar" class="form-label">Bukti Pembayaran (Opsional)</label>
                    <input type="file" class="form-control @error('bukti_bayar') is-invalid @enderror" id="bukti_bayar"
                        name="bukti_bayar" accept=".pdf,.jpg,.jpeg,.png">
                    @error('bukti_bayar')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                    <small class="form-text text-muted">Format yang diterima: PDF, JPG, JPEG, PNG. Ukuran maksimal:
                        5MB</small>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                    <a href="{{ route('dokumen.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection