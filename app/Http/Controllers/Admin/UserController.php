<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function index()
    {
        $users = User::with('role')->get();
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'role_id' => 'required'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id
        ]);

        return redirect()->route('users.index')->with('success','User berhasil ditambahkan');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();

        return view('admin.users.edit', compact('user','roles'));
    }

    public function update(Request $request, $id)
    {

        $user = User::findOrFail($id);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role_id' => $request->role_id
        ];

        if($request->password){
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('users.index')->with('success','User berhasil diupdate');
    }

    public function destroy($id)
    {
        User::findOrFail($id)->delete();

        return redirect()->route('users.index')->with('success','User berhasil dihapus');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048'
        ]);

        $file = $request->file('file');
        $extension = $file->getClientOriginalExtension();
        $rows = \Spatie\SimpleExcel\SimpleExcelReader::create($file->path(), $extension)->getRows();

        $rows->each(function(array $row) {
            // expected columns in excel: nim, nama, email, program_studi_id, tahun_masuk
            $nim = trim($row['nim'] ?? '');
            $email = trim($row['email'] ?? '');
            
            if (!$nim || !$email) return;

            // skip if user already exists
            if (User::where('email', $email)->exists() || \App\Models\Mahasiswa::where('nim', $nim)->exists()) {
                return;
            }
            
            $user = User::create([
                'name' => trim($row['nama'] ?? $nim),
                'email' => $email,
                'password' => Hash::make(trim($row['password'] ?? 'password123')),
                'role_id' => 3 // Role 3 is Mahasiswa based on routes
            ]);

            \App\Models\Mahasiswa::create([
                'nim' => $nim,
                'nama' => trim($row['nama'] ?? $nim),
                'user_id' => $user->id,
                'program_studi_id' => !empty($row['program_studi_id']) ? $row['program_studi_id'] : (\App\Models\ProgramStudi::first()->id ?? 1),
                'tahun_masuk' => trim($row['tahun_masuk'] ?? date('Y'))
            ]);
        });

        return redirect()->route('users.index')->with('success','Data Mahasiswa berhasil diimport dari Excel');
    }

}
