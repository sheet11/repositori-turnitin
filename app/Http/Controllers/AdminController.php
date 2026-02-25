<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dokumen;
use App\Models\HasilTurnitin;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function index(): View
    {
        $total = Dokumen::count();
        $pending = Dokumen::where('status', 'Pending')->count();
        $rataSimilarity = HasilTurnitin::avg('similarity_index');

        return view('admin.dashboard', compact('total', 'pending', 'rataSimilarity'));
    }
}