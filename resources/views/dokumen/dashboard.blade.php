@extends('layouts.dashboard')

@section('content')

<h1 class="text-2xl font-bold mb-6">Data Dokumen</h1>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
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
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Judul</th>
                        <th>NIM</th>
                        <th>Jenis</th>
                        <th>Status</th>
                    </tr>
                </tfoot>
                <tbody>
                    @if($dokumen->count() > 0)
                    @foreach($dokumen as $d)
                    <tr>
                        <td>{{ $d->judul }}</td>
                        <td>{{ $d->nim }}</td>
                        <td>{{ $d->jenis_dokumen }}</td>
                        <td>{{ $d->status }}</td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="4" class="text-center">Tidak ada dokumen yang tersedia.</td>
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