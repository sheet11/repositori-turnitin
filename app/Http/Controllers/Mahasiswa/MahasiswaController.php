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
    public function index(Request $request): View
    {
        $search = $request->query('search');
        $query = Dokumen::where('user_id', Auth::id());

        if ($search) {
            $query->where('judul', 'like', "%{$search}%")
                  ->orWhere('nim', 'like', "%{$search}%");
        }

        $dokumen = $query->orderBy('created_at', 'desc')->get();
        return view('mahasiswa.dashboard', compact('dokumen'));
    }
}
