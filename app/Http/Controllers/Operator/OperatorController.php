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
     * Update status dokumen
     */
    public function updateStatus(Request $request, Dokumen $dokumen)
    {
        $request->validate([
            'status' => 'required|in:Pending,Diproses,Sudah Dicek,Ditolak,Selesai'
        ]);

        $data = ['status' => $request->status];

        // If returned to Pending, release the claim so other operators can take it
        if ($request->status === 'Pending') {
            $data['assigned_operator_id'] = null;
        }

        $dokumen->update($data);

        return back()->with('success', 'Status dokumen berhasil diperbarui!');
    }
}
