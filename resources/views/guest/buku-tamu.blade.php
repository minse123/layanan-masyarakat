<!doctype html>
<html lang="en">

<head>
    <title>Aplikasi Buku Tamu</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="{{ asset('/frontend/css/style.css') }}">

</head>

<body>
    <section class="ftco-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 text-center mb-5">
                    <h2 class="heading-section">Aplikasi Buku Tamu</h2>
                </div>

            </div>
            <div class="row justify-content-center">
                <div class="col-md-7 col-lg-5">
                    <div class="wrap">
                        <div class="img"
                            style="background-image: url({{ url('/frontend/images/logo-kementerian.png') }});
							background-size: 150px 150px;">
                        </div>
                        <div style="text-align: center;">
                            <h6 class="mb-1">Balai Pelatihan Dan Pemberdaya Masyarakat Desa, Daerah Tertinggal,
                                dan Transmigrasi</h6>
                            <h6 class="mb-1">Banjarmasin</h6>

                        </div>
                        <div class="login-wrap p-4 p-md-5">
                            <div class="d-flex">
                                <div class="w-100" style="text-align: center;">
                                    <h3 class="mb-4">Form Buku Tamu</h3>
                                </div>

                                {{-- <div class="w-100">
                                    <p class="social-media d-flex justify-content-end">
                                        <a href="#"
                                            class="social-icon d-flex align-items-center justify-content-center"><span
                                                class="fa fa-facebook"></span></a>
                                        <a href="#"
                                            class="social-icon d-flex align-items-center justify-content-center"><span
                                                class="fa fa-twitter"></span></a>
                                    </p>
                                </div> --}}
                            </div>
                            @if (session('status'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('status') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                            <form action="{{ route('simpan-tamu') }}" method="post" class="signin-form">
                                @csrf
                                <div class="form-group mt-3">
                                    <input type="text" name="nama" class="form-control" required>
                                    <label class="form-control-placeholder" for="Masukan Nama Anda">Nama</label>
                                </div>
                                <div class="form-group mt-3">
                                    <input type="text" name="telepon" class="form-control" required>
                                    <label class="form-control-placeholder"
                                        for="Masukan Nomor Telpon Anda">Telepon</label>
                                </div>
                                <div class="form-group mt-3">
                                    <input type="text" name="alamat" class="form-control" required>
                                    <label class="form-control-placeholder" for="Masukan Alamat Anda">Alamat</label>
                                </div>
                                <div class="form-group mt-3">
                                    <input type="text" name="instansi" class="form-control" required>
                                    <label class="form-control-placeholder"
                                        for="Masukan Nama Instansi Anda">Instansi</label>
                                </div>
                                <div class="form-group mt-3">
                                    <input type="email" name="email" class="form-control" required>
                                    <label class="form-control-placeholder" for="Masukan Email Anda">Email</label>
                                </div>
                                <div class="form-group mt-3">
                                    <textarea name="keperluan" class="form-control" required placeholder></textarea>
                                    <label class="form-control-placeholder" for="keperluan">Keperluan</label>
                                </div>

                                <div class="form-group">
                                    <button type="submit"
                                        class="form-control btn btn-primary rounded submit px-3">Simpan</button>
                                </div>

                                <div class="mt-5">
                                    <a href="{{ url('/') }}">Dashboard</a>
                                </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>

    <script src="{{ asset('/frontend/js/jquery.min.js') }}"></script>
    <script src="{{ asset('/frontend/js/popper.js') }}"></script>
    <script src="{{ asset('/frontend/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('/frontend/js/main.js') }}"></script>
    <script src="{{ asset('/backend/js/sb-admin-2.js') }}"></script>
    <script src="{{ asset('/backend/js/sb-admin-2.min.js') }}"></script>

</body>

</html>
