<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('frontend/images/logo-kementerian.png') }}">
    <title>Layanan Masyarakat</title>

    <!-- Include CSS -->
    @include('masyarakat.layouts.css')

</head>

<body>

    @include('masyarakat.layouts.navbar')
    @include('sweetalert::alert')
    
    <main>
        @yield('content')
    </main>
    
    @include('masyarakat.layouts.footer')
    @include('masyarakat.layouts.js')
    
    @yield('script')

</body>
</html>