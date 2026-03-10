<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HasilTurnitin;
use Illuminate\Support\Facades\Auth;
use App\Models\Dokumen;

class HasilTurnitinController extends Controller
{
    public function create($id)
    {
    $dokumen = Dokumen::findOrFail($id);

    return view('operator.turnitin.create', compact('dokumen'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'dokumen_id' => 'required',
            'similarity_index' => 'required|numeric',
            'file_laporan' => 'required|file|mimes:pdf|max:20480'
        ]);

        if ($request->hasFile('file_laporan')) {

            $file = $request->file('file_laporan');

            $namaFile = 'turnitin_' . $data['dokumen_id'] . '_' . time() . '.pdf';

            $path = $file->storeAs(
                'turnitin',
                $namaFile
            );

            $data['file_laporan'] = $path;
        }

        $data['tanggal_cek'] = now();
        $data['operator_id'] = Auth::id();

        HasilTurnitin::create($data);

        return redirect()->route('operator.dokumen.index')
        ->with('success', 'Hasil Turnitin berhasil diupload');
    }
    public function download($id)
    {
        $turnitin = HasilTurnitin::findOrFail($id);

        $path = storage_path('app/' . $turnitin->file_laporan);

        if (!file_exists($path)) {
            abort(404);
        }

        return response()->download($path);
    }
}
