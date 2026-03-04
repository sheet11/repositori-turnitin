<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dokumen;
use App\Models\HasilTurnitin;
use Illuminate\View\View;

class DokumenController extends Controller
{
    /**
     * Display a listing of the dokumen. Supports optional search by judul or nim.
     */
    public function index(Request $request): View
    {
        $search = $request->query('search');

        $query = Dokumen::query();
        if ($search) {
            $query->where('judul', 'like', "%{$search}%")
                  ->orWhere('nim', 'like', "%{$search}%");
        }

        // you can change to paginate() if you need pagination in the view
        $dokumen = $query->orderBy('created_at', 'desc')->get();

        return view('dokumen.dashboard', compact('dokumen'));
    }

    /**
     * Show the form for creating a new dokumen.
     */
    public function create(): View
    {
        return view('dokumen.create');
    }

    /**
     * Store a newly created dokumen in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'judul' => 'required|string|max:255',
            'jenis_dokumen' => 'required|in:Skripsi,Jurnal,Proposal,KTI',
            'nim' => 'required|string|max:50',
            'file_asli' => 'required|file',
            'bukti_bayar' => 'nullable|file',
        ]);

        // handle file uploads as needed
        if ($request->hasFile('file_asli')) {
            $data['file_asli'] = $request->file('file_asli')->store('dokumen');
        }
        if ($request->hasFile('bukti_bayar')) {
            $data['bukti_bayar'] = $request->file('bukti_bayar')->store('bukti');
        }

        Dokumen::create($data);

        return redirect()->route('dokumen.index')
                         ->with('success', 'Dokumen berhasil ditambahkan.');
    }

    /**
     * Display the specified dokumen.
     */
    public function show(Dokumen $dokumen): View
    {
        return view('dokumen.show', compact('dokumen'));
    }

    /**
     * Show the form for editing the specified dokumen.
     */
    public function edit(Dokumen $dokumen): View
    {
        return view('dokumen.edit', compact('dokumen'));
    }

    /**
     * Update the specified dokumen in storage.
     */
    public function update(Request $request, Dokumen $dokumen)
    {
        $data = $request->validate([
            'judul' => 'required|string|max:255',
            'jenis_dokumen' => 'required|in:Skripsi,Jurnal,Proposal,KTI',
            'nim' => 'required|string|max:50',
            'status' => 'required|in:Pending,Di Proses,Ditolak,Selesai',
        ]);

        $dokumen->update($data);

        return redirect()->route('dokumen.index')
                         ->with('success', 'Data dokumen diperbarui.');
    }

    /**
     * Remove the specified dokumen from storage.
     */
    public function destroy(Dokumen $dokumen)
    {
        $dokumen->delete();

        return redirect()->route('dokumen.index')
                         ->with('success', 'Dokumen dihapus.');
    }
}
