@extends('layouts.mahasiswa')

@section('content')
    <!-- Welcome Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard Mahasiswa</h1>
        <a href="{{ route('mahasiswa.dokumen.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50 mr-2"></i> Ajukan Cek Baru
        </a>
    </div>

    <!-- Stats Cards Row -->
    <div class="row">

        <!-- Card: Total Pengajuan -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Pengajuan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalSubmissions }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-file-upload fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card: Status Terakhir -->
        <div class="col-xl-3 col-md-6 mb-4">
            @php
                $statusColor = 'secondary';
                if ($latestStatus == 'Pending') {
                    $statusColor = 'warning';
                } elseif ($latestStatus == 'Diproses') {
                    $statusColor = 'info';
                } elseif ($latestStatus == 'Sudah Dicek') {
                    $statusColor = 'primary';
                } elseif ($latestStatus == 'Selesai') {
                    $statusColor = 'success';
                } elseif ($latestStatus == 'Ditolak') {
                    $statusColor = 'danger';
                }
            @endphp
            <div class="card border-left-{{ $statusColor }} shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-{{ $statusColor }} text-uppercase mb-1">
                                Status Pengajuan Terakhir</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                @if ($latestDokumen)
                                    <span class="badge bg-{{ $statusColor }} {{ $statusColor == 'warning' ? 'text-dark' : 'text-white' }} px-2 py-1" style="font-size: 0.85rem;">
                                        {{ $latestStatus }}
                                    </span>
                                @else
                                    <span class="text-muted" style="font-size: 0.95rem;">Belum ada</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-info-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card: Rata-rata Similarity -->
        <div class="col-xl-3 col-md-6 mb-4">
            @php
                $simColor = 'success';
                if ($avgSimilarity > 40) {
                    $simColor = 'danger';
                } elseif ($avgSimilarity > 20) {
                    $simColor = 'warning';
                }
            @endphp
            <div class="card border-left-{{ $simColor }} shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-{{ $simColor }} text-uppercase mb-1">
                                Rata-rata Similarity</div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ $avgSimilarity }}%</div>
                                </div>
                                <div class="col">
                                    <div class="progress progress-sm mr-2">
                                        <div class="progress-bar bg-{{ $simColor }}" role="progressbar" style="width: {{ $avgSimilarity }}%"
                                            aria-valuenow="{{ $avgSimilarity }}" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-percentage fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card: Pengajuan Ditolak -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Butuh Revisi (Ditolak)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $rejectedCount }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Column Left: Recent Submissions -->
        <div class="col-lg-8 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Aktivitas Pengajuan Terbaru</h6>
                    <a href="{{ route('mahasiswa.dokumen.index') }}" class="btn btn-sm btn-link text-primary font-weight-bold px-0">
                        Lihat Semua <i class="fas fa-arrow-right ml-1" style="font-size: 0.8rem;"></i>
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th>Judul Dokumen</th>
                                    <th class="d-none d-md-table-cell">Jenis</th>
                                    <th class="d-none d-md-table-cell">Tanggal</th>
                                    <th class="text-center">Similarity</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($recentSubmissions->count() > 0)
                                    @foreach ($recentSubmissions as $doc)
                                        <tr>
                                            <td>
                                                <div class="font-weight-bold text-dark text-wrap" style="max-width: 250px;" title="{{ $doc->judul }}">
                                                    {{ Str::limit($doc->judul, 45) }}
                                                </div>
                                                <small class="text-muted mr-2">{{ $doc->nim }}</small>
                                                <!-- Sub-info khusus mobile -->
                                                <div class="d-md-none text-muted small mt-1">
                                                    {{ $doc->jenis_dokumen }} | {{ $doc->created_at->format('d/m/Y') }}
                                                </div>
                                            </td>
                                            <td class="d-none d-md-table-cell">{{ $doc->jenis_dokumen }}</td>
                                            <td class="d-none d-md-table-cell">{{ $doc->created_at->format('d/m/Y') }}</td>
                                            <td class="text-center">
                                                @if ($doc->hasilTurnitin)
                                                    @php
                                                        $sim = $doc->hasilTurnitin->similarity_index;
                                                        $badgeColor = 'success';
                                                        if ($sim > 40) {
                                                            $badgeColor = 'danger';
                                                        } elseif ($sim > 20) {
                                                            $badgeColor = 'warning';
                                                        }
                                                    @endphp
                                                    <span class="badge bg-{{ $badgeColor }} text-white px-2 py-1" style="font-size: 0.8rem;">
                                                        {{ $sim }}%
                                                    </span>
                                                @else
                                                    <span class="text-muted small">-</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @php
                                                    $sColor = 'secondary';
                                                    if ($doc->status == 'Pending') {
                                                        $sColor = 'warning';
                                                    } elseif ($doc->status == 'Diproses') {
                                                        $sColor = 'info';
                                                    } elseif ($doc->status == 'Sudah Dicek') {
                                                        $sColor = 'primary';
                                                    } elseif ($doc->status == 'Selesai') {
                                                        $sColor = 'success';
                                                    } elseif ($doc->status == 'Ditolak') {
                                                        $sColor = 'danger';
                                                    }
                                                @endphp
                                                <span class="badge bg-{{ $sColor }} {{ $sColor == 'warning' ? 'text-dark' : 'text-white' }} px-2 py-1" style="font-size: 0.75rem;">
                                                    {{ $doc->status }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('mahasiswa.dokumen.show', $doc->id) }}" class="btn btn-sm btn-info btn-circle" title="Lihat Detail">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="6" class="text-center py-5 text-muted">
                                            <i class="fas fa-folder-open fa-3x mb-3 text-gray-300 d-block"></i>
                                            Belum ada dokumen yang diunggah.
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Column Right: Information & Help -->
        <div class="col-lg-4 mb-4">
            <!-- Card: Alur Proses Cek -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Panduan Alur Layanan</h6>
                </div>
                <div class="card-body" style="font-size: 0.9rem;">
                    <div class="timeline-simple">
                        <div class="d-flex mb-3">
                            <div class="mr-3">
                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 28px; height: 28px; font-weight: bold;">1</div>
                            </div>
                            <div>
                                <h6 class="font-weight-bold mb-1 text-gray-800">Ajukan Cek Baru</h6>
                                <p class="text-muted mb-0">Isi formulir, unggah file naskah asli (Word/PDF), dan bukti pembayaran.</p>
                            </div>
                        </div>
                        <div class="d-flex mb-3">
                            <div class="mr-3">
                                <div class="bg-info text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 28px; height: 28px; font-weight: bold;">2</div>
                            </div>
                            <div>
                                <h6 class="font-weight-bold mb-1 text-gray-800">Pemeriksaan Berkas</h6>
                                <p class="text-muted mb-0">Operator akan memeriksa pembayaran dan memproses dokumen ke Turnitin.</p>
                            </div>
                        </div>
                        <div class="d-flex mb-3">
                            <div class="mr-3">
                                <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 28px; height: 28px; font-weight: bold;">3</div>
                            </div>
                            <div>
                                <h6 class="font-weight-bold mb-1 text-gray-800">Unduh Laporan</h6>
                                <p class="text-muted mb-0">Hasil persentase similarity & file PDF laporan Turnitin dapat diunduh langsung.</p>
                            </div>
                        </div>
                        <div class="d-flex">
                            <div class="mr-3">
                                <div class="bg-danger text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 28px; height: 28px; font-weight: bold;">!</div>
                            </div>
                            <div>
                                <h6 class="font-weight-bold mb-1 text-gray-800">Revisi & Penolakan</h6>
                                <p class="text-muted mb-0">Jika status ditolak, baca catatan revisi operator dan unggah ulang bukti/naskah.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card: Bantuan & Kontak -->
            <div class="card shadow">
                <div class="card-header py-3 bg-light">
                    <h6 class="m-0 font-weight-bold text-gray-700"><i class="fas fa-question-circle mr-2 text-primary"></i> Butuh Bantuan?</h6>
                </div>
                <div class="card-body text-center py-4">
                    <p class="text-muted mb-3" style="font-size: 0.85rem;">Ada kendala atau salah unggah berkas pembayaran? Silakan hubungi bagian administrasi repositori perpustakaan.</p>
                    <a href="https://wa.me/628123456789" target="_blank" class="btn btn-success btn-block py-2">
                        <i class="fab fa-whatsapp mr-2" style="font-size: 1.1rem;"></i> Hubungi via WhatsApp
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
