@extends('layouts.dashboard')

@section('content')

<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">User Management</h1>
        <div>
            <button type="button" class="btn btn-success shadow-sm me-2" data-toggle="modal" data-target="#importModal">
                <i class="fas fa-file-excel"></i> Import Mahasiswa
            </button>
            <a href="{{ route('users.create') }}" class="btn btn-primary shadow-sm">
                <i class="fas fa-plus"></i> Tambah User
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
            <h6 class="m-0 font-weight-bold text-primary">Daftar User</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-sm" id="usersTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th style="width: 15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $u)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $u->name }}</td>
                            <td>{{ $u->email }}</td>
                            <td>
                                @if($u->role->nama_role == 'Admin')
                                    <span class="badge badge-primary">{{ $u->role->nama_role }}</span>
                                @elseif($u->role->nama_role == 'Operator')
                                    <span class="badge badge-success">{{ $u->role->nama_role }}</span>
                                @elseif($u->role->nama_role == 'Dosen')
                                    <span class="badge badge-info">{{ $u->role->nama_role }}</span>
                                @else
                                    <span class="badge badge-secondary">{{ $u->role->nama_role }}</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('users.edit',$u->id) }}" class="btn btn-warning btn-sm" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('users.delete',$u->id) }}" method="POST" style="display:inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" title="Hapus" onclick="return confirm('Yakin hapus user ini?')">
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

<script>
    $(document).ready(function() {
        $('#usersTable').DataTable({
            pageLength: 10,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'
            }
        });
    });
</script>

</div>

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
      <form action="{{ route('users.import') }}" method="POST" enctype="multipart/form-data">
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