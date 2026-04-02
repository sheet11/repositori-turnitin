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

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Mahasiswa</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-sm" id="mahasiswaTable" width="100%" cellspacing="0">
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
                        @foreach($mahasiswa as $m)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $m->nim }}</td>
                            <td>{{ $m->nama }}</td>
                            <td>{{ $m->user->email ?? '-' }}</td>
                            <td>{{ $m->programStudi->nama_program_studi ?? '-' }}</td>
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
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        $('#mahasiswaTable').DataTable({
            pageLength: 10,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'
            }
        });
    });
</script>
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
