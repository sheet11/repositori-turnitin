@extends('layouts.mahasiswa')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-6">
        <h1 class="text-2xl font-bold">Riwayat Pengajuan</h1>
        {{-- <a href="{{ route('dokumen.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Dokumen
        </a> --}}
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Dokumen</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dokumenTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Judul</th>
                            <th>Jenis</th>
                            <th>Tanggal Ajuan</th>
                            <th>Hasil Turnitin</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Judul</th>
                            <th>Jenis</th>
                            <th>Tanggal Ajuan</th>
                            <th>Hasil Turnitin</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @if ($dokumen->count() > 0)
                            @foreach ($dokumen as $d)
                                <tr>
                                    <td>{{ $d->judul }}</td>
                                    <td>{{ $d->jenis_dokumen }}</td>
                                    <td>{{ $d->created_at->format('d-m-Y') }}</td>
                                    <td>Hasil</td>
                                    <td>
                                        @if ($d->status == 'Pending')
                                            <span class="badge bg-warning text-dark">{{ $d->status }}</span>
                                        @elseif($d->status == 'Diproses')
                                            <span class="badge bg-info">{{ $d->status }}</span>
                                        @elseif($d->status == 'Selesai')
                                            <span class="badge bg-success">{{ $d->status }}</span>
                                        @elseif($d->status == 'Ditolak')
                                            <span class="badge bg-danger">{{ $d->status }}</span>
                                        @else
                                            <span class="badge bg-secondary">{{ $d->status }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('dokumen.show', $d->id) }}" class="btn btn-sm btn-info"
                                            title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('dokumen.edit', $d->id) }}" class="btn btn-sm btn-warning"
                                            title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">
                                    <i class="fas fa-inbox"></i> Tidak ada dokumen yang tersedia.
                                </td>
                            </tr>
                        @endif

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#dokumenTable').DataTable({
                pageLength: 10,
                searching: true,
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'
                }
            });
        });
    </script>

@endsection
