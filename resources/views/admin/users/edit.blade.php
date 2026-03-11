@extends('layouts.dashboard')

@section('content')

<div class="container">

    <h4>Edit User</h4>

    <form action="{{ route('users.update',$user->id) }}" method="POST">

        @csrf

        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="name" class="form-control" value="{{ $user->name }}">
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ $user->email }}">
        </div>

        <div class="mb-3">
            <label>Password (kosongkan jika tidak diubah)</label>
            <input type="password" name="password" class="form-control">
        </div>

        <div class="mb-3">
            <label>Role</label>

            <select name="role_id" class="form-control">

                @foreach($roles as $role)

                <option value="{{ $role->id }}" @if($user->role_id == $role->id) selected @endif>

                    {{ $role->nama_role }}

                </option>

                @endforeach

            </select>

        </div>

        <button class="btn btn-primary">
            Update
        </button>

    </form>

</div>

@endsection