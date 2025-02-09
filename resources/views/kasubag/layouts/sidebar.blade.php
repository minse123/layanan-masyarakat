<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('dashboard') }}">
        <div class="img"
            style="background-image: url('{{ asset('frontend/images/logo-kementerian-1.png') }}'); background-size: contain; background-repeat: no-repeat; background-position: center; width: 60px; height: 60px;">
        </div>
        <div class="sidebar-brand-text mx-3">Pelayanan Digital</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ request()->is('admin/dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ url('admin/dashboard') }}" title="Dashboard">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">Report</div>
    <li class="nav-item {{ request()->is('/report/tamu') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('report.tamu') }}" title="Report Tamu">
            <i class="fas fa-fw fa-file"></i>
            <span>Report Tamu</span>
        </a>
    </li>
    <li class="nav-item {{ request()->is('admin/laporan') ? 'active' : '' }}">
        <a class="nav-link" data-toggle="collapse" href="#reportTamuCollapse" role="button" aria-expanded="false"
            aria-controls="reportTamuCollapse" title="Administrasi Surat">
            <i class="fas fa-fw fa-file-invoice"></i>
            <span>Administrasi Surat</span>
        </a>
        <div id="reportTamuCollapse" class="collapse" aria-labelledby="headingUtilities"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Reports:</h6>
                <a class="collapse-item" href="{{ route('admin.proses.surat') }}">Report Surat Proses</a>
                <a class="collapse-item" href="{{ route('admin.terima.surat') }}">Report Surat Terima</a>
                <a class="collapse-item" href="{{ route('admin.tolak.surat') }}">Report Surat Tolak</a>
            </div>
        </div>
    </li>
    <li class="nav-item {{ request()->is('#') ? 'active' : '' }}">
        <a class="nav-link" data-toggle="collapse" href="#reportKonsultasiCollapse" role="button" aria-expanded="false"
            aria-controls="reportKonsultasiCollapse" title="Report Konsultasi Pelatihan">
            <i class="fas fa-fw fa-file-alt"></i>
            <span>Report Konsultasi Pelatihan</span>
        </a>
        <div id="reportKonsultasiCollapse" class="collapse" aria-labelledby="headingUtilities"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Reports:</h6>
                <a class="collapse-item" href="{{ route('admin.konsultasi.pending') }}">Report Konsultasi Pending</a>
                <a class="collapse-item" href="{{ route('admin.konsultasi.dijawab') }}">Report Konsultasi Dijawab</a>
            </div>
        </div>
    </li>

    <hr class="sidebar-divider">


    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle" title="Toggle Sidebar"></button>
    </div>
</ul>
<!-- End of Sidebar -->
