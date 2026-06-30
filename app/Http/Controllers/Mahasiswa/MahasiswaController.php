<?php

namespace App\Http\Controllers\Mahasiswa;

use Illuminate\Http\Request;
use App\Models\Dokumen;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class MahasiswaController extends Controller
{
    /**
     * Show dashboard / daftar dokumen milik mahasiswa yang sedang login.
     */
    public function index(): View
    {
        $user = Auth::user();
        
        // Mengambil semua dokumen milik mahasiswa yang sedang login
        $dokumens = Dokumen::where('user_id', $user->id)
            ->with('hasilTurnitin')
            ->orderBy('created_at', 'desc')
            ->get();
            
        $totalSubmissions = $dokumens->count();
        
        // Status pengajuan terakhir
        $latestDokumen = $dokumens->first();
        $latestStatus = $latestDokumen ? $latestDokumen->status : 'Belum ada pengajuan';
        
        // Hitung rata-rata similarity
        $checkedDocs = $dokumens->filter(function ($doc) {
            return $doc->hasilTurnitin !== null;
        });
        
        $avgSimilarity = $checkedDocs->count() > 0 
            ? round($checkedDocs->avg('hasilTurnitin.similarity_index'), 1) 
            : 0;

        // Hitung per status
        $pendingCount = $dokumens->where('status', 'Pending')->count();
        $processingCount = $dokumens->where('status', 'Diproses')->count();
        $checkedCount = $dokumens->whereIn('status', ['Sudah Dicek', 'Selesai'])->count();
        $rejectedCount = $dokumens->where('status', 'Ditolak')->count();

        // Ambil 5 pengajuan terbaru untuk tabel dashboard
        $recentSubmissions = $dokumens->take(5);

        return view('mahasiswa.dashboard', compact(
            'totalSubmissions',
            'latestStatus',
            'avgSimilarity',
            'pendingCount',
            'processingCount',
            'checkedCount',
            'rejectedCount',
            'recentSubmissions',
            'latestDokumen'
        ));
    }
}
