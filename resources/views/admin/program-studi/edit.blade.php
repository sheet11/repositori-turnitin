@extends('layouts.dashboard')

@section('content')

<div class="container">
    <h1 class="h3 mb-4 text-gray-800">Edit Program Studi</h1>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('program-studi.update', $programStudi->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="form-label">Nama Program Studi</label>
                    <input type="text" name="nama_prodi" class="form-control @error('nama_prodi') is-invalid @enderror" value="{{ old('nama_prodi', $programStudi->nama_prodi) }}" required>
                    @error('nama_prodi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('program-studi.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>

@endsection
