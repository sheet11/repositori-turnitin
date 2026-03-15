@extends('layouts.operator')

@section('content')

    <div class="max-w-2xl mx-auto">
        <h1 class="text-2xl font-bold mb-6">Edit Dokumen</h1>

        <div class="card shadow">
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

                <form action="{{ route('operator.dokumen.update', $dokumen->id) }}" method="POST">
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
                            name="nim" placeholder="Masukkan NIM" value="{{ old('nim', $dokumen->nim) }}" required>
                        @error('nim')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                        <select class="form-control @error('status') is-invalid @enderror" id="status" name="status"
                            required>
                            <option value="">-- Pilih Status --</option>
                            <option value="Pending" {{ old('status', $dokumen->status) == 'Pending' ? 'selected' : '' }}>
                                Pending</option>
                            <option value="Diproses"
                                {{ old('status', $dokumen->status) == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                            <option value="Sudah Dicek" {{ old('status', $dokumen->status) == 'Sudah Dicek' ? 'selected' : '' }}>
                                Sudah Dicek</option>
                            <option value="Selesai" {{ old('status', $dokumen->status) == 'Selesai' ? 'selected' : '' }}>
                                Selesai</option>
                            <option value="Ditolak" {{ old('status', $dokumen->status) == 'Ditolak' ? 'selected' : '' }}>
                                Ditolak</option>
                        </select>
                        @error('status')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i>
                        <strong>File Asli:</strong> {{ $dokumen->file_asli ?? 'Belum ada file' }}<br>
                        <strong>Bukti Pembayaran:</strong> {{ $dokumen->bukti_bayar ?? 'Belum ada file' }}
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan Perubahan
                        </button>
                        <a href="{{ route('operator.dokumen.show', $dokumen->id) }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
