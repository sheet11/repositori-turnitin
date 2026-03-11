<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Dokumen;
use App\Models\HasilTurnitin;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class DokumenController extends Controller
{
    /**
     * Display a listing of the dokumen. Supports optional search by judul or nim.
     */
    public function index(Request $request): View
    {
        $search = $request->query('search');
        $user = Auth::user();

        // start with base query
        $query = Dokumen::query();

        // mahasiswa only sees their own dokumen
        if ($user && optional($user->role)->nama_role === 'Mahasiswa') {
            $query->where('user_id', $user->id);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                    ->orWhere('nim', 'like', "%{$search}%");
            });
        }

        // you can change to paginate() if you need pagination in the view
        $dokumen = $query->orderBy('created_at', 'desc')->get();

        return view('admin.dokumen.dashboard', compact('dokumen'));
    }

    /**
     * Show the form for creating a new dokumen.
     */
    public function create(): View
    {
        return view('admin.dokumen.create');
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
            $data['file_asli'] = $request->file('file_asli')->store('dokumen','public');
        }
        if ($request->hasFile('bukti_bayar')) {
            $data['bukti_bayar'] = $request->file('bukti_bayar')->store('bukti','public');
        }

        $data['user_id'] = Auth::id();

        Dokumen::create($data);

        return redirect()->route('admin.dokumen.dashboard')
            ->with('success', 'Dokumen berhasil ditambahkan.');
    }

    /**
     * Display the specified dokumen.
     */
    public function show(Dokumen $dokumen): View
    {
        return view('admin.dokumen.show', compact('dokumen'));
    }

    /**
     * Show the form for editing the specified dokumen.
     */
    public function edit(Dokumen $dokumen): View
    {
        return view('admin.dokumen.edit', compact('dokumen'));
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

        return redirect()->route('admin.dokumen.dashboard')
            ->with('success', 'Data dokumen diperbarui.');
    }

    /**
     * Remove the specified dokumen from storage.
     */
    public function destroy(Dokumen $dokumen)
    {
        $dokumen->delete();
        if ($dokumen->bukti_bayar) {
            Storage::delete($dokumen->bukti_bayar);
        }

        return redirect()->route('admin.dokumen.dashboard')
            ->with('success', 'Dokumen dihapus.');
    }
}
