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
            <table class="table table-bordered" id="dokumenTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Judul</th>
                        <th>Jenis</th>
                        <th>Tanggal Ajuan</th>
                        <th>Similarity Index</th>
                        <th>Hasil Turnitin</th>
                        <th>Tanggal Cek</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>No.</th>
                        <th>Judul</th>
                        <th>Jenis</th>
                        <th>Tanggal Ajuan</th>
                        <th>Similarity Index</th>
                        <th>Hasil Turnitin</th>
                        <th>Tanggal Cek</th>
                        <th>Aksi</th>
                    </tr>
                </tfoot>
                <tbody>
                    @if ($dokumen->count() > 0)
                    @foreach ($dokumen as $d)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $d->judul }}</td>
                        <td>{{ $d->jenis_dokumen }}</td>
                        <td>{{ $d->created_at->format('d-m-Y') }}</td>
                        <td>
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
                        <td>
                            @if($d->hasilTurnitin)
                            <a href="{{ route('mahasiswa.dokumen.download', $d->hasilTurnitin->id) }}"
                                class="btn btn-success btn-sm" download>
                                Download
                            </a>
                            @else
                            <span class="badge bg-secondary text-white">Belum di cek</span>
                            @endif
                        </td>
                        <td>
                            {{ $d->hasilTurnitin->created_at ?? '-' }}
                        </td>
                        <td>
                            <a href="{{ route('mahasiswa.dokumen.show', $d->id) }}" class="btn btn-sm btn-info"
                                title="Lihat Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                            {{-- <a href="{{ route('dokumen.edit', $d->id) }}" class="btn btn-sm btn-warning"
                                title="Edit">
                                <i class="fas fa-edit"></i>
                            </a> --}}
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