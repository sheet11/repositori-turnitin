<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class FirstLoginController extends Controller
{
    /**
     * Show the first login setup form.
     */
    public function show()
    {
        $user = Auth::user();

        // If the user has already completed the first login setup, redirect to dashboard
        if (!$user->is_first_login) {
            return redirect()->route('mahasiswa.dashboard');
        }

        return view('mahasiswa.first_login', compact('user'));
    }

    /**
     * Update the student's credentials and details on first login.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        if (!$user->is_first_login) {
            return redirect()->route('mahasiswa.dashboard');
        }

        $request->validate([
            'email' => 'required|email|unique:users,email,' . $user->id,
            'whatsapp' => 'required|string|min:9|max:15|regex:/^[0-9+]+$/',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan oleh pengguna lain.',
            'whatsapp.required' => 'Nomor WhatsApp wajib diisi.',
            'whatsapp.min' => 'Nomor WhatsApp minimal 9 digit.',
            'whatsapp.max' => 'Nomor WhatsApp maksimal 15 digit.',
            'whatsapp.regex' => 'Format nomor WhatsApp tidak valid.',
            'password.required' => 'Password baru wajib diisi.',
            'password.min' => 'Password baru minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        // Update User account
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->is_first_login = false;
        $user->save();

        // Update Mahasiswa details
        $mahasiswa = $user->mahasiswa;
        if ($mahasiswa) {
            $mahasiswa->whatsapp = $request->whatsapp;
            $mahasiswa->save();
        }

        return redirect()->route('mahasiswa.dashboard')->with('success', 'Akun Anda berhasil diperbarui. Selamat datang di portal repositori!');
    }
}
