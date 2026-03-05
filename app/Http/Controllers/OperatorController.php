<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dokumen;
use Illuminate\View\View;

class OperatorController extends Controller
{
    /**
     * Display a listing of the dokumen that the operator can act on.
     * By default we show all documents, but you can scope this further
     * (e.g. only pending items) depending on business rules.
     */
    public function index(Request $request): View
    {
        $search = $request->query('search');
        $query = Dokumen::query();

        if ($search) {
            $query->where('judul', 'like', "%{$search}%")
                  ->orWhere('nim', 'like', "%{$search}%");
        }

        $dokumen = $query->orderBy('created_at', 'desc')->get();

        return view('operator.dashboard', compact('dokumen'));
    }

    /**
     * Update the status of a document (used by operator).
     */
    public function updateStatus(Request $request, Dokumen $dokumen)
    {
        $data = $request->validate([
            'status' => 'required|in:Pending,Di Proses,Ditolak,Selesai',
        ]);

        $dokumen->update($data);

        return redirect()->route('operator.dashboard')
                         ->with('success', 'Status dokumen diperbarui.');
    }
}
