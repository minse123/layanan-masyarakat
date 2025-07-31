<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar"
    style="background: linear-gradient(180deg, #224abe 0%, #6a89cc 100%);">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('kasubag/dashboard') }}">
        <div class="img"
            style="background-image: url('{{ asset('frontend/images/logo-kementerian-1.png') }}'); background-size: contain; background-repeat: no-repeat; background-position: center; width: 100px; height: 100px;">
        </div>
        <div class="sidebar-brand-text mx-3 font-weight-bold text-white">Pelayanan Masyarakat Digital</div>
    </a>
    <hr class="sidebar-divider my-0">

    <!-- Dashboard -->
    <li class="nav-item {{ request()->is('kasubag/dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('kasubag.dashboard') }}" title="Dashboard">
            <i class="fas fa-fw fa-tachometer-alt text-white"></i>
            <span class="font-weight-bold">Dashboard</span>
        </a>
    </li>
    <hr class="sidebar-divider">

    <!-- Master Data -->
    <div class="sidebar-heading text-light">Master Data</div>
    <li class="nav-item {{ request()->is('kasubag/surat') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.master.surat') }}" title="Master Administrasi Surat">
            <i class="fas fa-fw fa-folder-open text-white"></i>
            <span>Master Administrasi</span>
        </a>
    </li>
    <hr class="sidebar-divider">

    <!-- Laporan -->
    <div class="sidebar-heading text-light">Laporan</div>
    @php
        $isReportMenu = request()->routeIs('admin.surat.report');
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
                <h6 class="collapse-header text-primary">Laporan Administrasi:</h6>
                <a class="collapse-item {{ request()->route('type') == 'proses' ? 'active' : '' }}"
                    href="{{ route('admin.surat.report', ['type' => 'proses']) }}"><i class="fas fa-fw fa-sync-alt text-warning"></i> Surat
                    Proses</a>
                <a class="collapse-item {{ request()->route('type') == 'terima' ? 'active' : '' }}"
                    href="{{ route('admin.surat.report', ['type' => 'terima']) }}"><i class="fas fa-fw fa-check-circle text-success"></i>
                    Surat Terima</a>
                <a class="collapse-item {{ request()->route('type') == 'tolak' ? 'active' : '' }}"
                    href="{{ route('admin.surat.report', ['type' => 'tolak']) }}"><i class="fas fa-fw fa-times-circle text-danger"></i>
                    Surat Tolak</a>
            </div>
        </div>
    </li>
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle" title="Toggle Sidebar"></button>
    </div>
</ul>
<!-- End of Sidebar -->
