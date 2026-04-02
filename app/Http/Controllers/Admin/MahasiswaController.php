<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Mahasiswa;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class MahasiswaController extends Controller
{
    public function index()
    {
        $mahasiswa = Mahasiswa::with(['user', 'programStudi'])->get();
        return view('admin.mahasiswa.index', compact('mahasiswa'));
    }

    public function create()
    {
        $programStudi = ProgramStudi::all();
        return view('admin.mahasiswa.create', compact('programStudi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nim' => 'required|unique:mahasiswas',
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'program_studi_id' => 'required',
            'tahun_masuk' => 'nullable|integer'
        ]);

        DB::transaction(function () use ($request) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role_id' => 3 // Role 3 is Mahasiswa based on routes
            ]);

            Mahasiswa::create([
                'nim' => $request->nim,
                'nama' => $request->name,
                'user_id' => $user->id,
                'program_studi_id' => $request->program_studi_id,
                'tahun_masuk' => $request->tahun_masuk ?? date('Y')
            ]);
        });

        return redirect()->route('mahasiswa.index')->with('success','Mahasiswa berhasil ditambahkan');
    }

    public function edit($id)
    {
        $mahasiswa = Mahasiswa::with('user')->findOrFail($id);
        $programStudi = ProgramStudi::all();

        return view('admin.mahasiswa.edit', compact('mahasiswa','programStudi'));
    }

    public function update(Request $request, $id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);
        
        $request->validate([
            'nim' => 'required|unique:mahasiswas,nim,'.$id,
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$mahasiswa->user_id,
            'program_studi_id' => 'required',
            'tahun_masuk' => 'nullable|integer'
        ]);

        DB::transaction(function () use ($request, $mahasiswa) {
            // Update User
            $userData = [
                'name' => $request->name,
                'email' => $request->email,
            ];

            if($request->password){
                $userData['password'] = Hash::make($request->password);
            }

            $user = User::findOrFail($mahasiswa->user_id);
            $user->update($userData);

            // Update Mahasiswa
            $mahasiswa->update([
                'nim' => $request->nim,
                'nama' => $request->name,
                'program_studi_id' => $request->program_studi_id,
                'tahun_masuk' => $request->tahun_masuk ?? date('Y')
            ]);
        });

        return redirect()->route('mahasiswa.index')->with('success','Mahasiswa berhasil diupdate');
    }

    public function destroy($id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);
        
        DB::transaction(function () use ($mahasiswa) {
            $userId = $mahasiswa->user_id;
            $mahasiswa->delete();
            User::findOrFail($userId)->delete();
        });

        return redirect()->route('mahasiswa.index')->with('success','Mahasiswa berhasil dihapus');
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
            
            DB::beginTransaction();
            try {
                $user = User::create([
                    'name' => trim($row['nama'] ?? $nim),
                    'email' => $email,
                    'password' => Hash::make(trim($row['password'] ?? 'password123')),
                    'role_id' => 3 // Role 3 is Mahasiswa based on routes
                ]);

                // Validate if program_studi_id exists in the database
                $program_studi_id = null;
                if (!empty($row['program_studi_id'])) {
                    if (\App\Models\ProgramStudi::where('id', $row['program_studi_id'])->exists()) {
                        $program_studi_id = $row['program_studi_id'];
                    }
                }
                
                // Fallback to first program studi if not valid or empty
                if (!$program_studi_id) {
                    $program_studi_id = \App\Models\ProgramStudi::first()->id ?? 1;
                }

                \App\Models\Mahasiswa::create([
                    'nim' => $nim,
                    'nama' => trim($row['nama'] ?? $nim),
                    'user_id' => $user->id,
                    'program_studi_id' => $program_studi_id,
                    'tahun_masuk' => trim($row['tahun_masuk'] ?? date('Y'))
                ]);

                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                // Optionally log the error: \Log::error('Import error for NIM '.$nim.': '.$e->getMessage());
            }
        });

        return redirect()->route('mahasiswa.index')->with('success','Data Mahasiswa berhasil diimport dari Excel');
    }
}
