@extends('layouts.dashboard')

@section('content')

<h1 class="text-2xl font-bold mb-6">Data Dokumen</h1>

<form method="GET" class="mb-4">
    <input type="text" name="search" placeholder="Cari Judul / NIM"
           class="border p-2 rounded w-1/3">
    <button class="bg-blue-600 text-white px-4 py-2 rounded">Cari</button>
</form>

<table class="w-full bg-white shadow rounded">
    <thead class="bg-gray-200">
        <tr>
            <th class="p-3">Judul</th>
            <th>NIM</th>
            <th>Jenis</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($dokumen as $d)
        <tr class="border-t">
            <td class="p-3">{{ $d->judul }}</td>
            <td>{{ $d->nim }}</td>
            <td>{{ $d->jenis_dokumen }}</td>
            <td>{{ $d->status }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection