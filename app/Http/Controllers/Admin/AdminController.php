<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Dokumen;
use App\Models\HasilTurnitin;
use App\Models\Mahasiswa;
use Illuminate\View\View;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function index(): View
    {
        $totalMahasiswa = Mahasiswa::count();
        $total = Dokumen::count();
        $pending = Dokumen::where('status', 'Pending')->count();
        $selesai = Dokumen::where('status', 'Selesai')->count();
        $rataSimilarity = HasilTurnitin::avg('similarity_index');

        $recentDokumen = Dokumen::with('user')->orderBy('created_at', 'desc')->take(5)->get();

        return view('admin.dashboard', compact('totalMahasiswa', 'total', 'pending', 'selesai', 'rataSimilarity', 'recentDokumen'));
    }
}
