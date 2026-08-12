@extends('layouts.operator')

@section('content')
<div class="max-w-2xl mx-auto">

    <div class="card shadow">
        <div class="card-header py-3 bg-primary">
            <h6 class="m-0 font-weight-bold text-white">Form Edit Hasil Turnitin</h6>
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

            <form action="{{ route('operator.turnitin.update', $turnitin->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="judul" class="form-label">Judul Dokumen</label>
                    <input type="text" class="form-control" id="judul" name="judul"
                        value="{{ $dokumen->judul }}" readonly>
                </div>

                <div class="mb-3">
                    <label for="similarity_index" class="form-label">Similarity Index (%) <span class="text-danger">*</span></label>
                    <input type="number" step="0.01" name="similarity_index"
                        class="form-control @error('similarity_index') is-invalid @enderror" 
                        value="{{ old('similarity_index', $turnitin->similarity_index) }}" required>
                    @error('similarity_index')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="file_laporan" class="form-label">Ganti Laporan Turnitin (PDF)</label>
                    @if ($turnitin->file_laporan)
                    <div class="mb-2">
                        <small class="text-muted d-block">File laporan saat ini:</small>
                        <a href="{{ asset('storage/' . $turnitin->file_laporan) }}" target="_blank" class="btn btn-sm btn-outline-primary mt-1">
                            <i class="fas fa-file-pdf"></i> Lihat File Saat Ini
                        </a>
                    </div>
                    @endif
                    <input type="file" name="file_laporan"
                        class="form-control @error('file_laporan') is-invalid @enderror" id="file_laporan" accept=".pdf">
                    @error('file_laporan')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                    <small class="form-text text-muted">Biarkan kosong jika tidak ingin mengubah file laporan PDF. Format yang diterima: PDF. Ukuran maksimal: 20MB.</small>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Perubahan
                    </button>
                    <a href="{{ route('operator.dokumen.riwayat') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
