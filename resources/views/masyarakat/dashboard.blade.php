@extends('masyarakat.app')
@section('content')
    <section class="hero-section d-flex justify-content-center align-items-center" id="section_1">
        <div class="container">
            <div class="row">

                <div class="col-lg-6 col-12 mb-5 pb-5 pb-lg-0 mb-lg-0">

                    <h6>
                        Selamat Datang, <span class="fw-bold text-white">{{ Auth::user()->name }}</span> di
                    </h6>

                    <h1 class="text-white mb-4">Sistem Informasi Pelayanan Masyarakat Digital</h1>

                    <a href="#item-2" class="btn custom-btn smoothscroll me-3">Layanan Konsultasi BumDes</a> <a href="#item-3"
                        class="link link--kale smoothscroll">Pengajuan Surat</a> <a href="#item-4"
                        class="link link--kale smoothscroll">Latihan Soal Pelatihan</a>
                </div>

                <div class="hero-image-wrap col-lg-6 col-12 mt-3 mt-lg-0">
                    <img src="/frontend/images/tablet-bppmddtt.png" class="hero-image img-fluid"
                        alt="education online books">
                </div>

            </div>
        </div>
    </section>


    <section class="featured-section">
        <div class="container">
        </div>
    </section>


    <section class="py-lg-5"></section>
    <section class="py-lg-5"></section>



    <section id="section_2" class="pt-5">
        <div class="container">
            <div class="row text-center">
                <div class="col-lg-12 col-12">
                    <h6 style="font-size: 1.5rem;">Apa Saja Layanannya?</h6>
                    <h2 class="mb-5" style="font-size: 2.5rem;">Layanan yang Kami Tawarkan</h2>
                </div>
            </div>
            <div class="row text-center">
                <div class="col-lg-4 col-12 mb-4" id="item-2">
                    <div class="card border p-3 h-100 d-flex flex-column justify-content-between">
                        <img src="/frontend/images/interview.png" class="card-img-top mx-auto" style="max-width:200px;"
                            alt="Layanan Konsultasi BumDes">
                        <div class="card-body d-flex flex-column">
                            <button class="btn btn-success w-100 mt-auto" data-bs-toggle="modal"
                                data-bs-target="#modalKonsultasi">
                                Layanan Konsultasi Pelatihan
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-12 mb-4" id="item-3">
                    <div class="card border p-3 h-100 d-flex flex-column justify-content-between">
                        <img src="/frontend/images/mail.png" class="card-img-top mx-auto" style="max-width:200px;"
                            alt="Pengajuan Surat">
                        <div class="card-body d-flex flex-column">
                            <button class="btn btn-warning w-100 mt-auto" data-bs-toggle="modal"
                                data-bs-target="#modalSurat">
                                Pengajuan Surat
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-12 mb-4" id="item-4">
                    <div class="card border p-3 h-100 d-flex flex-column justify-content-between">
                        <img src="/frontend/images/quiz.png" class="card-img-top mx-auto" style="max-width:200px;"
                            alt="Latihan Soal Pelatihan">
                        <div class="card-body d-flex flex-column">
                            <button class="btn btn-info w-100 mt-auto" data-bs-toggle="modal"
                                data-bs-target="#modalKategoriSoal">
                                Latihan Soal Pelatihan
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-lg-5"></section>

    <section id="jadwal-pelatihan" class="pt-5">
        <div class="container">
            <div class="row text-center">
                <div class="col-lg-12 col-12">
                    <h6 style="font-size: 1.5rem;">Jadwal Pelatihan</h6>
                    <h2 class="mb-5" style="font-size: 2.5rem;">Ikuti Pelatihan Kami</h2>
                </div>
            </div>
            <div class="row">
                @forelse ($jadwalPelatihan as $jadwal)
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="card h-100 shadow-sm border-0 rounded-lg" data-bs-toggle="modal"
                            data-bs-target="#detailModal-{{ $jadwal->id }}" style="cursor: pointer;">
                            <img src="{{ $jadwal->file_path ? asset('storage/' . $jadwal->file_path) : asset('frontend/images/logo-kementerian.png') }}"
                                class="card-img-top" alt="{{ $jadwal->nama_pelatihan }}"
                                style="height: 200px; object-fit: cover;">
                            <div class="card-body">
                                <h5 class="card-title">{{ $jadwal->nama_pelatihan }}</h5>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <p class="text-center">Belum ada jadwal pelatihan yang tersedia.</p>
                    </div>
                @endforelse
            </div>
            <div class="row">
                <div class="col-12 text-center mt-3">
                    <a href="{{ route('jadwal-pelatihan') }}" class="btn btn-primary">Lihat Seluruh Jadwal</a>
                </div>
            </div>
        </div>
    </section>

    @foreach ($jadwalPelatihan as $item)
        <!-- Detail Modal -->
        <div class="modal fade" id="detailModal-{{ $item->id }}" tabindex="-1" role="dialog"
            aria-labelledby="detailModalLabel-{{ $item->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="detailModalLabel-{{ $item->id }}">Detail Jadwal Pelatihan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-2">
                                    <label><strong>Nama Pelatihan:</strong></label>
                                    <p class="mb-1">{{ $item->nama_pelatihan }}</p>
                                </div>
                                <div class="form-group mb-2">
                                    <label><strong>Tanggal:</strong></label>
                                    <p class="mb-1">
                                        {{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d M Y') }} -
                                        {{ \Carbon\Carbon::parse($item->tanggal_selesai)->format('d M Y') }}
                                    </p>
                                </div>
                                <div class="form-group mb-2">
                                    <label><strong>Jam:</strong></label>
                                    <p class="mb-1">{{ $item->jam_mulai }} - {{ $item->jam_selesai }}</p>
                                </div>
                                <div class="form-group mb-2">
                                    <label><strong>Gambar:</strong></label>
                                    @if ($item->file_path)
                                        <div class="mb-1">
                                            <img src="{{ route('admin.jadwal-pelatihan.file', ['filename' => $item->file_path]) }}"
                                                alt="Gambar Pelatihan" class="img-fluid"
                                                style="max-width: 100%; height: auto;">
                                        </div>
                                    @else
                                        <p class="mb-1">Tidak ada gambar</p>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-2">
                                    <label><strong>Lokasi:</strong></label>
                                    <p class="mb-1">{{ $item->lokasi }}</p>
                                </div>
                                <div class="form-group mb-2">
                                    <label><strong>Jenis Pelatihan:</strong></label>
                                    <p class="mb-1">
                                        @if ($item->pelatihan_inti)
                                            {{ str_replace('_', ' ', ucwords($item->pelatihan_inti)) }} (Inti)
                                        @elseif ($item->pelatihan_pendukung)
                                            {{ str_replace('_', ' ', ucwords($item->pelatihan_pendukung)) }} (Pendukung)
                                        @else
                                            -
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row mt-3">
                            <div class="col-12">
                                <label><strong>Deskripsi:</strong></label>
                                <p>{{ $item->deskripsi }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <!-- Modal Konsultasi BumDes -->
    <div class="modal fade" id="modalKonsultasi" tabindex="-1" aria-labelledby="modalKonsultasiLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header bg-success rounded-top-4">
                    <h5 class="modal-title text-white" id="modalKonsultasiLabel">
                        <i class="bi bi-chat-dots me-2"></i> Layanan Konsultasi Pelatihan
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Tutup"></button>
                </div>
                <div class="modal-body px-4 py-3">
                    <form action="{{ route('simpan-konsultasi') }}" method="POST" autocomplete="off">
                        @csrf
                        <div class="row g-3">
                            <div class="col-12 col-md-6">
                                <label class="form-label">Nama</label>
                                <input type="text" name="nama" class="form-control rounded-pill" required
                                    placeholder="Nama Lengkap">
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label">Telepon</label>
                                <input type="text" name="telepon" class="form-control rounded-pill" required
                                    placeholder="Nomor Telepon">
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control rounded-pill" required
                                    placeholder="Alamat Email">
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label">Tanggal Pengajuan</label>
                                <input type="date" name="tanggal_pengajuan" class="form-control rounded-pill"
                                    required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Judul Konsultasi</label>
                                <input type="text" name="judul_konsultasi" class="form-control rounded-pill" required
                                    placeholder="Judul Konsultasi">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Deskripsi</label>
                                <textarea name="deskripsi" class="form-control rounded-3" rows="3" required
                                    placeholder="Tuliskan deskripsi konsultasi Anda..."></textarea>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label">Jenis Kategori</label>
                                <select name="jenis_kategori" id="jenis_kategori" class="form-select rounded-pill"
                                    required onchange="togglePelatihan()">
                                    <option value="">-- Pilih Kategori --</option>
                                    <option value="inti">Inti</option>
                                    <option value="pendukung">Pendukung</option>
                                </select>
                            </div>
                            <div class="col-12 col-md-6 d-none" id="pelatihan_inti_wrap">
                                <label class="form-label">Pelatihan Inti</label>
                                <select name="pelatihan_inti" class="form-select rounded-pill">
                                    <option value="">-- Pilih Pelatihan Inti --</option>
                                    <option value="bumdes">Bumdes</option>
                                    <option value="kpmd">KPMD</option>
                                    <option value="masyarakat_hukum_adat">Masyarakat Hukum Adat</option>
                                    <option value="pembangunan_desa_wisata">Pembangunan Desa Wisata</option>
                                    <option value="catrans">Catrans</option>
                                    <option value="pelatihan_perencanaan_pembangunan_partisipatif">Pelatihan
                                        Perencanaan Pembangunan Partisipatif</option>
                                </select>
                            </div>
                            <div class="col-12 col-md-6 d-none" id="pelatihan_pendukung_wrap">
                                <label class="form-label">Pelatihan Pendukung</label>
                                <select name="pelatihan_pendukung" class="form-select rounded-pill">
                                    <option value="">-- Pilih Pelatihan Pendukung --</option>
                                    <option value="prukades">Prukades</option>
                                    <option value="prudes">Prudes</option>
                                    <option value="ecomerce">E-Commerce</option>
                                </select>
                            </div>
                        </div>
                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-success rounded-pill px-4 py-2 fw-bold">
                                <i class="bi bi-send me-1"></i> Ajukan Konsultasi
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Pengajuan Surat -->
    <div class="modal fade" id="modalSurat" tabindex="-1" aria-labelledby="modalSuratLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header bg-warning rounded-top-4">
                    <h5 class="modal-title" id="modalSuratLabel">Pengajuan Surat</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-4 py-3">
                    <form action="{{ route('simpan-surat') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row g-3">
                            <div class="col-12 col-md-6">
                                <label class="form-label">Nomor Surat</label>
                                <input type="text" name="nomor_surat" class="form-control rounded-pill" required>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label">Tanggal Surat</label>
                                <input type="date" name="tanggal_surat" class="form-control rounded-pill" required>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label">Pengirim</label>
                                <input type="text" name="pengirim" class="form-control rounded-pill" required>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label">Telepon</label>
                                <input type="text" name="telepon" class="form-control rounded-pill" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Perihal</label>
                                <input type="text" name="perihal" class="form-control rounded-pill" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Lampiran</label>
                                <input type="file" name="file" id="file" class="form-control rounded-pill"
                                    required>
                            </div>
                        </div>
                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-warning rounded-pill px-4 py-2 fw-bold">Ajukan</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Kategori Soal Pelatihan -->
    <div class="modal fade" id="modalKategoriSoal" tabindex="-1" aria-labelledby="modalKategoriSoalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header bg-info rounded-top-4">
                    <h5 class="modal-title text-white" id="modalKategoriSoalLabel">
                        <i class="bi bi-list-task me-2"></i> Pilih Kategori Latihan Soal
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Tutup"></button>
                </div>
                <div class="modal-body px-4 py-3">
                    <div class="list-group">
                        @forelse ($kategoriList as $kategori)
                            <a href="{{ route('masyarakat.soal.latihan', $kategori->id) }}"
                                class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                <span>{{ $kategori->nama_kategori }}</span>
                                <span class="badge bg-secondary ms-2">{{ ucfirst($kategori->tipe) }}</span>
                            </a>
                        @empty
                            <div class="text-center text-muted">Belum ada kategori soal.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="py-lg-5"></section>
    <section class="py-lg-5"></section>


    <section id="section_3">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-12 text-center mb-5">
                    <h6>Profil</h6>
                    <h2>Tentang Kami</h2>
                </div>

                <div class="col-lg-12 col-12">
                    <div class="custom-block p-4 shadow">
                        <h3 class="mb-3">Sejarah Umum</h3>
                        <p>
                            Kehadiran Lembaga Pelatihan Transmigrasi Banjarmasin diawali dengan adanya kebutuhan
                            mendesak akibat kesenjangan sumber daya manusia antara aparatur transmigrasi dan warga
                            transmigrasi serta penduduk sekitar yang memerlukan peningkatan pengetahuan, sikap
                            perilaku, dan keterampilan.
                        </p>
                        <p>
                            Balai Latihan Transmigrasi Banjarmasin awalnya bernama **Balai Latihan Transmigrasi
                            Provinsi Kalimantan Selatan** dan beroperasi di bawah **Kantor Wilayah Departemen
                            Transmigrasi dan Pemukiman Perambah Hutan Provinsi Kalimantan Selatan**, menangani
                            pelatihan ketransmigrasian di wilayah provinsi tersebut.
                        </p>

                        <h3 class="mt-4">Perkembangan dan Transformasi</h3>
                        <p>
                            Berdasarkan **Keputusan Menteri Tenaga Kerja dan Transmigrasi Nomor 137/MEN/2001** serta
                            **Peraturan Menteri Tenaga Kerja dan Transmigrasi RI No. PER.07/MEN/2011**, status Balai
                            Latihan Transmigrasi Banjarmasin berubah menjadi **Unit Pelaksana Teknis Pusat (UPTP)**,
                            di bawah Direktorat Jenderal Pembinaan Pelatihan dan Produktivitas Kementerian Tenaga
                            Kerja dan Transmigrasi RI. Wilayah kerja mencakup seluruh Pulau Kalimantan: **Kalimantan
                            Selatan, Kalimantan Barat, Kalimantan Timur, Kalimantan Tengah, dan Kalimantan Utara**.
                        </p>
                        <p>
                            Seiring dengan diberlakukannya **Undang-Undang Nomor 22 Tahun 1999 tentang Otonomi
                            Daerah**, UPTP Balai Latihan Transmigrasi Banjarmasin menjembatani kepentingan antara
                            Unit Pelaksanaan Teknis Daerah (UPTD) dalam bidang pelatihan ketransmigrasian.
                        </p>

                        <h3 class="mt-4">Perubahan di Era Modern</h3>
                        <p>
                            Pada era pemerintahan **Presiden Joko Widodo dan Wakil Presiden Muhammad Jusuf Kalla**,
                            Balai Latihan Transmigrasi Banjarmasin bergabung dengan **Kementerian Desa, Pembangunan
                            Daerah Tertinggal, dan Transmigrasi**. Berdasarkan **Peraturan Menteri Desa, PDT, dan
                            Transmigrasi Nomor 9 Tahun 2015**, balai ini berubah nama menjadi **Balai Latihan
                            Masyarakat Banjarmasin**, tetap melayani wilayah kerja se-Pulau Kalimantan.
                        </p>
                        <p>
                            Pada tahun **2020**, Menteri Desa **Abdul Halim Iskandar** menerbitkan **Peraturan
                            Menteri Desa Nomor 22 Tahun 2020** yang mengubah nama balai menjadi **Balai Pelatihan
                            dan Pemberdayaan Masyarakat Desa, Daerah Tertinggal, dan Transmigrasi Banjarmasin**.
                            Wilayah kerja mencakup **Kalimantan Selatan, Kalimantan Timur, Kalimantan Tengah, dan
                            Kalimantan Utara**.
                        </p>
                        <p>
                            Fokus utama balai saat ini adalah **fasilitasi dan pelatihan pengembangan sumber daya
                            manusia desa, daerah tertinggal, dan transmigrasi**, serta **pendampingan pemberdayaan
                            masyarakat desa, daerah tertinggal, dan transmigrasi**.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="book-section section-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-12 ">
                    <iframe width="100%" height="315" src="https://www.youtube.com/embed/kxEvmyriwfA"
                        title="YouTube video player" frameborder="0"
                        allow="accelerometer; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen>
                    </iframe>
                </div>

                <div class="col-lg-6 col-12">
                    <div class="book-section-info">

                        <h2 class="mb-4">Visi</h2>
                        <p>“Terwujudnya Indonesia yang Berdaulat, Mandiri dan Berkepribadian Berlandaskan Gotong
                            Royong”</p>

                        <h2 class="mb-4">Misi</h2>
                        <h7>Untuk mewujudkan Visi, Kementerian Desa, Pembangunan Daerah Tertinggal, dan Transmigrasi
                            mempunyai misi yang mencakup tujuh (7) kegiatan, yaitu:</h7>

                        <ol>
                            <li>
                                <h7>Mewujudkan keamanan nasional yang mampu menjaga kedaulatan wilayah, menopang
                                    kemandirian ekonomi dengan mengamankan sumber daya maritim, dan mencerminkan
                                    kepribadian Indonesia sebagai Negara kepulauan.</h7>
                            </li>
                            <li>
                                <h7>Mewujudkan masyarakat maju, berkeseimbangan, dan demokratis berlandaskan Negara
                                    hukum.</h7>
                            </li>
                            <li>
                                <h7>Mewujudkan politik luar negeri bebas-aktif dan memperkuat jati diri sebagai
                                    Negara maritim.</h7>
                            </li>
                            <li>
                                <h7>Mewujudkan kualitas hidup manusia Indonesia yang tinggi, maju, dan sejahtera.
                                </h7>
                            </li>
                            <li>
                                <h7>Mewujudkan bangsa yang berdaya saing.</h7>
                            </li>
                            <li>
                                <h7>Mewujudkan Indonesia sebagai Negara maritim yang mandiri, maju, kuat, dan
                                    berbasiskan kepentingan nasional.</h7>
                            </li>
                            <li>
                                <h7>Mewujudkan masyarakat yang berkepribadian dalam kebudayaan.</h7>
                            </li>
                        </ol>

                    </div>
                </div>

            </div>
        </div>
    </section>

    <section class="contact-section section-padding" id="section_4">
        <div class="container">
            <div class="row">
                <div class="col-lg-5 col-12 mx-auto">
                    <div class="custom-form ebook-download-form bg-white shadow p-3">
                        <div class="text-center mb-4">
                            <h2 class="mb-1">Lokasi Kami</h2>
                        </div>

                        <div class="ebook-download-form-body">
                            <div class="map-responsive">
                                <iframe width="100%" height="315"
                                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3039.44206267124!2d114.61574359999999!3d-3.2420815!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2de43ca0d48f0a17%3A0x242ee71eb3cc1384!2sBalai%20Latihan%20Masyarakat%20Banjarmasin!5e1!3m2!1sid!2sid!4v1739097434242!5m2!1sid!2sid"
                                    style="border:0;" allowfullscreen="" loading="lazy">
                                </iframe>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-lg-6 col-12">

                    <h2 class="mb-4">Kontak Kami</h2>

                    <p class="mb-3">
                        <i class="bi-geo-alt me-2"></i>
                        Handil Bakti, Kec. Alalak, Kabupaten Barito Kuala, Kalimantan Selatan
                    </p>

                    <p class="mb-2">
                        <a href="tel:0811-5000344" class="contact-link">
                            0811-5000344
                        </a>
                    </p>

                    <p>
                        <a href="mailto:info@company.com" class="contact-link">
                            info@company.com
                        </a>
                    </p>

                    <h6 class="site-footer-title mt-5 mb-3">Social Media</h6>

                    <ul class="social-icon mb-4">
                        <li class="social-icon-item">
                            <a href="https://www.instagram.com/balatmas.bjm/" class="social-icon-link bi-instagram"></a>
                        </li>
                        <li class="social-icon-item">
                            <a href="https://twitter.com/BanjarmasinBlm" class="social-icon-link bi-twitter"></a>
                        </li>
                        <li class="social-icon-item">
                            <a href="https://www.facebook.com/blm.banjarmasin.9" class="social-icon-link bi-facebook"></a>
                        </li>
                        <li class="social-icon-item">
                            <a href="https://wa.me/08115000344" class="social-icon-link bi-whatsapp"></a>
                        </li>
                        <li class="social-icon-item">
                            <a href="https://www.tiktok.com/@bppmddttbanjarmasin" class="social-icon-link bi-tiktok"></a>
                        </li>
                        <li class="social-icon-item">
                            <a href="http://www.youtube.com/@bppmddttbanjarmasin6034"
                                class="social-icon-link bi-youtube"></a>
                        </li>
                    </ul>
                </div>

            </div>
        </div>
    </section>

    <!-- Tonton Video Pelatihan -->
    <section id="section_video" class="pt-5">
        <div class="container">
            <div class="row text-center mb-4">
                <div class="col-12">
                    <h6>Pelatihan Online</h6>
                    <h2 class="mb-4">Tonton Video Pelatihan</h2>
                </div>
            </div>
            <div class="row justify-content-center">
                @forelse ($videos as $video)
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="card h-100 shadow-sm border-0 rounded-lg" data-bs-toggle="modal"
                            data-bs-target="#videoModal-{{ $video->id }}" style="cursor: pointer;">
                            <div class="video-thumbnail-container">
                                <img src="https://img.youtube.com/vi/{{ $video->youtube_id }}/hqdefault.jpg"
                                    class="card-img-top rounded-top" alt="{{ $video->judul }}"
                                    style="height: 200px; object-fit: cover;">
                                <div class="play-button-overlay">
                                    <i class="bi bi-play-circle-fill"></i>
                                </div>
                            </div>
                            <div class="card-body">
                                <h6 class="card-title mb-2">{{ $video->judul }}</h6>
                                <p class="card-text small">{{ $video->deskripsi }}</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <p>Belum ada video pelatihan yang tersedia.</p>
                    </div>
                @endforelse
            </div>
            <div class="row">
                <div class="col-12 text-center mt-3">
                    <a href="{{ route('masyarakat.videopelatihan') }}"
                        class="btn btn-success rounded-pill px-4 py-2 fw-bold">
                        Lihat Selengkapnya
                    </a>
                </div>
            </div>
        </div>
    </section>

    @foreach ($videos as $video)
        <!-- Video Modal -->
        <div class="modal fade" id="videoModal-{{ $video->id }}" tabindex="-1"
            aria-labelledby="videoModalLabel-{{ $video->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="videoModalLabel-{{ $video->id }}">{{ $video->judul }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="embed-responsive embed-responsive-16by9">
                            <iframe class="embed-responsive-item"
                                src="https://www.youtube.com/embed/{{ $video->youtube_id }}" allowfullscreen
                                style="width: 100%; height: 400px;"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection

@push('styles')
    <style>
        .video-thumbnail-container {
            position: relative;
            width: 100%;
            padding-top: 56.25%;
            /* 16:9 Aspect Ratio */
            overflow: hidden;
        }

        .video-thumbnail-container img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .play-button-overlay {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 3rem;
            color: white;
            opacity: 0.8;
            transition: opacity 0.3s ease;
        }

        .card:hover .play-button-overlay {
            opacity: 1;
        }
    </style>
@endpush
