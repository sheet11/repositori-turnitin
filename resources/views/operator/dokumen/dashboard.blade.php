@extends('layouts.operator')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-6">
    <h1 class="text-2xl font-bold">Dashboard Operator</h1>
    {{-- operators don't need to add new documents --}}
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
                        <th>No</th>
                        <th>Nama</th>
                        <th>NIM</th>
                        <th>Judul</th>
                        <th>Jenis</th>
                        <th>File</th>
                        <th>Status</th>
                        <th>Tanggal Pengajuan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>NIM</th>
                        <th>Judul</th>
                        <th>Jenis</th>
                        <th>File</th>
                        <th>Status</th>
                        <th>Tanggal Pengajuan</th>
                        <th>Aksi</th>
                    </tr>
                </tfoot>
                <tbody>
                    @if ($dokumen->count() > 0)
                    @foreach ($dokumen as $d)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $d->mahasiswa->nama }}</td>
                        <td>{{ $d->nim }}</td>
                        <td>{{ $d->judul }}</td>
                        <td>{{ $d->jenis_dokumen }}</td>
                        <td>
                            <a href="{{ route('operator.dokumen.download', $d->id) }}" target="_blank"
                                class="btn btn-sm btn-primary">
                                <i class="fas fa-download"></i> Download
                            </a>
                        </td>
                        <td>
                            @if ($d->status == 'Pending')
                            <span class="badge bg-warning text-dark">{{ $d->status }}</span>
                            @elseif($d->status == 'Diproses')
                            <span class="badge bg-info text-white">{{ $d->status }}</span>
                            @elseif($d->status == 'Selesai')
                            <span class="badge bg-success text-white">{{ $d->status }}</span>
                            @elseif($d->status == 'Ditolak')
                            <span class="badge bg-danger text-white">{{ $d->status }}</span>
                            @else
                            <span class="badge bg-secondary text-white">{{ $d->status }}</span>
                            @endif
                        </td>
                        <td>{{ $d->created_at->format('d-m-Y') }}</td>
                        <td>
                            <a href="{{ route('operator.dokumen.show', $d->id) }}" class="btn btn-sm btn-info"
                                title="Lihat Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('operator.turnitin.create', $d->id) }}" class="btn btn-sm btn-success"
                                title="Upload Hasil Turnitin">
                                <i class="fas fa-upload"></i>
                            </a>
                            {{-- allow operator to change status quickly --}}
                            <form action="{{ route('operator.updateStatus', $d->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <select name="status" onchange="this.form.submit()"
                                    class="btn btn-primary dropdown-toggle">
                                    <option class="dropdown-item" value="Pending" {{ $d->status == 'Pending' ?
                                        'selected' : '' }}>Pending</option>
                                    <option class="dropdown-item" value="Diproses" {{ $d->status == 'Diproses' ?
                                        'selected' : '' }}>
                                        Di Proses
                                    </option>
                                    <option class="dropdown-item" value="Selesai" {{ $d->status == 'Selesai' ?
                                        'selected' : '' }}>Selesai</option>
                                    <option class="dropdown-item" value="Ditolak" {{ $d->status == 'Ditolak' ?
                                        'selected' : '' }}>Ditolak</option>
                                </select>
                            </form>
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