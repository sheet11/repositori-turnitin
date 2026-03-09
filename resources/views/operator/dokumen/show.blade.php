@extends('layouts.operator')

@section('content')

    <div class="max-w-4xl mx-auto">
        <div class="d-flex justify-content-between align-items-center mb-6">
            <h1 class="text-2xl font-bold">Detail Dokumen</h1>
            <a href="{{ route('operator.dokumen.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>

        <div class="card shadow">
            <div class="card-header py-3 bg-primary">
                <h6 class="m-0 font-weight-bold text-white">Informasi Dokumen</h6>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <h6 class="text-muted">Judul Dokumen</h6>
                        <p class="font-weight-bold">{{ $dokumen->judul }}</p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted">NIM</h6>
                        <p class="font-weight-bold">{{ $dokumen->nim }}</p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <h6 class="text-muted">Jenis Dokumen</h6>
                        <p class="font-weight-bold">{{ $dokumen->jenis_dokumen }}</p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted">Status</h6>
                        <p>
                            @if ($dokumen->status == 'Pending')
                                <span class="badge bg-warning text-dark">{{ $dokumen->status }}</span>
                            @elseif($dokumen->status == 'Di Proses')
                                <span class="badge bg-info">{{ $dokumen->status }}</span>
                            @elseif($dokumen->status == 'Selesai')
                                <span class="badge bg-success">{{ $dokumen->status }}</span>
                            @elseif($dokumen->status == 'Ditolak')
                                <span class="badge bg-danger">{{ $dokumen->status }}</span>
                            @else
                                <span class="badge bg-secondary">{{ $dokumen->status }}</span>
                            @endif
                        </p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <h6 class="text-muted">Tanggal Upload</h6>
                        <p class="font-weight-bold">{{ optional($dokumen->created_at)->format('d-m-Y H:i:s') }}</p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted">Terakhir Diperbarui</h6>
                        <p class="font-weight-bold">{{ optional($dokumen->updated_at)->format('d-m-Y H:i:s') }}</p>
                    </div>
                </div>

                <hr class="my-4">

                <div class="row mb-3">
                    <div class="col-md-6">
                        <h6 class="text-muted">File Asli</h6>
                        @if ($dokumen->file_asli)
                            <p>
                                <a href="{{ Storage::url($dokumen->file_asli) }}" target="_blank"
                                    class="btn btn-sm btn-info">
                                    <i class="fas fa-download"></i> Download File
                                </a>
                            </p>
                        @else
                            <p class="text-muted">Tidak ada file</p>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted">Bukti Pembayaran</h6>
                        @if ($dokumen->bukti_bayar)
                            <p>
                                <a href="{{ Storage::url($dokumen->bukti_bayar) }}" target="_blank"
                                    class="btn btn-sm btn-info">
                                    <i class="fas fa-download"></i> Download Bukti
                                </a>
                            </p>
                        @else
                            <p class="text-muted">Tidak ada bukti pembayaran</p>
                        @endif
                    </div>
                </div>

                <hr class="my-4">

                <!-- Hasil Turnitin Section -->
                @if ($dokumen->hasilTurnitin)
                    <div class="mt-4">
                        <h6 class="font-weight-bold mb-3">Hasil Turnitin</h6>
                        <div class="alert alert-info">
                            <p><strong>Similarity Score:</strong> {{ $dokumen->hasilTurnitin->similarity_index }}%</p>
                            <p><strong>Tanggal Cek:</strong>
                                {{ $dokumen->hasilTurnitin->tanggal_cek->format('d-m-Y H:i:s') }}
                            </p>
                            @if ($dokumen->hasilTurnitin->file_laporan)
                                <p>
                                    <a href="{{ Storage::url($dokumen->hasilTurnitin->file_laporan) }}" target="_blank"
                                        class="btn btn-sm btn-primary">
                                        <i class="fas fa-file-pdf"></i> Lihat Laporan Turnitin
                                    </a>
                                </p>
                            @endif
                        </div>
                    </div>
                @endif

                <div class="mt-4 d-flex gap-2">
                    <a href="{{ route('operator.dokumen.edit', $dokumen->id) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <form action="{{ route('operator.dokumen.destroy', $dokumen->id) }}" method="POST"
                        style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger"
                            onclick="return confirm('Apakah Anda yakin ingin menghapus dokumen ini?')">
                            <i class="fas fa-trash"></i> Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
