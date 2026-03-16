@extends('layouts.operator')

@section('content')

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Antrean Pengajuan Dokumen</h1>
        <a href="{{ route('operator.dokumen.export') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
    </div>

    <div class="row">
        <!-- Antrean Card -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Total Antrean (Belum Diambil)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalAntrean }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-inbox fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sedang Dikerjakan Card -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Sedang Saya Kerjakan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $sedangDikerjakan }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-spinner fa-spin fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Selesai Hari Ini Card -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Selesai Hari Ini (Keseluruhan)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $selesaiHariIni }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-check fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
                <form method="GET" action="{{ route('operator.dokumen.index') }}">
                    <div class="row mb-3">

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

                        <div class="col-md-2">
                            <select name="status" class="form-control">
                                <option value="">-- Status --</option>
                                <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending
                                </option>
                                <option value="Diproses" {{ request('status') == 'Diproses' ? 'selected' : '' }}>Diproses
                                </option>
                            </select>
                        </div>

                        <div class="col-md-2">
                            <button class="btn btn-primary">
                                <i class="fas fa-search"></i> Cari
                            </button>
                            <a href="{{ route('operator.dokumen.index') }}" class="btn btn-secondary">
                                Reset
                            </a>
                        </div>

                    </div>
                </form>
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
                                    <td>{{ $d->mahasiswa->nim }}</td>
                                    <td>{{ $d->judul }}</td>
                                    <td>{{ $d->jenis_dokumen }}</td>
                                    <td>
                                        <a href="{{ asset('storage/' . $d->file_asli) }}" download
                                            class="btn btn-success btn-sm">
                                            Download
                                        </a>
                                    </td>
                                    <td>
                                        @if ($d->status == 'Pending')
                                            <span class="badge bg-warning text-dark">{{ $d->status }}</span>
                                        @elseif($d->status == 'Diproses')
                                            <span class="badge bg-info text-white">{{ $d->status }}</span>
                                        @elseif($d->status == 'Sudah Dicek')
                                            <span class="badge bg-primary text-white">{{ $d->status }}</span>
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

                                        @if($d->status == 'Pending' && is_null($d->assigned_operator_id))
                                            <form action="{{ route('operator.dokumen.claim', $d->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-warning" title="Ambil Dokumen Ini Untuk Dikerjakan" onclick="return confirm('Anda yakin ingin mengambil alih pengecekan dokumen ini?')">
                                                    <i class="fas fa-hand-paper"></i> Kerjakan
                                                </button>
                                            </form>
                                        @elseif($d->status == 'Diproses' && $d->assigned_operator_id == Auth::id())
                                            <a href="{{ route('operator.turnitin.create', $d->id) }}"
                                                class="btn btn-sm btn-success" title="Upload Hasil Turnitin">
                                                <i class="fas fa-upload"></i> Upload Turnitin
                                            </a>
                                            {{-- operator can optionally revert to pending --}}
                                            <form action="{{ route('operator.updateStatus', $d->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="Pending">
                                                <button type="submit" class="btn btn-sm btn-danger" title="Batalkan Pengerjaan" onclick="return confirm('Apakah Anda yakin ingin melepas kembali dokumen ini ke antrean Pending?')">
                                                    <i class="fas fa-times"></i> Batal Proses
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="9" class="text-center py-4 text-muted">
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
