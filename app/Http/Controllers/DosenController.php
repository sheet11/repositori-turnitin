<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dokumen;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class DosenController extends Controller
{
    /**
     * Show dashboard / daftar dokumen untuk dosen.
     */
    public function index(Request $request): View
    {
        $search = $request->query('search');
        $query = Dokumen::query();

        if ($search) {
            $query->where('judul', 'like', "%{$search}%")
                  ->orWhere('nim', 'like', "%{$search}%");
        }

        $dokumen = $query->orderBy('created_at', 'desc')->get();
        return view('dosen.dashboard', compact('dokumen'));
    }
}
