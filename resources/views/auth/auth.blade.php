<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Aplikasi Buku Tamu - Formulir Login">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="icon" type="image/png" href="{{ asset('frontend/images/logo-kementerian.png') }}">

    <link rel="stylesheet" href="{{ asset('/frontend/css/style.css') }}">
    <title>Aplikasi Buku Tamu</title>
</head>

<body class="bg-light">
    <img src="/frontend/images/bppmddtt.jpg" alt="Background"
        style="position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; object-fit: cover; z-index: 0; opacity: 0.15;">

    <div class="container">
        <!-- Outer Row -->
        <div class="row justify-content-center align-items-center vh-100">
            <div class="col-lg-8 col-md-11">
                <div class="card shadow-sm ">
                    <div class="card-body">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">Layanan Masyarakat Digital</h1>
                        </div>
                        <!-- Form Content -->
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="text-center mt-4">
        <p>&copy; 2025 Aplikasi Buku Tamu. MINSE Project</p>
    </footer>

    <script src="{{ asset('/frontend/js/jquery.min.js') }}"></script>
    <script src="{{ asset('/frontend/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('/backend/js/sb-admin-2.min.js') }}"></script>
</body>

</html>
