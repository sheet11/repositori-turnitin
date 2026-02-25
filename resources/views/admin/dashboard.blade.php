@extends('layouts.dashboard')

@section('content')

<h1 class="text-2xl font-bold mb-6">Dashboard Admin</h1>

<div class="grid grid-cols-3 gap-6">

    <div class="bg-white p-6 rounded shadow">
        <h2 class="text-gray-500">Total Dokumen</h2>
        <p class="text-3xl font-bold">{{ $total }}</p>
    </div>

    <div class="bg-white p-6 rounded shadow">
        <h2 class="text-gray-500">Pending</h2>
        <p class="text-3xl font-bold text-yellow-500">{{ $pending }}</p>
    </div>

    <div class="bg-white p-6 rounded shadow">
        <h2 class="text-gray-500">Rata-rata Similarity</h2>
        <p class="text-3xl font-bold text-green-600">{{ number_format($rataSimilarity,2) }}%</p>
    </div>

</div>

@endsection