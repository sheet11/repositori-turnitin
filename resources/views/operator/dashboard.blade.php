@extends('layouts.operator')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
    </div>

    <div class="row">

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Dokumen</div>
                            {{-- <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $total }}</div> --}}
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- <div class="bg-white p-6 rounded shadow">
        <h2 class="text-gray-500">Total Dokumen</h2>
        <p class="text-3xl font-bold">{{ $total }}</p>
    </div> --}}

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Pending</div>
                            {{-- <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $pending }}</div> --}}
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- <div class="bg-white p-6 rounded shadow">
        <h2 class="text-gray-500">Pending</h2>
        <p class="text-3xl font-bold text-yellow-500">{{ $pending }}</p>
    </div> --}}

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">rata"
                            </div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    {{-- <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"> --}}
                                    {{-- {{ number_format($rataSimilarity, 2) }}%</div> --}}
                                </div>
                                <div class="col">
                                    <div class="progress progress-sm mr-2">
                                        <div class="progress-bar bg-info" role="progressbar" style="width: 50%"
                                            aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- <div class="bg-white p-6 rounded shadow">
        <h2 class="text-gray-500">Rata-rata Similarity</h2>
        <p class="text-3xl font-bold text-green-600">{{ number_format($rataSimilarity,2) }}%</p>
    </div> --}}

    </div>
@endsection
