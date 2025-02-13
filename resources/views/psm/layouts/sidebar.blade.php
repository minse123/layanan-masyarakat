<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('psm/dashboard') }}">
        <div class="img"
            style="background-image: url('{{ asset('frontend/images/logo-kementerian-1.png') }}'); background-size: contain; background-repeat: no-repeat; background-position: center; width: 60px; height: 60px;">
        </div>
        <div class="sidebar-brand-text mx-3">Pelayanan Digital</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ request()->is('psm/dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ url('psm/dashboard') }}" title="Dashboard">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <hr class="sidebar-divider">
    <li class="nav-item {{ request()->is('#') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('psm.konsultasi.index') }}" title="Master Konsultasi Pelatihan">
            <i class="fas fa-fw fa-comments"></i>
            <span>Master Konsultasi Pelatihan</span>
        </a>
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
