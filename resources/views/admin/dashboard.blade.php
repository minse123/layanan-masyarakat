                @extends('admin.app')
                @section('content')
                    <div class="container">
                        <div class="container-fluid">
                            <!-- Page Heading -->
                            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                                <h1 class="h3 mb-0 text-gray-800">Dashboard Admin</h1>
                            </div>

                            <!-- Content Row -->
                            <div class="row">
                                <!-- Grup 1: Tamu dan Konsultasi -->
                                <div class="col-lg-6">
                                    <div class="row">
                                        <!-- Total Tamu -->
                                        <div class="col-md-6 mb-4">
                                            <div class="card border-left-primary shadow h-100 py-2">
                                                <div class="card-body">
                                                    <div class="row no-gutters align-items-center">
                                                        <div class="col mr-2">
                                                            <div
                                                                class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                                Total Tamu
                                                            </div>
                                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                                {{ number_format($totalTamu) }}</div>
                                                        </div>
                                                        <div class="col-auto">
                                                            <i class="fas fa-users fa-2x text-gray-300"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Konsultasi Pending -->
                                        <div class="col-md-6 mb-4">
                                            <div class="card border-left-warning shadow h-100 py-2">
                                                <div class="card-body">
                                                    <div class="row no-gutters align-items-center">
                                                        <div class="col mr-2">
                                                            <div
                                                                class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                                Konsultasi Pending
                                                            </div>
                                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                                {{ number_format($totalKonsultasiPending) }}</div>
                                                        </div>
                                                        <div class="col-auto">
                                                            <i class="fas fa-hourglass-half fa-2x text-gray-300"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Grup 2: Konsultasi Dijawab dan Surat Proses -->
                                <div class="col-lg-6">
                                    <div class="row">
                                        <!-- Konsultasi Dijawab -->
                                        <div class="col-md-6 mb-4">
                                            <div class="card border-left-success shadow h-100 py-2">
                                                <div class="card-body">
                                                    <div class="row no-gutters align-items-center">
                                                        <div class="col mr-2">
                                                            <div
                                                                class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                                Konsultasi Dijawab
                                                            </div>
                                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                                {{ number_format($totalKonsultasiDijawab) }}</div>
                                                        </div>
                                                        <div class="col-auto">
                                                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Surat Proses -->
                                        <div class="col-md-6 mb-4">
                                            <div class="card border-left-info shadow h-100 py-2">
                                                <div class="card-body">
                                                    <div class="row no-gutters align-items-center">
                                                        <div class="col mr-2">
                                                            <div
                                                                class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                                Surat Proses
                                                            </div>
                                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                                {{ number_format($totalSuratProses) }}</div>
                                                        </div>
                                                        <div class="col-auto">
                                                            <i class="fas fa-spinner fa-2x text-gray-300"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Grup 3: Surat Terima dan Surat Tolak -->
                                <div class="col-lg-6">
                                    <div class="row">
                                        <!-- Surat Terima -->
                                        <div class="col-md-6 mb-4">
                                            <div class="card border-left-primary shadow h-100 py-2">
                                                <div class="card-body">
                                                    <div class="row no-gutters align-items-center">
                                                        <div class="col mr-2">
                                                            <div
                                                                class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                                Surat Terima
                                                            </div>
                                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                                {{ number_format($totalSuratTerima) }}</div>
                                                        </div>
                                                        <div class="col-auto">
                                                            <i class="fas fa-envelope-open-text fa-2x text-gray-300"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Surat Tolak -->
                                        <div class="col-md-6 mb-4">
                                            <div class="card border-left-danger shadow h-100 py-2">
                                                <div class="card-body">
                                                    <div class="row no-gutters align-items-center">
                                                        <div class="col mr-2">
                                                            <div
                                                                class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                                                Surat Tolak
                                                            </div>
                                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                                {{ number_format($totalSuratTolak) }}</div>
                                                        </div>
                                                        <div class="col-auto">
                                                            <i class="fas fa-times-circle fa-2x text-gray-300"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Notifikasi -->
                            <div class="row mt-4">
                                <div class="col-lg-12">
                                    <div class="card shadow mb-4">
                                        <div class="card-body">
                                            <h5 class="text-gray-800">Notifikasi</h5>
                                            <ul>
                                                <li>Konsultasi belum dijawab:
                                                    <strong>{{ number_format($totalKonsultasiPending) }}</strong>
                                                </li>
                                                <li>Surat perlu diproses:
                                                    <strong>{{ number_format($totalSuratProses) }}</strong>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endsection
