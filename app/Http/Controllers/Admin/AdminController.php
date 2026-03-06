<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Dokumen;
use App\Models\HasilTurnitin;
use Illuminate\View\View;
use App\Http\Controllers\Controller;

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
