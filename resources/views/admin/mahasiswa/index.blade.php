@extends('layouts.dashboard')

@section('content')

<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Manajemen Mahasiswa</h1>
        <div>
            <button type="button" class="btn btn-success shadow-sm me-2" data-toggle="modal" data-target="#importModal">
                <i class="fas fa-file-excel"></i> Import Mahasiswa
            </button>
            <a href="{{ route('mahasiswa.create') }}" class="btn btn-primary shadow-sm">
                <i class="fas fa-plus"></i> Tambah Mahasiswa
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Filter Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-light">
            <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-filter"></i> Filter & Pencarian</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('mahasiswa.index') }}" method="GET">
                <div class="form-row align-items-end">
                    <div class="form-group col-md-4 mb-3 mb-md-0">
                        <label for="search" class="font-weight-bold text-gray-800">Cari Mahasiswa</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="search" name="search" value="{{ request('search') }}" placeholder="Cari NIM, Nama, atau Email...">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-search"></i> Cari
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-md-3 mb-3 mb-md-0">
                        <label for="program_studi" class="font-weight-bold text-gray-800">Program Studi</label>
                        <select class="form-control" id="program_studi" name="program_studi" onchange="this.form.submit()">
                            <option value="">Semua Program Studi</option>
                            @foreach($programStudis as $prodi)
                                <option value="{{ $prodi->id }}" {{ request('program_studi') == $prodi->id ? 'selected' : '' }}>
                                    {{ $prodi->nama_prodi }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-3 mb-3 mb-md-0">
                        <label for="tahun_masuk" class="font-weight-bold text-gray-800">Tahun Masuk</label>
                        <select class="form-control" id="tahun_masuk" name="tahun_masuk" onchange="this.form.submit()">
                            <option value="">Semua Tahun Masuk</option>
                            @foreach($tahunMasuks as $tahun)
                                <option value="{{ $tahun }}" {{ request('tahun_masuk') == $tahun ? 'selected' : '' }}>
                                    {{ $tahun }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-2 mb-0">
                        <a href="{{ route('mahasiswa.index') }}" class="btn btn-secondary btn-block">
                            <i class="fas fa-undo"></i> Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Student List Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Mahasiswa</h6>
            @if(request()->anyFilled(['search', 'program_studi', 'tahun_masuk']))
                <span class="badge badge-info py-2 px-3">
                    <i class="fas fa-filter"></i> Ditemukan {{ $mahasiswa->total() }} hasil pencarian
                </span>
            @endif
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover table-sm" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIM</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Program Studi</th>
                            <th>Tahun Masuk</th>
                            <th style="width: 15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($mahasiswa as $m)
                        <tr>
                            <td>{{ ($mahasiswa->currentPage() - 1) * $mahasiswa->perPage() + $loop->iteration }}</td>
                            <td>{{ $m->nim }}</td>
                            <td>{{ $m->nama }}</td>
                            <td>{{ $m->user->email ?? '-' }}</td>
                            <td>{{ $m->programStudi->nama_prodi ?? '-' }}</td>
                            <td>{{ $m->tahun_masuk }}</td>
                            <td>
                                <a href="{{ route('mahasiswa.edit',$m->id) }}" class="btn btn-warning btn-sm" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('mahasiswa.destroy',$m->id) }}" method="POST" style="display:inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" title="Hapus" onclick="return confirm('Yakin hapus mahasiswa ini?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">
                                <i class="fas fa-info-circle fa-2x mb-2"></i>
                                <p class="mb-0">Data mahasiswa tidak ditemukan.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Server-side Pagination Links -->
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-4">
                <div class="text-muted small mb-2 mb-md-0">
                    Menampilkan {{ $mahasiswa->firstItem() ?? 0 }} sampai {{ $mahasiswa->lastItem() ?? 0 }} dari {{ $mahasiswa->total() }} mahasiswa
                </div>
                <div>
                    {{ $mahasiswa->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<!-- Client-side DataTable disabled to optimize performance with server-side pagination -->
@endpush

<!-- Modal Import -->
<div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="importModalLabel">Import Data Mahasiswa</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('mahasiswa.import') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="modal-body">
              <div class="mb-3">
                  <label for="file" class="form-label">Pilih File Excel / CSV</label>
                  <input class="form-control" type="file" id="file" name="file" accept=".xlsx,.xls,.csv" required>
                  <div class="form-text mt-2">
                      Kolom yang dibutuhkan: <strong>nim, nama, email, program_studi_id, tahun_masuk (opsional), password (opsional)</strong>
                      <br><br>
                      <a href="{{ asset('template_mahasiswa.xlsx') }}" class="btn btn-sm btn-info text-white" download>
                          <i class="fas fa-file-excel"></i> Download Template Excel
                      </a>
                  </div>
              </div>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
              <button type="submit" class="btn btn-success">Import Data</button>
          </div>
      </form>
    </div>
  </div>
</div>

@endsection
