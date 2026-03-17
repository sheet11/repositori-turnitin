<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;

class ProgramStudiController extends Controller
{
    public function index()
    {
        $programStudi = ProgramStudi::all();
        return view('admin.program-studi.index', compact('programStudi'));
    }

    public function create()
    {
        return view('admin.program-studi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_prodi' => 'required|max:255',
        ]);

        ProgramStudi::create($request->all());

        return redirect()->route('program-studi.index')->with('success', 'Program Studi berhasil ditambahkan');
    }

    public function edit($id)
    {
        $programStudi = ProgramStudi::findOrFail($id);
        return view('admin.program-studi.edit', compact('programStudi'));
    }

    public function update(Request $request, $id)
    {
        $programStudi = ProgramStudi::findOrFail($id);
        $request->validate([
            'nama_prodi' => 'required|max:255',
        ]);

        $programStudi->update($request->all());

        return redirect()->route('program-studi.index')->with('success', 'Program Studi berhasil diupdate');
    }

    public function destroy($id)
    {
        $programStudi = ProgramStudi::findOrFail($id);
        $programStudi->delete();

        return redirect()->route('program-studi.index')->with('success', 'Program Studi berhasil dihapus');
    }
}
