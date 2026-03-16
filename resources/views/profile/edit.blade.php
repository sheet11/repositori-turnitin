@php
    $layout = 'layouts.app'; // fallback
    if (Auth::check()) {
        if (Auth::user()->role_id == 1) $layout = 'layouts.dashboard';
        elseif (Auth::user()->role_id == 2) $layout = 'layouts.operator';
        elseif (Auth::user()->role_id == 3) $layout = 'layouts.mahasiswa';
        elseif (Auth::user()->role_id == 4) $layout = 'layouts.dosen';
    }
@endphp

@extends($layout)

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Profil Saya</h1>
</div>

<div class="row">

    <div class="col-lg-6 mb-4">
        <!-- Informasi Profil -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Informasi Profil</h6>
            </div>
            <div class="card-body">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>
    </div>

    <div class="col-lg-6 mb-4">
        <!-- Ubah Password -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Ubah Password</h6>
            </div>
            <div class="card-body">
                @include('profile.partials.update-password-form')
            </div>
        </div>
        
        <!-- Hapus Akun -->
        <div class="card shadow mb-4 border-left-danger">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-danger">Hapus Akun</h6>
            </div>
            <div class="card-body">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>

</div>

@endsection
