<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\DokumenController;
use App\Http\Controllers\Mahasiswa\MahasiswaController;
use App\Http\Controllers\Mahasiswa\DokumenController as MahasiswaDokumenController;
use App\Http\Controllers\Operator\DokumenController as OperatorDokumenController;
use App\Http\Controllers\Dosen\DokumenController as DosenDokumenController;
use App\Http\Controllers\Operator\OperatorController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\Operator\HasilTurnitinController;
use App\Http\Controllers\LogAktivitasController;
use App\Http\Controllers\Admin\UserController;

/*
|--------------------------------------------------------------------------
| Landing Page
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Dashboard Redirect Berdasarkan Role
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {
    $user = Auth::user();

    if ($user) {
        switch ($user->role_id) {
            case 1:
                return redirect()->route('admin.dashboard');

            case 2:
                return redirect()->route('operator.dashboard');

            case 3:
                return redirect()->route('mahasiswa.dashboard');

            case 4:
                return redirect()->route('dosen.index');
        }
    }

    return view('dashboard');
})
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/dokumen', [DokumenController::class, 'index'])->name('admin.dokumen.index');

    Route::resource('dokumen', DokumenController::class);

    Route::resource('dosen', DosenController::class);

    Route::resource('hasil-turnitin', HasilTurnitinController::class);

    Route::resource('log-aktivitas', LogAktivitasController::class);

    Route::get('/users', [UserController::class, 'index'])->name('users.index');

    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users/store', [UserController::class, 'store'])->name('users.store');

    Route::get('/users/edit/{id}', [UserController::class, 'edit'])->name('users.edit');
    Route::post('/users/update/{id}', [UserController::class, 'update'])->name('users.update');

    Route::delete('/users/delete/{id}', [UserController::class, 'destroy'])->name('users.delete');
    
});

/*
|--------------------------------------------------------------------------
| OPERATOR
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->prefix('operator')->group(function () {
    Route::get('/dashboard', [OperatorController::class, 'index'])->name('operator.dashboard');
    Route::get('/dokumen/export', [OperatorDokumenController::class, 'export'])->name('operator.dokumen.export');
    Route::get('/dokumen', [OperatorDokumenController::class, 'index'])->name('operator.dokumen.index');
    Route::get('/dokumen/riwayat', [OperatorDokumenController::class, 'riwayat'])->name('operator.dokumen.riwayat');
    Route::get('/dokumen/create', [OperatorDokumenController::class, 'create'])->name('operator.dokumen.create');
    Route::post('/dokumen', [OperatorDokumenController::class, 'store'])->name('operator.dokumen.store');
    Route::get('/dokumen/{dokumen}', [OperatorDokumenController::class, 'show'])->name('operator.dokumen.show');
    Route::get('/dokumen/{dokumen}/edit', [OperatorDokumenController::class, 'edit'])->name('operator.dokumen.edit');
    Route::put('/dokumen/{dokumen}', [OperatorDokumenController::class, 'update'])->name('operator.dokumen.update');
    Route::delete('/dokumen/{dokumen}', [OperatorDokumenController::class, 'destroy'])->name('operator.dokumen.destroy');
    Route::patch('/dokumen/{dokumen}/status', [OperatorController::class, 'updateStatus'])->name('operator.updateStatus');
    Route::post('/dokumen/{dokumen}/claim', [OperatorDokumenController::class, 'claim'])->name('operator.dokumen.claim');
    Route::get('/dokumen/download/{id}', [OperatorDokumenController::class, 'download'])->name('operator.dokumen.download');
    Route::get('/turnitin/create/{id}',[HasilTurnitinController::class,'create'])->name('operator.turnitin.create');
    Route::post('/turnitin',[HasilTurnitinController::class,'store'])->name('operator.turnitin.store');
    Route::get('/turnitin/download/{id}',[HasilTurnitinController::class, 'download'])->name('operator.turnitin.download');
});

/*
|--------------------------------------------------------------------------
| MAHASISWA
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->prefix('mahasiswa')->group(function () {
    Route::get('/dashboard', [MahasiswaController::class, 'index'])->name('mahasiswa.dashboard');
    Route::get('/dokumen', [MahasiswaDokumenController::class, 'index'])->name('mahasiswa.dokumen.index');
    Route::get('/dokumen/create', [MahasiswaDokumenController::class, 'create'])->name('mahasiswa.dokumen.create');
    Route::post('/dokumen', [MahasiswaDokumenController::class, 'store'])->name('mahasiswa.dokumen.store');
    Route::get('/dokumen/{dokumen}', [MahasiswaDokumenController::class, 'show'])->name('mahasiswa.dokumen.show');
    Route::get('/dokumen/{dokumen}/edit', [MahasiswaDokumenController::class, 'edit'])->name('mahasiswa.dokumen.edit');
    Route::put('/dokumen/{dokumen}', [MahasiswaDokumenController::class, 'update'])->name('mahasiswa.dokumen.update');
    Route::delete('/dokumen/{dokumen}', [MahasiswaDokumenController::class, 'destroy'])->name('mahasiswa.dokumen.destroy');
    Route::get('/riwayat', [MahasiswaDokumenController::class, 'riwayat'])->name('mahasiswa.riwayat');
    Route::get('/dokumen/download/{id}', [MahasiswaDokumenController::class, 'download'])->name('mahasiswa.dokumen.download');
});

/*
|--------------------------------------------------------------------------
| Dosen
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->prefix('dosen')->group(function () {
    Route::get('/', [DosenController::class, 'index'])->name('dosen.index');
    Route::get('/create', [DosenController::class, 'create'])->name('dosen.create');
    Route::post('/', [DosenController::class, 'store'])->name('dosen.store');
    Route::get('/{dosen}/edit', [DosenController::class, 'edit'])->name('dosen.edit');
    Route::put('/{dosen}', [DosenController::class, 'update'])->name('dosen.update');
    Route::delete('/{dosen}', [DosenController::class, 'destroy'])->name('dosen.destroy');
    Route::get('/{dosen}', [DosenController::class, 'show'])->name('dosen.show');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
