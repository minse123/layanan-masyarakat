<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard User</title>
    <!-- Include CSS -->
    @include('guest/layouts.css')

    <!-- Custom CSS -->
    {{-- <link rel="stylesheet" href="{{ asset('sb-admin-2/css/custom.css') }}"> --}}

</head>

<body id="page-top">
    <div class="half-circle"></div>
    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        {{-- Sidebar dinonaktifkan --}}
        {{-- @include('user.layout.sidebar') --}}
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                @include('guest/layouts.navbar')
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <!-- Page Content -->
                <div class="container-fluid text-center mt-5 background-container">
                    <h1 class="display-4 font-weight-bold text-primary">Selamat Datang di</h1>
                    <h2 class="font-weight-semibold">Aplikasi Pelayanan Masyarakat Digital</h2>
                    <p class="text-muted">Balai Pelatihan dan Pemberdayaan Masyarakat Desa, Daerah Tertinggal, dan
                        Transmigrasi Banjarmasin</p>
                    <a href="{{ url('buku-tamu') }}" class="btn btn-primary btn-lg mt-4">Masuk ke Menu Buku Tamu</a>
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->


        </div>
        <!-- End of Content Wrapper -->


    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    @include('guest/layouts.js')

</body>
<!-- Footer -->
@include('guest/layouts.footer')
<!-- End of Footer -->

</html>
