<?php

namespace App\Http\Controllers\Operator;

use Illuminate\Http\Request;
use App\Models\Dokumen;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\StreamedResponse;
use App\Http\Controllers\Controller;

class DokumenController extends Controller
{
    /**
     * Display a listing of the dokumen. Supports optional search by judul or nim.
     */
    public function index(Request $request): View
    {
        $search = $request->search;
        $tahun = $request->tahun;
        $status = $request->status;
        
        $user = Auth::user();

        // start with base query
        $query = Dokumen::with(['mahasiswa', 'hasilTurnitin.operator']);

        // mahasiswa only sees their own dokumen
        if ($user && optional($user->role)->nama_role === 'Mahasiswa') {
            $query->where('user_id', $user->id);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('jenis_dokumen', 'like', "%{$search}%")
                  ->orWhereHas('mahasiswa', function ($mq) use ($search) {
                      $mq->where('nim', 'like', "%{$search}%")
                         ->orWhere('nama', 'like', "%{$search}%");
                  });
            });
        }

        if ($tahun) {
            $query->whereYear('created_at', $tahun);
        }

        // Operater sees: 
        // 1. Pending documents that are NOT claimed yet (assigned_operator_id is null)
        // 2. Diproses documents that are claimed by THEM (assigned_operator_id == Auth::id())
        $query->where(function($q) use ($user) {
            $q->where(function($subq) {
                $subq->where('status', 'Pending')
                     ->whereNull('assigned_operator_id');
            })->orWhere(function($subq) use ($user) {
                $subq->where('status', 'Diproses')
                     ->where('assigned_operator_id', $user->id);
            });
        });

        if ($status) {
            $query->where('status', $status);
        }

        $dokumen = $query->orderBy('created_at', 'desc')->get();

        // 5. Statistik Singkat
        $totalAntrean = Dokumen::where('status', 'Pending')->whereNull('assigned_operator_id')->count();
        $sedangDikerjakan = Dokumen::where('status', 'Diproses')->where('assigned_operator_id', $user->id)->count();
        $selesaiHariIni = Dokumen::where('status', 'Selesai')->whereDate('updated_at', today())->count();

        return view('operator.dokumen.dashboard', compact('dokumen', 'totalAntrean', 'sedangDikerjakan', 'selesaiHariIni'));
    }

    /**
     * Display a listing of riwayat dokumen. Contains Selesai, Ditolak, and Sudah Dicek.
     */
    public function riwayat(Request $request): View
    {
        $search = $request->search;
        $tahun = $request->tahun;
        $status = $request->status;
        
        $user = Auth::user();

        // start with base query
        $query = Dokumen::with('mahasiswa');

        // mahasiswa only sees their own dokumen
        if ($user && optional($user->role)->nama_role === 'Mahasiswa') {
            $query->where('user_id', $user->id);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('jenis_dokumen', 'like', "%{$search}%")
                  ->orWhereHas('mahasiswa', function ($mq) use ($search) {
                      $mq->where('nim', 'like', "%{$search}%")
                         ->orWhere('nama', 'like', "%{$search}%");
                  });
            });
        }

        if ($tahun) {
            $query->whereYear('created_at', $tahun);
        }

        $query->whereIn('status', ['Selesai', 'Ditolak', 'Sudah Dicek']);

        if ($status) {
            $query->where('status', $status);
        }

        $dokumen = $query->orderBy('created_at', 'desc')->get();

        return view('operator.dokumen.riwayat', compact('dokumen'));
    }

    /**
     * Show the form for creating a new dokumen.
     */
    public function create(): View
    {
        return view('operator.dokumen.create');
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

        $data['user_id'] = Auth::id();

        Dokumen::create($data);

        return redirect()->route('operator.dokumen.index')
            ->with('success', 'Dokumen berhasil ditambahkan.');
    }

    /**
     * Display the specified dokumen.
     */
    public function show(Dokumen $dokumen): View
    {
        return view('operator.dokumen.show', compact('dokumen'));
    }

    /**
     * Show the form for editing the specified dokumen.
     */
    public function edit(Dokumen $dokumen): View
    {
        return view('operator.dokumen.edit', compact('dokumen'));
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
            'status' => 'required|in:Pending,Diproses,Sudah Dicek,Ditolak,Selesai',
        ]);

        $dokumen->update($data);

        return redirect()->route('operator.dokumen.index')
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

        return redirect()->route('operator.dokumen.index')
            ->with('success', 'Dokumen dihapus.');
    }

    /**
     * Claim a pending document for the logged in operator.
     */
    public function claim(Request $request, Dokumen $dokumen)
    {
        if ($dokumen->status !== 'Pending' || $dokumen->assigned_operator_id !== null) {
            return back()->with('error', 'Dokumen ini sudah diambil alih oleh operator lain atau tidak berstatus Pending.');
        }

        $dokumen->update([
            'assigned_operator_id' => Auth::id(),
            'status' => 'Diproses'
        ]);

        return redirect()->route('operator.dokumen.index')
            ->with('success', 'Dokumen berhasil diambil alih dan sekarang berstatus Diproses.');
    }

    public function download($id)
    {
        $dokumen = Dokumen::findOrFail($id);

        $path = storage_path('app/private/' . $dokumen->file_asli);

        if (!file_exists($path)) {
            abort(404);
        }

        return response()->download($path);
    }

    /**
     * Export all documents to CSV format
     */
    public function export(): StreamedResponse
    {
        $dokumens = Dokumen::with('mahasiswa', 'assignedOperator')->orderBy('created_at', 'desc')->get();

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=Laporan_Dokumen_" . date('Y-m-d') . ".csv",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['No', 'Nama Mahasiswa', 'NIM', 'Judul', 'Jenis Dokumen', 'Status', 'Operator', 'Tanggal Pengajuan'];

        $callback = function() use($dokumens, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($dokumens as $index => $dokumen) {
                fputcsv($file, [
                    $index + 1,
                    optional($dokumen->mahasiswa)->nama ?? '-',
                    optional($dokumen->mahasiswa)->nim ?? '-',
                    $dokumen->judul,
                    $dokumen->jenis_dokumen,
                    $dokumen->status,
                    optional($dokumen->assignedOperator)->name ?? '-',
                    $dokumen->created_at->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
