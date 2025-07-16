<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fas fa-bars text-primary"></i>
    </button>

    <!-- Topbar Search (Desktop) -->
    <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
        <div class="input-group">
            <input type="text" class="form-control bg-light border-0 small" placeholder="Cari data..."
                aria-label="Search" aria-describedby="basic-addon2">
            <div class="input-group-append">
                <button class="btn btn-primary" type="button">
                    <i class="fas fa-search fa-sm"></i>
                </button>
            </div>
        </div>
    </form>
    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">

        <!-- Realtime Clock -->
        <li class="nav-item d-flex align-items-center">
            <span id="datetime-display" class="mr-3 text-gray-600 small font-weight-bold"></span>
        </li>

        <!-- Nav Item - Search Dropdown (XS) -->
        <li class="nav-item dropdown no-arrow d-sm-none">
            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw text-primary"></i>
            </a>
            <!-- Dropdown - Search -->
            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                aria-labelledby="searchDropdown">
                <form class="form-inline mr-auto w-100 navbar-search">
                    <div class="input-group">
                        <input type="text" class="form-control bg-light border-0 small" placeholder="Cari data..."
                            aria-label="Search" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button">
                                <i class="fas fa-search fa-sm"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </li>

        <!-- Nav Item - Alerts (Contoh Notifikasi) -->
        {{-- 
        <li class="nav-item dropdown no-arrow mx-1">
            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-bell fa-fw text-warning"></i>
                <span class="badge badge-danger badge-counter">3+</span>
            </a>
            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                aria-labelledby="alertsDropdown">
                <h6 class="dropdown-header bg-warning text-white border-0">
                    Pusat Notifikasi
                </h6>
                <a class="dropdown-item d-flex align-items-center" href="#">
                    <div class="mr-3">
                        <div class="icon-circle bg-primary">
                            <i class="fas fa-file-alt text-white"></i>
                        </div>
                    </div>
                    <div>
                        <div class="small text-gray-500">12 Juli 2025</div>
                        <span class="font-weight-bold">Laporan bulanan siap diunduh!</span>
                    </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                    <div class="mr-3">
                        <div class="icon-circle bg-success">
                            <i class="fas fa-check-circle text-white"></i>
                        </div>
                    </div>
                    <div>
                        <div class="small text-gray-500">10 Juli 2025</div>
                        Pengajuan surat telah disetujui.
                    </div>
                </a>
                <a class="dropdown-item text-center small text-gray-500" href="#">Tampilkan Semua Notifikasi</a>
            </div>
        </li>
        --}}

        <div class="topbar-divider d-none d-sm-block"></div>

        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown"
                role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img class="img-profile rounded-circle mr-2" src="{{ url('/backend/img/undraw_profile.svg') }}"
                    style="width: 36px; height: 36px;">
                <div class="d-none d-lg-block text-left">
                    <div class="font-weight-bold text-primary">{{ ucfirst(Auth::user()->name) }}</div>
                    <div class="small text-gray-600">{{ ucfirst(Auth::user()->role) }}</div>
                </div>
            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="#">
                    <i class="fas fa-user-circle fa-sm fa-fw mr-2 text-primary"></i>
                    Profil Saya
                </a>
                <a class="dropdown-item" href="#">
                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-success"></i>
                    Pengaturan
                </a>
                <a class="dropdown-item" href="#">
                    <i class="fas fa-history fa-sm fa-fw mr-2 text-info"></i>
                    Log Aktivitas
                </a>
                <div class="dropdown-divider"></div>
                <form action="{{ route('logout') }}" method="POST" id="logout-form" style="display: none;">
                    @csrf
                </form>
                <a class="dropdown-item" href="#"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-danger"></i>
                    Keluar
                </a>
            </div>
        </li>
    </ul>
</nav>
