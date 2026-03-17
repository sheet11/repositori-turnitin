<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\LogAktivitas;

class LogAktivitasController extends Controller
{
    public function index()
    {
        $logs = LogAktivitas::with('user')->orderBy('waktu', 'desc')->get();
        return view('admin.log-aktivitas.index', compact('logs'));
    }
}
