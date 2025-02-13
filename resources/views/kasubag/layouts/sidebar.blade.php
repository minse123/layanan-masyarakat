<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('kasubag/dashboard') }}">
        <div class="img"
            style="background-image: url('{{ asset('frontend/images/logo-kementerian-1.png') }}'); background-size: contain; background-repeat: no-repeat; background-position: center; width: 60px; height: 60px;">
        </div>
        <div class="sidebar-brand-text mx-3">Pelayanan Digital</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ request()->is('kasubag/dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ url('kasubag/dashboard') }}" title="Dashboard">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>
    <hr class="sidebar-divider">
    <li class="nav-item {{ request()->is('kasubag/tamu') ? 'active' : '' }}">
        <a class="nav-link" href="{{ url('kasubag/tamu') }}" title="Master Administrasi Surat">
            <i class="fas fa-fw fa-file-alt"></i>
            <span>Data Tamu</span>
        </a>
    </li>
    <li class="nav-item {{ request()->is('kasubag/surat') ? 'active' : '' }}">
        <a class="nav-link" href="{{ url('kasubag/surat') }}" title="Master Administrasi Surat">
            <i class="fas fa-fw fa-file-alt"></i>
            <span>Master Administrasi Surat</span>
        </a>
    </li>
    <hr class="sidebar-divider my-0">

    <!-- Heading -->
    <div class="sidebar-heading">Report</div>
    <li class="nav-item {{ request()->is('/kasubag/laporan/tamu') ? 'active' : '' }}">
        <a class="nav-link" href="{{ url('/kasubag/laporan/tamu') }}" title="Report Tamu">
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
                <a class="collapse-item" href="{{ route('kasubag.proses.surat') }}">Report Surat Proses</a>
                <a class="collapse-item" href="{{ route('kasubag.terima.surat') }}">Report Surat Terima</a>
                <a class="collapse-item" href="{{ route('kasubag.tolak.surat') }}">Report Surat Tolak</a>
            </div>
        </div>
    </li>
    {{-- <li class="nav-item {{ request()->is('#') ? 'active' : '' }}">
        <a class="nav-link" data-toggle="collapse" href="#reportKonsultasiCollapse" role="button" aria-expanded="false"
            aria-controls="reportKonsultasiCollapse" title="Report Konsultasi Pelatihan">
            <i class="fas fa-fw fa-file-alt"></i>
            <span>Report Konsultasi Pelatihan</span>
        </a>
        <div id="reportKonsultasiCollapse" class="collapse" aria-labelledby="headingUtilities"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Reports:</h6>
                <a class="collapse-item" href="{{ route('kasubag.konsultasi.pending') }}">Report Konsultasi Pending</a>
                <a class="collapse-item" href="{{ route('kasubag.konsultasi.dijawab') }}">Report Konsultasi Dijawab</a>
            </div>
        </div>
    </li> --}}

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle" title="Toggle Sidebar"></button>
    </div>
</ul>
<!-- End of Sidebar -->
