<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Mahasiswa;
use App\Models\Dosen;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $programStudis = \App\Models\ProgramStudi::all();
        return view('auth.register', compact('programStudis'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'role_id' => ['required', 'integer', 'in:3,4'],
            'nim' => ['required_if:role_id,3', 'string', 'max:20', 'unique:mahasiswas,nim'],
            'program_studi_id' => ['required_if:role_id,3', 'integer', 'exists:program_studis,id'],
            'nidn' => ['nullable', 'required_if:role_id,4', 'string', 'max:20', 'unique:dosens,nidn'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Create user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role_id' => $request->role_id,
            'password' => Hash::make($request->password),
        ]);

        // Create related record based on role
        if ($request->role_id == 3) { // Mahasiswa
            Mahasiswa::create([
                'nim' => $request->nim,
                'nama' => $request->name,
                'program_studi_id' => $request->program_studi_id,
            ]);
            // Update user with mahasiswa_id
            $user->update(['mahasiswa_id' => $request->nim]);
        } elseif ($request->role_id == 4) { // Dosen
            Dosen::create([
                'nidn' => $request->nidn,
                'nama' => $request->name,
            ]);
            // Note: Dosen table doesn't have foreign key in users yet
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
