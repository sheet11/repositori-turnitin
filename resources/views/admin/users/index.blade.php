@extends('layouts.dashboard')

@section('content')

<div class="container">

    <h4>User Management</h4>

    <a href="{{ route('users.create') }}" class="btn btn-primary mb-3">
        Tambah User
    </a>

    <table class="table table-bordered">

        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Role</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>

            @foreach($users as $u)

            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $u->name }}</td>
                <td>{{ $u->email }}</td>
                <td>{{ $u->role->nama_role }}</td>

                <td>

                    <a href="{{ route('users.edit',$u->id) }}" class="btn btn-warning btn-sm">
                        Edit
                    </a>

                    <form action="{{ route('users.delete',$u->id) }}" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')

                        <button class="btn btn-danger btn-sm">
                            Hapus
                        </button>

                    </form>

                </td>

            </tr>

            @endforeach

        </tbody>

    </table>

</div>

@endsection