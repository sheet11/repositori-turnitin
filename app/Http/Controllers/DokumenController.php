<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dokumen;
use App\Models\HasilTurnitin;
use Illuminate\View\View;

class DokumenController extends Controller
{
    public function index(): View
    {
        return view('dokumen.dashboard');
    }
}