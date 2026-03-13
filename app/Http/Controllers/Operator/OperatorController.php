<?php

namespace App\Http\Controllers\Operator;

use Illuminate\Http\Request;
use App\Models\Dokumen;
use Illuminate\View\View;
use App\Http\Controllers\Controller;
use App\Models\HasilTurnitin;

class OperatorController extends Controller
{
    /**
     * Display a listing of the dokumen that the operator can act on.
     * By default we show all documents, but you can scope this further
     * (e.g. only pending items) depending on business rules.
     */
    public function index(Request $request): View
    {
        $total = Dokumen::count();
        $pending = Dokumen::where('status', 'Pending')->count();
        $rataSimilarity = HasilTurnitin::avg('similarity_index');

        return view('operator.dashboard', compact('total', 'pending', 'rataSimilarity'));
    }

    /**
     * Update the status of a document (used by operator).
     */
    public function updateStatus(Request $request, Dokumen $dokumen)
    {
        $data = $request->validate([
            'status' => 'required|in:Pending,Diproses,Ditolak,Selesai',
        ]);

        $dokumen->update($data);

        return redirect()->route('operator.dokumen.index')
                         ->with('success', 'Status dokumen diperbarui.');
    }
}
