<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Mahasiswa\MahasiswaController;
use App\Http\Controllers\Operator\OperatorController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\DokumenController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\HasilTurnitinController;
use App\Http\Controllers\LogAktivitasController;



Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $user = Auth::user();
    if ($user) {
        switch ($user->role_id) {
            case 1: // Admin
                return redirect()->route('admin.dashboard');
            case 2: // Operator
                return redirect()->route('operator.dashboard');
            case 3: // Mahasiswa
                return redirect()->route('mahasiswa.dashboard');
            case 4: // Dosen
                return redirect()->route('dosen.index');
        }
    }
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // dashboards separated by role
    Route::get('/admin', [AdminController::class, 'index'])
        ->name('admin.dashboard');

    Route::get('/mahasiswa', [MahasiswaController::class, 'index'])
        ->name('mahasiswa.dashboard');

    Route::get('/operator', [OperatorController::class, 'index'])
        ->name('operator.dashboard');

    // operator helper route to change document status
    Route::patch('/operator/dokumen/{dokumen}/status', [OperatorController::class, 'updateStatus'])
        ->name('operator.updateStatus');

    // resourceful routes for dokumen; index of the controller will still return
    // the generic listing used in the role-specific dashboards when appropriate.
    // override parameter name to avoid Laravel interpreting 'dokumen' singular as 'dokuman'
    Route::resource('dokumen', DokumenController::class)
        ->parameters(['dokumen' => 'dokumen'])
        ->only(['index','create','store','show','edit','update','destroy']);

    // resourceful routes for new controllers
    Route::resource('dosen', DosenController::class)
        ->parameters(['dosen' => 'dosen']);
    Route::resource('hasil-turnitin', HasilTurnitinController::class)
        ->parameters(['hasil-turnitin' => 'hasilTurnitin']);
    Route::resource('log-aktivitas', LogAktivitasController::class)
        ->parameters(['log-aktivitas' => 'logAktivitas']);

    // if you still need a named shortcut for the dashboard you can use:
    // Route::get('/dokumen', [DokumenController::class, 'index'])->name('dokumen.dashboard');
});

require __DIR__.'/auth.php';
