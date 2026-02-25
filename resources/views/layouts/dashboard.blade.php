<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Repositori Turnitin</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="bg-gray-100">

<div class="flex min-h-screen">

    <!-- Sidebar -->
    <aside class="w-64 bg-blue-900 text-white p-5">
        <h2 class="text-xl font-bold mb-8">Turnitin Repo</h2>

        <nav class="space-y-3">
            <a href="{{ route('dashboard') }}" class="block hover:bg-blue-700 p-2 rounded">Dashboard</a>
            <a href="{{ route('dokumen.index') }}" class="block hover:bg-blue-700 p-2 rounded">Data Dokumen</a>

            @if(auth()->user()->role->nama_role == 'Admin')
                <a href="#" class="block hover:bg-blue-700 p-2 rounded">Manajemen User</a>
                <a href="#" class="block hover:bg-blue-700 p-2 rounded">Statistik</a>
            @endif

            @if(auth()->user()->role->nama_role == 'Operator')
                <a href="#" class="block hover:bg-blue-700 p-2 rounded">Verifikasi Dokumen</a>
            @endif
        </nav>
    </aside>

    <!-- Content -->
    <main class="flex-1 p-8">
        @yield('content')
    </main>

</div>

</body>
</html>