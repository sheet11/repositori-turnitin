@extends('layouts.dashboard')

@section('content')

<div class="container">

    <h4>Tambah User</h4>

    <form action="{{ route('users.store') }}" method="POST">

        @csrf

        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="name" class="form-control">
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control">
        </div>

        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control">
        </div>

        <div class="mb-3">
            <label>Role</label>

            <select name="role_id" class="form-control">

                @foreach($roles as $role)

                <option value="{{ $role->id }}">
                    {{ $role->nama_role }}
                </option>

                @endforeach

            </select>

        </div>

        <button class="btn btn-primary">
            Simpan
        </button>

    </form>

</div>

@endsection