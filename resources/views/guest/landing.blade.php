<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('frontend/images/logo-kementerian.png') }}">
    <title>Layanan Masyarakat</title>

    <!-- Include CSS -->
    @include('guest/layouts.css')

</head>

<body>

    @include('guest/layouts.navbar')

    <main>

        <section class="hero-section d-flex justify-content-center align-items-center" id="section_1">
            <div class="container">
                <div class="row">

                    <div class="col-lg-6 col-12 mb-5 pb-5 pb-lg-0 mb-lg-0">

                        <h6>Selamat Datang di</h6>

                        <h1 class="text-white mb-4">Sistem Informasi Layanan Masyarakat</h1>

                        <a href="#item-1" class="link link--kale smoothscroll me-3">Buku Tamu </a>

                        <a href="#item-2" class="btn custom-btn smoothscroll me-3">Layanan Konsultasi BumDes</a>

                        <a href="#item-3" class="link link--kale smoothscroll">Pengajuan Surat</a>
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
                        <h6>Apa Saja Layanannya?</h6>
                        <h2 class="mb-5">Layanan yang Kami Tawarkan</h2>
                    </div>
                </div>

                <div class="row text-center">
                    <div class="col-lg-4 col-12 mb-4" id="item-1">
                        <div class="card border p-3">
                            <img src="/frontend/images/guests-book.png" class="card-img-top" alt="Buku Tamu">
                            <div class="card-body">
                                <button class="btn btn-primary w-100" data-bs-toggle="modal"
                                    data-bs-target="#modalBukuTamu">
                                    Buku Tamu
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-12 mb-4" id="item-2">
                        <div class="card border p-3">
                            <img src="/frontend/images/interview.png" class="card-img-top"
                                alt="Layanan Konsultasi BumDes">
                            <div class="card-body">
                                <button class="btn btn-success w-100" data-bs-toggle="modal"
                                    data-bs-target="#modalKonsultasi">
                                    Layanan Konsultasi BumDes
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-12 mb-4" id="item-3">
                        <div class="card border p-3">
                            <img src="/frontend/images/mail.png" class="card-img-top" alt="Pengajuan Surat">
                            <div class="card-body">
                                <button class="btn btn-warning w-100" data-bs-toggle="modal"
                                    data-bs-target="#modalSurat">
                                    Pengajuan Surat
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <!-- Modal Buku Tamu -->
        <div class="modal fade" id="modalBukuTamu" tabindex="-1" aria-labelledby="modalBukuTamuLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalBukuTamuLabel">Buku Tamu</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('simpan-tamu') }}" method="post" class="signin-form">
                            @csrf
                            <div class="form-group mt-3">
                                <label class="form-control-placeholder">Nama</label>
                                <input type="text" name="nama" class="form-control" required>
                            </div>
                            <div class="form-group mt-3">
                                <label class="form-control-placeholder">Telepon</label>
                                <input type="text" name="telepon" class="form-control" required>
                            </div>
                            <div class="form-group mt-3">
                                <label class="form-control-placeholder">Alamat</label>
                                <input type="text" name="alamat" class="form-control" required>
                            </div>
                            <div class="form-group mt-3">
                                <label class="form-control-placeholder">Instansi</label>
                                <input type="text" name="instansi" class="form-control" required>
                            </div>
                            <div class="form-group mt-3">
                                <label class="form-control-placeholder">Email</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                            <div class="form-group mt-3">
                                <label class="form-control-placeholder">Keperluan</label>
                                <textarea name="keperluan" class="form-control" required placeholder=""></textarea>
                            </div>
                            <div class="form-group">
                                <button type="submit"
                                    class="form-control btn btn-primary rounded submit px-3">Simpan</button>
                            </div>
                            @include('sweetalert::alert')
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Konsultasi BumDes -->
        <div class="modal fade" id="modalKonsultasi" tabindex="-1" aria-labelledby="modalKonsultasiLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalKonsultasiLabel">Layanan Konsultasi BumDes</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('simpan-konsultasi') }}" method="POST">
                            @csrf
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>Nama</label>
                                    <input type="text" name="nama" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Telepon</label>
                                    <input type="text" name="telepon" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" name="email" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Judul Konsultasi</label>
                                    <input type="text" name="judul_konsultasi" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Deskripsi</label>
                                    <textarea name="deskripsi" class="form-control" required></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit"
                                    class="form-control btn btn-success rounded submit px-3">Ajukan</button>
                            </div>
                            @include('sweetalert::alert')
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Pengajuan Surat -->
        <div class="modal fade" id="modalSurat" tabindex="-1" aria-labelledby="modalSuratLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalSuratLabel">Pengajuan Surat</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('simpan-surat') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group mt-3">
                                <label class="form-control-placeholder">Nomor Surat</label>
                                <input type="text" name="nomor_surat" class="form-control" required>
                            </div>
                            <div class="form-group mt-3">
                                <label class="form-control-placeholder">Tanggal Surat</label>
                                <input type="date" name="tanggal_surat" class="form-control" required>
                            </div>
                            <div class="form-group mt-3">
                                <label class="form-control-placeholder">Pengirim</label>
                                <input type="text" name="pengirim" class="form-control" required>
                            </div>
                            <div class="form-group mt-3">
                                <label class="form-control-placeholder">Telepon</label>
                                <input type="text" name="telepon" class="form-control" required>
                            </div>
                            <div class="form-group mt-3">
                                <label class="form-control-placeholder">Perihal</label>
                                <input type="text" name="perihal" class="form-control" required>
                            </div>
                            <div class="form-group mt-3">
                                <label class="form-control-placeholder">Lampiran</label>
                                <input type="file" name="file" id='file' class="form-control" required>
                            </div>
                            <div class="form-group">
                                <button type="submit"
                                    class="form-control btn btn-warning rounded submit px-3">Ajukan</button>
                            </div>
                            @include('sweetalert::alert')
                        </form>
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




        <section class="book-section section-padding" id="section_3">
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

        <section class="contact-section section-padding">
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
                                <a href="https://www.instagram.com/balatmas.bjm/"
                                    class="social-icon-link bi-instagram"></a>
                            </li>
                            <li class="social-icon-item">
                                <a href="https://twitter.com/BanjarmasinBlm" class="social-icon-link bi-twitter"></a>
                            </li>
                            <li class="social-icon-item">
                                <a href="https://www.facebook.com/blm.banjarmasin.9"
                                    class="social-icon-link bi-facebook"></a>
                            </li>
                            <li class="social-icon-item">
                                <a href="https://wa.me/08115000344" class="social-icon-link bi-whatsapp"></a>
                            </li>
                            <li class="social-icon-item">
                                <a href="https://www.tiktok.com/@bppmddttbanjarmasin"
                                    class="social-icon-link bi-tiktok"></a>
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
    </main>
    @include('guest/layouts.js')
</body>
@include('guest/layouts.footer')

</html>
