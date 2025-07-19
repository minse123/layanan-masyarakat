<!-- Topbar -->
@include('sweetalert::alert')
<nav class="navbar navbar-expand-lg">

    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            <img src="{{ asset('frontend/images/logo-kementerian.png') }}" alt="Logo" class="navbar-brand-icon">
            <span>BPPMDDTT</span>
            <span>Banjarmasin</span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-lg-auto me-lg-4">
                <li class="nav-item">
                    <a class="nav-link click-scroll" href="{{url('/masyarakat/dashboard')}}#section_1">Beranda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link click-scroll" href="{{url('/masyarakat/dashboard')}}#section_2">Layanan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link click-scroll" href="{{url('/masyarakat/dashboard')}}#section_3">Tentang Kami</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link click-scroll" href="{{url('/masyarakat/dashboard')}}#section_4">Kontak</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link click-scroll" href="{{url('/masyarakat/dashboard')}}#section_video">Video Pelatihan</a>
                </li>

                <div class="d-none d-lg-flex align-items-center ms-lg-3">
                    @auth
                        <!-- Tombol Notifikasi Konsultasi -->
                        <button type="button" class="btn btn-outline-warning rounded-circle position-relative me-2"
                            data-bs-toggle="modal" data-bs-target="#notifKonsultasiModal" title="Notifikasi Konsultasi">
                            <i class="bi bi-bell" style="font-size: 1.5rem;"></i>
                            @php
                                $jumlahBelumDijawab = $konsultasi->where('status', 'Pending')->count();
                            @endphp
                            @if ($jumlahBelumDijawab > 0)
                                <span
                                    class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    {{ $jumlahBelumDijawab }}
                                </span>
                            @endif
                        </button>

                        <div class="dropdown">
                            <button class="btn px-4 py-2 rounded-pill dropdown-toggle d-flex align-items-center gap-2"
                                type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false"
                                style="font-size: 1.1rem; font-weight: 600; min-height: 48px;">
                                <span
                                    class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                                    style="width:38px;height:38px;">
                                    <i class="bi bi-person" style="font-size:1.5rem;"></i>
                                </span>
                                <span class="ms-2 text-white">{{ Auth::user()->name }}</span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow animated--fade-in"
                                aria-labelledby="userDropdown">
                                <li>
                                    <a class="dropdown-item d-flex align-items-center gap-2" href="#"
                                        data-bs-toggle="modal" data-bs-target="#modalEditAkun">
                                        <i class="bi bi-pencil-square text-primary"></i>
                                        <span>Edit Akun</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item d-flex align-items-center gap-2" href="/login"
                                        onclick="event.preventDefault(); document.getElementById('switch-account-form').submit();">
                                        <i class="bi bi-arrow-repeat text-warning"></i>
                                        <span>Ganti Akun</span>
                                    </a>
                                    <form id="switch-account-form" action="{{ url('logout') }}" method="POST"
                                        style="display: none;">
                                        @csrf
                                    </form>
                                </li>
                                <li>
                                    <form action="{{ url('logout') }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="dropdown-item d-flex align-items-center gap-2">
                                            <i class="bi bi-box-arrow-right text-danger"></i>
                                            <span>Logout</span>
                                        </button>

                                    </form>
                                </li>
                            </ul>
                        </div>
                    @else
                        <a href="{{ route('login') }}"
                            class="btn btn-primary px-4 py-2 rounded-pill shadow-sm d-flex align-items-center gap-2"
                            style="font-size: 1.1rem; min-height: 48px;">
                            <i class="bi bi-lock"></i>
                            <span>Login</span>
                        </a>
                    @endauth
                </div>
            </ul>


        </div>
    </div>
</nav>

<!-- Modal Notifikasi Konsultasi -->
@auth
    <div class="modal fade" id="notifKonsultasiModal" tabindex="-1" aria-labelledby="notifKonsultasiModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title text-dark" id="notifKonsultasiModalLabel">
                        Notifikasi Konsultasi Anda
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    @if ($konsultasi && $konsultasi->count() > 0)
                        <ul class="list-group">
                            @foreach ($konsultasi as $konsul)
                                <li class="list-group-item">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <div>
                                            <strong>{{ $konsul->judul_konsultasi }}</strong>
                                            <div class="small text-muted">{{ $konsul->created_at->format('d M Y H:i') }}
                                            </div>
                                        </div>
                                        @if ($konsul->status == 'Dijawab')
                                            <span class="badge bg-success">Sudah Ditanggapi</span>
                                        @else
                                            <span class="badge bg-secondary">Belum Ditanggapi</span>
                                        @endif
                                    </div>
                                    <div class="small text-muted mb-1">
                                        {{ \Illuminate\Support\Str::limit($konsul->deskripsi, 60) }}
                                    </div>
                                    @if ($konsul->status == 'Dijawab' && optional($konsul->jawabPelatihan)->jawaban)
                                        <div class="alert alert-success py-2 px-3 mb-0 mt-2">
                                            <strong>Jawaban:</strong><br>
                                            <div class="small text-muted">{{ $konsul->jawabPelatihan->created_at->format('d M Y H:i') }}
                                            </div>
                                            {{ \Illuminate\Support\Str::limit($konsul->jawabPelatihan->jawaban, 100) }}
                                        </div>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="text-center text-muted">Belum ada konsultasi.</div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endauth

<!-- Modal Edit Akun -->
<div class="modal fade" id="modalEditAkun" tabindex="-1" aria-labelledby="modalEditAkunLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header bg-primary rounded-top-4">
                <h5 class="modal-title text-white" id="modalEditAkunLabel">
                    <i class="bi bi-pencil-square me-2"></i> Edit Akun
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Tutup"></button>
            </div>
            <div class="modal-body px-4 py-3">
                <form action="{{ route('profile.update') }}" method="POST" autocomplete="off">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                        <input type="text" name="name" class="form-control rounded-pill"
                            value="{{ Auth::user()->name }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control rounded-pill"
                            value="{{ Auth::user()->email }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Telepon</label>
                        <input type="text" name="telepon" class="form-control rounded-pill"
                            value="{{ Auth::user()->telepon }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <input type="text" name="alamat" class="form-control rounded-pill"
                            value="{{ Auth::user()->alamat }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">NIK</label>
                        <input type="text" name="nik" class="form-control rounded-pill"
                            value="{{ Auth::user()->nik }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password Baru <span class="text-muted">(Kosongkan jika tidak ingin
                                mengubah)</span></label>
                        <input type="password" name="password" class="form-control rounded-pill"
                            autocomplete="new-password">
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary rounded-pill px-4 py-2 fw-bold">
                            <i class="bi bi-save me-1"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
