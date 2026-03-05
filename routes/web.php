<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\OperatorController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DokumenController;



Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $user = Auth::user();
    if ($user) {
        $roleName = optional($user->role)->nama_role;
        switch ($roleName) {
            case 'Admin':
                return redirect()->route('admin.dashboard');
            case 'Operator':
                return redirect()->route('operator.dashboard');
            case 'Mahasiswa':
                return redirect()->route('mahasiswa.dashboard');
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

    // if you still need a named shortcut for the dashboard you can use:
    // Route::get('/dokumen', [DokumenController::class, 'index'])->name('dokumen.dashboard');
});

require __DIR__.'/auth.php';
