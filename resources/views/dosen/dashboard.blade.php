@extends('layouts.dashboard')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-6">
    <h1 class="text-2xl font-bold">Dashboard Dosen</h1>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="fas fa-check-circle"></i> {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

{{-- reuse the dokumen table partial if desired, otherwise duplicate --}}
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Dokumen Mahasiswa</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dokumenTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Judul</th>
                        <th>NIM</th>
                        <th>Jenis</th>
                        <th>Status</th>
                        <th>Tanggal Dibuat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Judul</th>
                        <th>NIM</th>
                        <th>Jenis</th>
                        <th>Status</th>
                        <th>Tanggal Dibuat</th>
                        <th>Aksi</th>
                    </tr>
                </tfoot>
                <tbody>
                    @if($dokumen->count() > 0)
                    @foreach($dokumen as $d)
                    <tr>
                        <td>{{ $d->judul }}</td>
                        <td>{{ $d->nim }}</td>
                        <td>{{ $d->jenis_dokumen }}</td>
                        <td>
                            @if($d->status == 'Pending')
                            <span class="badge bg-warning text-dark">{{ $d->status }}</span>
                            @elseif($d->status == 'Di Proses')
                            <span class="badge bg-info">{{ $d->status }}</span>
                            @elseif($d->status == 'Selesai')
                            <span class="badge bg-success">{{ $d->status }}</span>
                            @elseif($d->status == 'Ditolak')
                            <span class="badge bg-danger">{{ $d->status }}</span>
                            @else
                            <span class="badge bg-secondary">{{ $d->status }}</span>
                            @endif
                        </td>
                        <td>{{ $d->created_at->format('d-m-Y') }}</td>
                        <td>
                            <a href="{{ route('dokumen.show', $d->id) }}" class="btn btn-sm btn-info"
                                title="Lihat Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="6" class="text-center">Tidak ada dokumen ditemukan.</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection