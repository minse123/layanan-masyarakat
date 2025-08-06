@extends($layout)
@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard Operator</h1>
        </div>

        <!-- Info Cards -->
        <div class="row">
            <!-- Total Video Card -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Video</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalVideos }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-video fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Jadwal Pelatihan Card -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Jadwal
                                    Pelatihan
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalJadwal }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-calendar-alt fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="row">
            <!-- Video Status Chart -->
            <div class="col-xl-6 col-lg-6">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Status Video</h6>
                    </div>
                    <div class="card-body">
                        <div class="chart-pie pt-4 pb-2">
                            <canvas id="videoStatusPieChart"></canvas>
                        </div>
                        <hr>
                        Distribusi video berdasarkan status (Publish, Belum Publish).
                    </div>
                </div>
            </div>

            <!-- Jadwal Pelatihan Status Chart -->
            <div class="col-xl-6 col-lg-6">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Status Jadwal Pelatihan</h6>
                    </div>
                    <div class="card-body">
                        <div class="chart-pie pt-4 pb-2">
                            <canvas id="jadwalStatusPieChart"></canvas>
                        </div>
                        <hr>
                        Distribusi jadwal pelatihan (Terlaksana, Belum Terlaksana).
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity Row -->
        <div class="row">
            <!-- Recent Videos -->
            <div class="col-xl-6 col-lg-6">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Video Terbaru</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Judul Video</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($recentVideos as $video)
                                        <tr>
                                            <td>{{ $video->judul }}</td>
                                            <td>
                                                <span class="badge badge-{{ $video->ditampilkan ? 'success' : 'warning' }}">
                                                    {{ $video->ditampilkan ? 'Publish' : 'Belum Publish' }}
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="2">Tidak ada video terbaru.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Upcoming Jadwal Pelatihan -->
            <div class="col-xl-6 col-lg-6">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Jadwal Pelatihan Mendatang</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Nama Pelatihan</th>
                                        <th>Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($upcomingJadwals as $jadwal)
                                        <tr>
                                            <td>{{ $jadwal->nama_pelatihan }}</td>
                                            <td>{{ \Carbon\Carbon::parse($jadwal->tanggal_mulai)->format('d M Y') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="2">Tidak ada jadwal mendatang.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <!-- Page level plugins -->
    <script src="{{ asset('backend/vendor/chart.js/Chart.min.js') }}"></script>

    <!-- Custom scripts for charts -->
    <script>
        // Set new default font family and font color
        Chart.defaults.global.defaultFontFamily = 'Nunito',
            '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
        Chart.defaults.global.defaultFontColor = '#858796';

        // Video Status Pie Chart
        var ctxVideo = document.getElementById("videoStatusPieChart");
        var videoStatusPieChart = new Chart(ctxVideo, {
            type: 'doughnut',
            data: {
                labels: ["Publish", "Belum Publish"],
                datasets: [{
                    data: [{{ $totalVideoPublish }}, {{ $totalVideoBelumPublish }}],
                    backgroundColor: ['#1cc88a', '#f6c23e'],
                    hoverBackgroundColor: ['#17a673', '#e5b344'],
                    hoverBorderColor: "rgba(234, 236, 244, 1)",
                }],
            },
            options: {
                maintainAspectRatio: false,
                tooltips: {
                    backgroundColor: "rgb(255,255,255)",
                    bodyFontColor: "#858796",
                    borderColor: '#dddfeb',
                    borderWidth: 1,
                    xPadding: 15,
                    yPadding: 15,
                    displayColors: false,
                    caretPadding: 10,
                },
                legend: {
                    display: true
                },
                cutoutPercentage: 80,
            },
        });

        // Jadwal Pelatihan Status Pie Chart
        var ctxJadwal = document.getElementById("jadwalStatusPieChart");
        var jadwalStatusPieChart = new Chart(ctxJadwal, {
            type: 'doughnut',
            data: {
                labels: ["Terlaksana", "Belum Terlaksana"],
                datasets: [{
                    data: [{{ $jadwalTerlaksana }}, {{ $jadwalBelumTerlaksana }}],
                    backgroundColor: ['#36b9cc', '#f6c23e'],
                    hoverBackgroundColor: ['#2c9faf', '#e5b344'],
                    hoverBorderColor: "rgba(234, 236, 244, 1)",
                }],
            },
            options: {
                maintainAspectRatio: false,
                tooltips: {
                    backgroundColor: "rgb(255,255,255)",
                    bodyFontColor: "#858796",
                    borderColor: '#dddfeb',
                    borderWidth: 1,
                    xPadding: 15,
                    yPadding: 15,
                    displayColors: false,
                    caretPadding: 10,
                },
                legend: {
                    display: true
                },
                cutoutPercentage: 80,
            },
        });
    </script>
@endsection
