@extends('layouts.operator')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-6">
        <h1 class="text-2xl font-bold">Riwayat Dokumen</h1>
        <a href="{{ route('operator.dokumen.export') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <style>
        td.dt-control {
            cursor: pointer;
        }
        td.dt-control .expand-icon {
            display: inline-block;
            transition: transform 0.2s ease-in-out;
        }
        tr.shown td.dt-control .expand-icon {
            transform: rotate(90deg);
        }
        .detail-table th {
            width: 180px;
            font-weight: bold;
            color: #4e73df;
        }
    </style>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Dokumen</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <form method="GET" action="{{ route('operator.dokumen.riwayat') }}">
                    <div class="row mb-3">

                        <div class="col-md-3">
                            <input type="text" name="search" class="form-control" placeholder="Judul / Nama / NIM"
                                value="{{ request('search') }}">
                        </div>

                        <div class="col-md-3">
                            <select name="prodi" class="form-control">
                                <option value="">-- Program Studi --</option>
                                @foreach ($programStudis as $ps)
                                    <option value="{{ $ps->id }}" {{ request('prodi') == $ps->id ? 'selected' : '' }}>{{ $ps->nama_prodi }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-2">
                            <select name="tahun" class="form-control">
                                <option value="">-- Tahun --</option>
                                <option value="2024" {{ request('tahun') == '2024' ? 'selected' : '' }}>2024</option>
                                <option value="2025" {{ request('tahun') == '2025' ? 'selected' : '' }}>2025</option>
                                <option value="2026" {{ request('tahun') == '2026' ? 'selected' : '' }}>2026</option>
                            </select>
                        </div>

                        <div class="col-md-2">
                            <select name="status" class="form-control">
                                <option value="">-- Status --</option>
                                <option value="Sudah Dicek" {{ request('status') == 'Sudah Dicek' ? 'selected' : '' }}>Sudah Dicek
                                </option>
                                <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai
                                </option>
                                <option value="Ditolak" {{ request('status') == 'Ditolak' ? 'selected' : '' }}>Ditolak
                                </option>
                            </select>
                        </div>

                        <div class="col-md-2">
                            <button class="btn btn-primary mr-1">
                                <i class="fas fa-search"></i> Cari
                            </button>
                            <a href="{{ route('operator.dokumen.riwayat') }}" class="btn btn-secondary">
                                Reset
                            </a>
                        </div>

                    </div>
                </form>
                <table class="table table-bordered" id="dokumenTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>NIM</th>
                            <th>Program Studi</th>
                            <th>Tanggal Pengajuan</th>
                            <th>Tanggal Cek</th>
                            <th>Status & Riwayat</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>NIM</th>
                            <th>Program Studi</th>
                            <th>Tanggal Pengajuan</th>
                            <th>Tanggal Cek</th>
                            <th>Status & Riwayat</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @if ($dokumen->count() > 0)
                            @foreach ($dokumen as $d)
                                <tr data-judul="{{ $d->judul }}"
                                    data-jenis="{{ $d->jenis_dokumen }}"
                                    data-file-url="{{ asset('storage/' . $d->file_asli) }}"
                                    data-bukti-url="{{ $d->bukti_bayar ? asset('storage/' . $d->bukti_bayar) : '' }}"
                                    data-wa-number="{{ $d->mahasiswa->whatsapp ?? '' }}"
                                    data-wa-link="@if($d->mahasiswa->whatsapp)@php $waClean = preg_replace('/[^0-9]/', '', $d->mahasiswa->whatsapp); if (str_starts_with($waClean, '0')) { $waClean = '62' . substr($waClean, 1); } @endphp{{ $waClean }}@endif">
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="dt-control">
                                        <i class="fas fa-caret-right text-primary expand-icon mr-2"></i>
                                        <strong>{{ $d->mahasiswa->nama }}</strong>

                                        <!-- Hidden actions container for JavaScript to render inside the child row -->
                                        <div class="row-actions d-none">
                                            <a href="{{ route('operator.dokumen.show', $d->id) }}" class="btn btn-sm btn-info mr-1 mb-1"
                                                title="Lihat Detail">
                                                <i class="fas fa-eye"></i> Detail
                                            </a>
                                            {{-- allow operator to change status quickly --}}
                                            <form action="{{ route('operator.updateStatus', $d->id) }}" method="POST"
                                                class="d-inline mr-1 mb-1">
                                                @csrf
                                                @method('PATCH')
                                                <select name="status" onchange="this.form.submit()"
                                                    class="btn btn-sm btn-primary dropdown-toggle">
                                                    <option value="Pending"
                                                        {{ $d->status == 'Pending' ? 'selected' : '' }}>
                                                        Pending</option>
                                                    <option value="Diproses"
                                                        {{ $d->status == 'Diproses' ? 'selected' : '' }}>
                                                        Diproses
                                                    </option>
                                                    <option value="Sudah Dicek"
                                                        {{ $d->status == 'Sudah Dicek' ? 'selected' : '' }}>
                                                        Sudah Dicek
                                                    </option>
                                                    <option value="Selesai"
                                                        {{ $d->status == 'Selesai' ? 'selected' : '' }}>
                                                        Selesai</option>
                                                    <option value="Ditolak"
                                                        {{ $d->status == 'Ditolak' ? 'selected' : '' }}>
                                                        Ditolak</option>
                                                </select>
                                            </form>
                                        </div>
                                    </td>
                                    <td>{{ $d->mahasiswa->nim }}</td>
                                    <td>{{ optional($d->mahasiswa->programStudi)->nama_prodi ?? '-' }}</td>
                                    <td>{{ $d->created_at->format('d-m-Y H:i') }}</td>
                                    <td>
                                        @if($d->hasilTurnitin && $d->hasilTurnitin->tanggal_cek)
                                            {{ $d->hasilTurnitin->tanggal_cek->format('d-m-Y H:i') }}
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($d->status == 'Pending')
                                            <span class="badge bg-warning text-dark mb-1">{{ $d->status }}</span>
                                        @elseif($d->status == 'Diproses')
                                            <span class="badge bg-info text-white mb-1">{{ $d->status }}</span>
                                        @elseif($d->status == 'Sudah Dicek')
                                            <span class="badge bg-primary text-white mb-1">{{ $d->status }}</span>
                                        @elseif($d->status == 'Selesai')
                                            <span class="badge bg-success text-white mb-1">{{ $d->status }}</span>
                                        @elseif($d->status == 'Ditolak')
                                            <span class="badge bg-danger text-white mb-1">{{ $d->status }}</span>
                                        @else
                                            <span class="badge bg-secondary text-white mb-1">{{ $d->status }}</span>
                                        @endif
                                        
                                        @if($d->hasilTurnitin && in_array($d->status, ['Sudah Dicek', 'Selesai']))
                                            <div class="small mt-1 text-muted">
                                                <i class="fas fa-upload fa-xs"></i> <b>Uploaded by:</b> {{ optional($d->hasilTurnitin->operator)->name ?? 'System' }}<br>
                                                @if($d->status == 'Selesai')
                                                <i class="fas fa-download fa-xs"></i> <b>Downloaded by:</b> {{ optional($d->mahasiswa)->nama ?? 'Mahasiswa' }}
                                                @else
                                                <i class="fas fa-clock fa-xs"></i> Menunggu diunduh
                                                @endif
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">
                                    <i class="fas fa-inbox"></i> Tidak ada dokumen yang tersedia.
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@push('scripts')
    <script>
        $(document).ready(function() {
            var table = $('#dokumenTable').DataTable({
                pageLength: 10,
                searching: true,
                order: [[5, 'asc']],
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'
                }
            });

            // Format child row
            function formatChildRow(tr) {
                var judul = tr.data('judul');
                var jenis = tr.data('jenis');
                var fileUrl = tr.data('file-url');
                var buktiUrl = tr.data('bukti-url');
                var waNumber = tr.data('wa-number');
                var waLink = tr.data('wa-link');
                var aksiHtml = tr.find('.row-actions').html();

                var buktiHtml = buktiUrl 
                    ? `<a href="${buktiUrl}" target="_blank" class="btn btn-info btn-sm">
                           <i class="fas fa-receipt"></i> Lihat Bukti
                       </a>`
                    : `<span class="text-muted">-</span>`;

                var waHtml = waNumber
                    ? `<a href="https://wa.me/${waLink}" target="_blank" class="btn btn-outline-success btn-sm">
                           <i class="fab fa-whatsapp"></i> ${waNumber}
                       </a>`
                    : `<span class="text-muted">-</span>`;

                return `
                    <div class="p-3 bg-light border rounded">
                        <div class="row">
                            <div class="col-md-8">
                                <h6 class="font-weight-bold text-primary mb-3"><i class="fas fa-info-circle"></i> Informasi Detail Dokumen</h6>
                                <table class="table table-sm table-borderless mb-0 detail-table">
                                    <tbody>
                                        <tr>
                                            <th>Judul Dokumen</th>
                                            <td>: ${judul}</td>
                                        </tr>
                                        <tr>
                                            <th>Jenis Dokumen</th>
                                            <td>: ${jenis}</td>
                                        </tr>
                                        <tr>
                                            <th>File Asli</th>
                                            <td>: 
                                                <a href="${fileUrl}" download class="btn btn-success btn-sm py-0">
                                                    <i class="fas fa-download"></i> Download File
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Bukti Pembayaran</th>
                                            <td>: ${buktiHtml}</td>
                                        </tr>
                                        <tr>
                                            <th>No. WhatsApp</th>
                                            <td>: ${waHtml}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-4 border-left">
                                <h6 class="font-weight-bold text-primary mb-3"><i class="fas fa-cog"></i> Aksi Cepat</h6>
                                <div class="d-flex flex-wrap align-items-center">
                                    ${aksiHtml}
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            }

            // Click event handler for expanding/collapsing child rows
            $('#dokumenTable tbody').on('click', 'td.dt-control', function() {
                var tr = $(this).closest('tr');
                var row = table.row(tr);

                if (row.child.isShown()) {
                    row.child.hide();
                    tr.removeClass('shown');
                } else {
                    row.child(formatChildRow(tr)).show();
                    tr.addClass('shown');
                }
            });
        });
    </script>
@endpush

@endsection
