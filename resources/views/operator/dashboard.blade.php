@extends('layouts.dashboard')

@section('content')

<h1 class="text-2xl font-bold mb-6">Dashboard Operator</h1>

<div class="bg-white p-6 rounded shadow">
    <h2 class="text-lg font-semibold mb-4">Dokumen Menunggu Verifikasi</h2>

    <table class="w-full border">
        <thead class="bg-gray-200">
            <tr>
                <th class="p-2">Judul</th>
                <th>NIM</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($dokumen as $d)
            <tr class="border-t">
                <td class="p-2">{{ $d->judul }}</td>
                <td>{{ $d->nim }}</td>
                <td>
                    <span class="px-2 py-1 bg-yellow-200 text-yellow-800 rounded">
                        {{ $d->status }}
                    </span>
                </td>
                <td>
                    <a href="#" class="text-blue-600">Proses</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection