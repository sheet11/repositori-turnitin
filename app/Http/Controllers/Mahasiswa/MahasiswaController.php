<?php

namespace App\Http\Controllers\Mahasiswa;

use Illuminate\Http\Request;
use App\Models\Dokumen;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class MahasiswaController extends Controller
{
    /**
     * Show dashboard / daftar dokumen milik mahasiswa yang sedang login.
     */
    public function index(Dokumen $dokumen): View
    {
        return view('mahasiswa.dashboard', compact('dokumen'));
    }
}
