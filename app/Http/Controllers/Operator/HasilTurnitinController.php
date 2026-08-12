<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HasilTurnitin;
use Illuminate\Support\Facades\Auth;
use App\Models\Dokumen;
use Illuminate\Support\Facades\Mail;
use App\Mail\HasilTurnitinMail;

use Illuminate\Support\Facades\Storage;

class HasilTurnitinController extends Controller
{
    public function create($id)
    {
        $dokumen = Dokumen::findOrFail($id);

        return view('operator.turnitin.create', compact('dokumen'));
    }

    public function store(Request $request)
    {
        set_time_limit(300); // Extend execution time for large PDF uploads or slow SMTP

        $dokumen = Dokumen::findOrFail($request->dokumen_id);
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
                $namaFile,
                'public'
            );

            $data['file_laporan'] = $path;
        }

        $data['tanggal_cek'] = now();
        $data['operator_id'] = Auth::id();

        HasilTurnitin::create($data);

        $dokumen->update(['status' => 'Sudah Dicek']);

        \App\Models\LogAktivitas::create([
            'user_id' => Auth::id(),
            'aktivitas' => 'Mengecek (Upload Hasil Turnitin) dokumen: ' . $dokumen->judul . ' dengan similarity ' . $data['similarity_index'] . '%',
            'waktu' => now()
        ]);

        // =============================
        // Kirim Email ke Mahasiswa
        // =============================
        $user = $dokumen->user; // relasi ke user

        $emailData = [
            'nama' => $user->name,
            'judul' => $dokumen->judul,
            'similarity_index' => $data['similarity_index']
        ];

        try {
            Mail::to($user->email)->send(new HasilTurnitinMail($emailData));
            $msg = 'Hasil Turnitin berhasil diupload & email terkirim';
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Email Turnitin gagal terkirim: ' . $e->getMessage());
            $msg = 'Hasil Turnitin berhasil diupload, namun server gagal mengirim email notifikasi ke mahasiswa.';
        }

        return redirect()->route('operator.dokumen.index')
            ->with('success', $msg);
    }

    public function edit($id)
    {
        $turnitin = HasilTurnitin::with('dokumen')->findOrFail($id);
        $dokumen = $turnitin->dokumen;

        return view('operator.turnitin.edit', compact('turnitin', 'dokumen'));
    }

    public function update(Request $request, $id)
    {
        set_time_limit(300);

        $turnitin = HasilTurnitin::with('dokumen')->findOrFail($id);
        $dokumen = $turnitin->dokumen;

        $data = $request->validate([
            'similarity_index' => 'required|numeric',
            'file_laporan' => 'nullable|file|mimes:pdf|max:20480'
        ]);

        if ($request->hasFile('file_laporan')) {
            // Hapus file lama jika ada
            if ($turnitin->file_laporan && Storage::disk('public')->exists($turnitin->file_laporan)) {
                Storage::disk('public')->delete($turnitin->file_laporan);
            }

            $file = $request->file('file_laporan');
            $namaFile = 'turnitin_' . $dokumen->id . '_' . time() . '.pdf';

            $path = $file->storeAs(
                'turnitin',
                $namaFile,
                'public'
            );

            $data['file_laporan'] = $path;
        }

        $data['tanggal_cek'] = now();
        $data['operator_id'] = Auth::id();

        $turnitin->update($data);

        \App\Models\LogAktivitas::create([
            'user_id' => Auth::id(),
            'aktivitas' => 'Mengubah Hasil Turnitin dokumen: ' . $dokumen->judul . ' menjadi similarity ' . $data['similarity_index'] . '%',
            'waktu' => now()
        ]);

        return redirect()->route('operator.dokumen.riwayat')
            ->with('success', 'Hasil Turnitin berhasil diperbarui.');
    }

    public function download($id)
    {
        $turnitin = HasilTurnitin::findOrFail($id);

        $path = storage_path('app/public/' . $turnitin->file_laporan);

        if (!file_exists($path)) {
            abort(404);
        }

        return response()->download($path);
    }
}
