<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar"
    style="background: linear-gradient(180deg, #224abe 0%, #6a89cc 100%);">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('admin/dashboard') }}">
        <div class="img"
            style="background-image: url('{{ asset('frontend/images/logo-kementerian-1.png') }}'); background-size: contain; background-repeat: no-repeat; background-position: center; width: 100px; height: 100px;">
        </div>
        <div class="sidebar-brand-text mx-3 font-weight-bold text-white">Pelayanan Masyarakat Digital</div>
    </a>
    <hr class="sidebar-divider my-0">

    <!-- Dashboard -->
    <li class="nav-item {{ request()->is('admin/dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ url('admin/dashboard') }}" title="Dashboard">
            <i class="fas fa-fw fa-tachometer-alt text-white"></i>
            <span class="font-weight-bold">Dashboard</span>
        </a>
    </li>
    <hr class="sidebar-divider">

    <!-- Konfigurasi -->
    <div class="sidebar-heading text-light">Konfigurasi Website</div>
    @php $isVideo = request()->routeIs('admin.video.*') || request()->routeIs('admin.jadwal-pelatihan.*'); @endphp
    <li class="nav-item {{ $isVideo ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#configCollapse"
            aria-expanded="{{ $isVideo ? 'true' : 'false' }}" aria-controls="configCollapse" title="Konfigurasi">
            <i class="fas fa-fw fa-cogs text-white"></i>
            <span>Konfigurasi</span>
        </a>
        <div id="configCollapse" class="collapse {{ $isVideo ? 'show' : '' }}" aria-labelledby="headingUtilities"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header text-primary">Atur Konten:</h6>
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

    <!-- Master Data -->
    <div class="sidebar-heading text-light">Master Data</div>
    <li class="nav-item {{ request()->is('admin/surat') ? 'active' : '' }}">
        <a class="nav-link" href="{{ url('admin/surat') }}" title="Master Administrasi Surat">
            <i class="fas fa-fw fa-folder-open text-white"></i>
            <span>Master Administrasi</span>
        </a>
    </li>
    <li class="nav-item {{ request()->routeIs('konsultasi.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ url('admin/konsultasi') }}" title="Master Konsultasi Pelatihan">
            <i class="fas fa-fw fa-comments text-white"></i>
            <span>Master Konsultasi</span>
        </a>
    </li>
    <hr class="sidebar-divider">

    <!-- Manajemen Soal Pelatihan -->
    @php
        $isSoalMenu =
            request()->routeIs('admin.kategori-soal-pelatihan.*') ||
            request()->routeIs('admin.soal-pelatihan.*') ||
            request()->routeIs('admin.rekap-nilai.*') ||
            request()->routeIs('admin.statistik-soal.*');
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
                <a class="collapse-item {{ request()->routeIs('admin.kategori-soal-pelatihan.*') ? 'active' : '' }}"
                    href="{{ route('admin.kategori-soal-pelatihan.index') }}">
                    <i class="fas fa-fw fa-tags text-primary"></i> Kategori Soal
                </a>
                <a class="collapse-item {{ request()->routeIs('admin.soal-pelatihan.*') ? 'active' : '' }}"
                    href="{{ route('admin.soal-pelatihan.index') }}">
                    <i class="fas fa-fw fa-list-alt text-primary"></i> Bank Soal
                </a>
                <a class="collapse-item {{ request()->routeIs('admin.rekap-nilai.*') ? 'active' : '' }}"
                    href="{{ route('admin.rekap-nilai.index') }}">
                    <i class="fas fa-fw fa-award text-primary"></i> Rekap Nilai Peserta
                </a>
                <a class="collapse-item {{ request()->routeIs('admin.statistik-soal.*') ? 'active' : '' }}"
                    href="{{ route('admin.statistik-soal.index') }}">
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
            request()->routeIs('report.video') ||
            request()->routeIs('laporan.jadwal-pelatihan') ||
            request()->routeIs('admin.surat.report') ||
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
                <h6 class="collapse-header text-primary">Laporan Konfigurasi:</h6>
                <a class="collapse-item {{ request()->routeIs('report.video') ? 'active' : '' }}"
                    href="{{ route('report.video') }}"><i class="fas fa-fw fa-video text-primary"></i> Video
                    Edukasi</a>
                <a class="collapse-item {{ request()->routeIs('laporan.jadwal-pelatihan') ? 'active' : '' }}"
                    href="{{ route('laporan.jadwal-pelatihan') }}"><i
                        class="fas fa-fw fa-calendar-alt text-primary"></i> Jadwal Pelatihan</a>
                <div class="collapse-divider"></div>
                <h6 class="collapse-header text-primary">Laporan Administrasi:</h6>
                <a class="collapse-item {{ request()->route('type') == 'proses' ? 'active' : '' }}"
                    href="{{ route('admin.surat.report', ['type' => 'proses']) }}"><i
                        class="fas fa-fw fa-sync-alt text-warning"></i> Surat
                    Proses</a>
                <a class="collapse-item {{ request()->route('type') == 'terima' ? 'active' : '' }}"
                    href="{{ route('admin.surat.report', ['type' => 'terima']) }}"><i
                        class="fas fa-fw fa-check-circle text-success"></i>
                    Surat Terima</a>
                <a class="collapse-item {{ request()->route('type') == 'tolak' ? 'active' : '' }}"
                    href="{{ route('admin.surat.report', ['type' => 'tolak']) }}"><i
                        class="fas fa-fw fa-times-circle text-danger"></i>
                    Surat Tolak</a>
                <div class="collapse-divider"></div>
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
    <hr class="sidebar-divider">

    <!-- Akun Pengguna -->
    <div class="sidebar-heading text-light">Manajemen Akun</div>
    <li class="nav-item {{ request()->is('admin/auth') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.akun') }}" title="Akun Pengguna">
            <i class="fas fa-fw fa-users-cog text-white"></i>
            <span>Akun Pengguna</span>
        </a>
    </li>

    <hr class="sidebar-divider d-none d-md-block">
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle" title="Toggle Sidebar"></button>
    </div>
</ul>
<!-- End of Sidebar -->
