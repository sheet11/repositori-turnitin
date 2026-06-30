@extends('layouts.mahasiswa')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-6">
    <h1 class="text-2xl font-bold">Hasil Cek Turnitin</h1>
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
            <table class="table table-bordered table-hover" id="dokumenTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th class="d-none d-md-table-cell">No.</th>
                        <th>Judul</th>
                        <th class="d-none d-md-table-cell">Jenis</th>
                        <th class="d-none d-md-table-cell">Tanggal Ajuan</th>
                        <th class="text-center">Similarity Index</th>
                        <th class="text-center">Hasil Turnitin</th>
                        <th class="d-none d-md-table-cell">Tanggal Cek</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th class="d-none d-md-table-cell">No.</th>
                        <th>Judul</th>
                        <th class="d-none d-md-table-cell">Jenis</th>
                        <th class="d-none d-md-table-cell">Tanggal Ajuan</th>
                        <th class="text-center">Similarity Index</th>
                        <th class="text-center">Hasil Turnitin</th>
                        <th class="d-none d-md-table-cell">Tanggal Cek</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </tfoot>
                <tbody>
                    @if ($dokumen->count() > 0)
                    @foreach ($dokumen as $d)
                    <tr>
                        <td class="d-none d-md-table-cell">{{ $loop->iteration }}</td>
                        <td>
                            <div class="font-weight-bold text-dark text-wrap" style="min-width: 130px;">
                                {{ $d->judul }}
                            </div>
                            <!-- Sub-info khusus mobile -->
                            <div class="d-md-none text-muted small mt-1">
                                <span class="badge badge-light border text-gray-700">{{ $d->jenis_dokumen }}</span>
                                <span class="mx-1">|</span>
                                <i class="far fa-calendar-alt mr-1"></i>{{ $d->created_at->format('d-m-Y') }}
                            </div>
                        </td>
                        <td class="d-none d-md-table-cell">{{ $d->jenis_dokumen }}</td>
                        <td class="d-none d-md-table-cell">{{ $d->created_at->format('d-m-Y') }}</td>
                        <td class="text-center">
                            @if($d->hasilTurnitin)

                            @php
                            $sim = $d->hasilTurnitin->similarity_index;

                            if ($sim <= 20) { $color='success' ; } elseif ($sim <=40) { $color='warning' ; } else {
                                $color='danger' ; } @endphp <span class="badge bg-{{ $color }} text-white">
                                {{ $sim }}%
                                </span>

                                @else

                                <span class="badge bg-secondary text-white">
                                    Belum di cek
                                </span>

                                @endif
                        </td>
                        <td class="text-center">
                            @if($d->hasilTurnitin)
                            <a href="{{ route('mahasiswa.dokumen.download', $d->hasilTurnitin->id) }}"
                                class="btn btn-success btn-sm btn-block" download>
                                <i class="fas fa-download mr-1"></i> Download
                            </a>
                            @else
                            <span class="badge bg-secondary text-white">Belum di cek</span>
                            @endif
                        </td>
                        <td class="d-none d-md-table-cell">
                            {{ $d->hasilTurnitin->created_at ?? '-' }}
                        </td>
                        <td class="text-center">
                            <a href="{{ route('mahasiswa.dokumen.show', $d->id) }}" class="btn btn-sm btn-info btn-circle"
                                title="Lihat Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="8" class="text-center py-4 text-muted">
                            <i class="fas fa-inbox fa-2x mb-2 d-block text-gray-300"></i> Tidak ada dokumen yang tersedia.
                        </td>
                    </tr>
                    @endif

                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
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
@endpush

@endsection