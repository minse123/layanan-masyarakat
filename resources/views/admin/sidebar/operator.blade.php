<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar"
    style="background: linear-gradient(180deg, #224abe 0%, #6a89cc 100%);">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('operator.dashboard') }}">
        <div class="img"
            style="background-image: url('{{ asset('frontend/images/logo-kementerian-1.png') }}'); background-size: contain; background-repeat: no-repeat; background-position: center; width: 100px; height: 100px;">
        </div>
        <div class="sidebar-brand-text mx-3 font-weight-bold text-white">Operator Dashboard</div>
    </a>
    <hr class="sidebar-divider my-0">

    <!-- Dashboard -->
    <li class="nav-item {{ request()->is('operator/dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ url('operator/dashboard') }}" title="Dashboard">
            <i class="fas fa-fw fa-tachometer-alt text-white"></i>
            <span class="font-weight-bold">Dashboard</span>
        </a>
    </li>

    @section('breadcrumb')
        <li class="breadcrumb-item"><a href="{{ url('operator/dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ ucfirst(str_replace('.', ' ', Route::currentRouteName())) }}</li>
    @endsection
    <hr class="sidebar-divider">

    <!-- Konfigurasi -->
    <div class="sidebar-heading text-light">Manajemen Konfigurasi</div>
    @php $isConfiguration = request()->routeIs('admin.video.*') || request()->routeIs('admin.jadwal-pelatihan.*'); @endphp
    <li class="nav-item {{ $isConfiguration ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseConfiguration"
            aria-expanded="{{ $isConfiguration ? 'true' : 'false' }}" aria-controls="collapseConfiguration"
            title="Konfigurasi">
            <i class="fas fa-fw fa-cog text-white"></i>
            <span>Konfigurasi</span>
        </a>
        <div id="collapseConfiguration" class="collapse {{ $isConfiguration ? 'show' : '' }}"
            aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header text-primary">Manajemen Konfigurasi:</h6>
                <a class="collapse-item {{ request()->routeIs('admin.video.*') ? 'active' : '' }}"
                    href="{{ route('admin.video.index') }}"><i class="fas fa-fw fa-video text-primary"></i> Video
                    Edukasi</a>
                <a class="collapse-item {{ request()->routeIs('admin.jadwal-pelatihan.*') ? 'active' : '' }}"
                    href="{{ route('admin.jadwal-pelatihan.index') }}"><i
                        class="fas fa-fw fa-calendar-alt text-primary"></i>
                    Jadwal Pelatihan</a>
            </div>
        </div>
    </li>
    <hr class="sidebar-divider">

    <!-- Laporan -->
    <div class="sidebar-heading text-light">Laporan</div>
    @php
        $isReportMenu = request()->routeIs('report.video') || request()->routeIs('laporan.jadwal-pelatihan');
    @endphp
    <li class="nav-item {{ $isReportMenu ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseReports"
            aria-expanded="{{ $isReportMenu ? 'true' : 'false' }}" aria-controls="collapseReports" title="Laporan">
            <i class="fas fa-fw fa-file-alt text-white"></i>
            <span>Laporan</span>
        </a>
        <div id="collapseReports" class="collapse {{ $isReportMenu ? 'show' : '' }}" aria-labelledby="headingReports"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header text-primary">Laporan Konfigurasi:</h6>
                <a class="collapse-item {{ request()->routeIs('report.video') ? 'active' : '' }}"
                    href="{{ route('report.video') }}"><i class="fas fa-fw fa-video text-primary"></i> Laporan
                    Video</a>
                <a class="collapse-item {{ request()->routeIs('laporan.jadwal-pelatihan') ? 'active' : '' }}"
                    href="{{ route('laporan.jadwal-pelatihan') }}"><i
                        class="fas fa-fw fa-calendar-alt text-primary"></i> Laporan Jadwal Pelatihan</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle" title="Toggle Sidebar"></button>
    </div>

</ul>
<!-- End of Sidebar -->
