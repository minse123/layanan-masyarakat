<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar"
    style="background: linear-gradient(180deg, #224abe 0%, #6a89cc 100%);">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('psm/dashboard') }}">
        <div class="img"
            style="background-image: url('{{ asset('frontend/images/logo-kementerian-1.png') }}'); background-size: contain; background-repeat: no-repeat; background-position: center; width: 100px; height: 100px;">
        </div>
        <div class="sidebar-brand-text mx-3 font-weight-bold text-white">Pelayanan Masyarakat Digital</div>
    </a>
    <hr class="sidebar-divider my-0">

    <!-- Dashboard -->
    <li class="nav-item {{ request()->is('psm/dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ url('psm/dashboard') }}" title="Dashboard">
            <i class="fas fa-fw fa-tachometer-alt text-white"></i>
            <span class="font-weight-bold">Dashboard</span>
        </a>
    </li>

    @section('breadcrumb')
        <li class="breadcrumb-item"><a href="{{ url('psm/dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">
            {{ ucfirst(str_replace('.', ' ', Route::currentRouteName())) }}</li>
    @endsection
    <hr class="sidebar-divider">

    <!-- Master Data -->
    <div class="sidebar-heading text-light">Master Data</div>
    <li class="nav-item {{ request()->is('psm/konsultasi') ? 'active' : '' }}">
        <a class="nav-link" href="{{ url('psm/konsultasi') }}" title="Master Konsultasi Pelatihan">
            <i class="fas fa-fw fa-comments text-white"></i>
            <span>Master Konsultasi</span>
        </a>
    </li>
    <hr class="sidebar-divider">

    <!-- Manajemen Soal Pelatihan -->
    @php
        $isSoalMenu =
            request()->is('psm/dashboard') ||
            request()->Is('psm/kategori-soal-pelatihan') ||
            request()->routeIs('psm.soal-pelatihan.*') ||
            request()->routeIs('psm.rekap-nilai.*') ||
            request()->routeIs('psm.statistik-soal.*');
    @endphp
    <div class="sidebar-heading text-light">Ujian & Pelatihan</div>
    <li class="nav-item {{ $isSoalMenu ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#soalPelatihanCollapse"
            aria-expanded="{{ $isSoalMenu ? 'true' : 'false' }}" aria-controls="soalPelatihanCollapse"
            title="Manajemen Soal Pelatihan">
            <i class="fas fa-fw fa-book-open text-white"></i>
            <span>Manajemen Ujian</span>
        </a>
        <div id="soalPelatihanCollapse" class="collapse {{ $isSoalMenu ? 'show' : '' }}" aria-labelledby="headingSoal"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header text-primary">Kelola Ujian:</h6>
                <a class="collapse-item {{ request()->Is('psm/kategori-soal-pelatihan') ? 'active' : '' }}"
                    href="{{ route('psm.kategori-soal-pelatihan.index') }}">
                    <i class="fas fa-fw fa-tags text-primary"></i> Kategori Soal
                </a>
                <a class="collapse-item {{ request()->routeIs('psm.soal-pelatihan.*') ? 'active' : '' }}"
                    href="{{ route('psm.soal-pelatihan.index') }}">
                    <i class="fas fa-fw fa-list-alt text-primary"></i> Bank Soal
                </a>
                <a class="collapse-item {{ request()->routeIs('psm.rekap-nilai.*') ? 'active' : '' }}"
                    href="{{ route('psm.rekap-nilai.index') }}">
                    <i class="fas fa-fw fa-award text-primary"></i> Rekap Nilai Peserta
                </a>
                <a class="collapse-item {{ request()->routeIs('psm.statistik-soal.*') ? 'active' : '' }}"
                    href="{{ route('psm.statistik-soal.index') }}">
                    <i class="fas fa-fw fa-chart-pie text-primary"></i> Statistik Soal
                </a>
            </div>
        </div>
    </li>
    <hr class="sidebar-divider">

    <!-- Laporan -->
    <div class="sidebar-heading text-light">Laporan</div>
    @php
        $isReportMenu =
            request()->is('psm/dashboard') ||
            request()->routeIs('konsultasi.inti.report') ||
            request()->routeIs('konsultasi.pendukung.report') ||
            request()->routeIs('report-soal-pelatihan') ||
            request()->routeIs('report-rekap-nilai') ||
            request()->routeIs('report-hasil-peserta') ||
            request()->routeIs('report-statistik-soal');
    @endphp
    <li class="nav-item {{ $isReportMenu ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#reportCollapse"
            aria-expanded="{{ $isReportMenu ? 'true' : 'false' }}" aria-controls="reportCollapse" title="Laporan">
            <i class="fas fa-fw fa-file-alt text-white"></i>
            <span>Laporan</span>
        </a>
        <div id="reportCollapse" class="collapse {{ $isReportMenu ? 'show' : '' }}" aria-labelledby="headingUtilities"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header text-primary">Laporan Konsultasi:</h6>
                <a class="collapse-item {{ request()->routeIs('konsultasi.inti.report') ? 'active' : '' }}"
                    href="{{ route('konsultasi.inti.report') }}">
                    <i class="fas fa-fw fa-star text-info"></i> Pelatihan Inti
                </a>
                <a class="collapse-item {{ request()->routeIs('konsultasi.pendukung.report') ? 'active' : '' }}"
                    href="{{ route('konsultasi.pendukung.report') }}">
                    <i class="fas fa-fw fa-puzzle-piece text-secondary"></i> Pelatihan Pendukung
                </a>
                <div class="collapse-divider"></div>
                <h6 class="collapse-header text-primary">Laporan Ujian:</h6>
                <a class="collapse-item {{ request()->routeIs('report-soal-pelatihan') ? 'active' : '' }}"
                    href="{{ route('report-soal-pelatihan') }}">
                    <i class="fas fa-fw fa-book text-primary"></i> Bank Soal
                </a>
                <a class="collapse-item {{ request()->routeIs('report-rekap-nilai') ? 'active' : '' }}"
                    href="{{ route('report-rekap-nilai') }}">
                    <i class="fas fa-fw fa-award text-primary"></i> Rekap Nilai Keseluruhan
                </a>
                <a class="collapse-item {{ request()->routeIs('report-hasil-peserta') ? 'active' : '' }}"
                    href="{{ route('report-hasil-peserta') }}">
                    <i class="fas fa-fw fa-user-check text-primary"></i> Hasil Peserta
                </a>
                <a class="collapse-item {{ request()->routeIs('report-statistik-soal') ? 'active' : '' }}"
                    href="{{ route('report-statistik-soal') }}">
                    <i class="fas fa-fw fa-chart-pie text-primary"></i> Statistik Soal
                </a>
            </div>
        </div>
    </li>
    <hr class="sidebar-divider d-none d-md-block">
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle" title="Toggle Sidebar"></button>
    </div>
</ul>
<!-- End of Sidebar -->
