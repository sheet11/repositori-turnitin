@extends('layouts.dashboard')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-6">
        <h1 class="text-2xl font-bold">Data Dokumen</h1>
        <a href="{{ route('dokumen.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Dokumen
        </a>
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
                <form method="GET" action="{{ route('dokumen.index') }}" class="mb-3">
                <div class="row">

                    <div class="col-md-3">
                        <input type="text" name="search" class="form-control" placeholder="Judul / Nama / NIM"
                            value="{{ request('search') }}">
                    </div>

                    <div class="col-md-2">
                        <select name="tahun" class="form-control">
                            <option value="">-- Tahun --</option>
                            <option value="2024" {{ request('tahun') == '2024' ? 'selected' : '' }}>2024</option>
                            <option value="2025" {{ request('tahun') == '2025' ? 'selected' : '' }}>2025</option>
                            <option value="2026" {{ request('tahun') == '2026' ? 'selected' : '' }}>2026</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <select name="status" class="form-control">
                            <option value="">-- Status --</option>
                            <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                            <option value="Diproses" {{ request('status') == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                            <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                            <option value="Ditolak" {{ request('status') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <button class="btn btn-primary">
                            <i class="fas fa-search"></i> Cari
                        </button>

                        <a href="{{ route('dokumen.index') }}" class="btn btn-secondary">
                            Reset
                        </a>
                    </div>

                </div>
            </form>
            <table class="table table-bordered" id="dokumenTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIM</th>
                        <th>Nama</th>
                        <th>Program Studi</th>
                        <th>Judul</th>
                        <th>Jenis</th>
                        <th>Operator</th>
                        <th>Status</th>
                        <th>Tanggal Dibuat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>No</th>
                        <th>NIM</th>
                        <th>Nama</th>
                        <th>Program Studi</th>
                        <th>Judul</th>
                        <th>Jenis</th>
                        <th>Operator</th>
                        <th>Status</th>
                        <th>Tanggal Dibuat</th>
                        <th>Aksi</th>
                    </tr>
                </tfoot>
                <tbody>
                    @if ($dokumen->count() > 0)
                        @foreach ($dokumen as $d)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $d->nim }}</td>
                                <td>{{ $d->mahasiswa->nama }}</td>
                                <td>{{ optional(optional($d->mahasiswa)->programStudi)->nama_prodi ?? '-' }}</td>
                                <td>{{ $d->judul }}</td>
                                <td>{{ $d->jenis_dokumen }}</td>
                                <td>
                                    @if ($d->assigned_operator_id)
                                        {{ $d->assignedOperator->name }}
                                    @else
                                        <span class="text-muted italic">Belum Diambil</span>
                                    @endif
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
                                    <a href="{{ route('dokumen.show', $d->id) }}" class="btn btn-sm btn-info"
                                        title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('dokumen.edit', $d->id) }}" class="btn btn-sm btn-warning"
                                        title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('dokumen.destroy', $d->id) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Hapus"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus dokumen ini?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="10" class="text-center py-4 text-muted">
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
