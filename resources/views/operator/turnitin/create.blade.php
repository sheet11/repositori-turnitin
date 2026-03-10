@extends('layouts.operator')

@section('content')
<div class="max-w-2xl mx-auto">

    <div class="card shadow">
        <div class="card-header py-3 bg-primary">
            <h6 class="m-0 font-weight-bold text-white">Form Input Hasil Turnitin</h6>
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

            <form action="{{ route('operator.turnitin.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <input type="hidden" name="dokumen_id" value="{{ $dokumen->id }}">

                <div class="mb-3">
                    <label for="judul" class="form-label">Judul Dokumen <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('judul') is-invalid @enderror" id="judul" name="judul"
                        placeholder="Masukkan judul dokumen" value="{{ old('judul', $dokumen->judul) }}" readonly>
                    @error('judul')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label>Similarity Index (%)</label>
                    <input type="number" name="similarity_index"
                        class="form-control @error('similarity_index') is-invalid @enderror" required>
                    @error('similarity_index')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label>Upload Laporan Turnitin (PDF)</label>
                    <input type="file" name="file_laporan"
                        class="form-control @error('file_laporan') is-invalid @enderror" id="file_laporan" accept=".pdf"
                        required>
                    @error('file_laporan')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                    <small class="form-text text-muted">Format yang diterima: PDF, JPG, JPEG, PNG. Ukuran
                        maksimal:5MB</small>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                    <a href="{{ route('operator.dokumen.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection