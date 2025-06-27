<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('frontend/images/logo-kementerian.png') }}">
    <title>Video Pelatihan</title>
    @include('masyarakat/layouts.css')
</head>

<body>
    <div class="container mt-3">
        <div class="d-flex justify-content-end">
            @guest
                <a href="{{ route('login') }}" class="btn btn-primary mr-2">Login</a>
            @endguest
            @auth
                <a href="{{ url('dashboard') }}" class="btn btn-success">Dashboard</a>
            @endauth
        </div>
    </div>
    {{-- @include('masyarakat/layouts.navbar') --}}
    <main>
        <section class="pt-5 pb-5" id="section_video">
            <div class="container">
                <div class="row text-center mb-4">
                    <div class="col-12">
                        <h6>Pelatihan Online</h6>
                        <h2 class="mb-4">Daftar Video Pelatihan</h2>
                    </div>
                </div>
                <form method="GET" class="mb-4 text-center">
                    <label for="jenis_pelatihan" class="mr-2">Filter Jenis Pelatihan:</label>
                    <select name="jenis_pelatihan" id="jenis_pelatihan" onchange="this.form.submit()"
                        class="form-control d-inline-block w-auto">
                        <option value="">Semua</option>
                        <option value="inti" {{ request('jenis_pelatihan') == 'inti' ? 'selected' : '' }}>Inti
                        </option>
                        <option value="pendukung" {{ request('jenis_pelatihan') == 'pendukung' ? 'selected' : '' }}>
                            Pendukung
                        </option>
                    </select>
                </form>
                <div class="row justify-content-center">
                    @forelse ($videos as $video)
                        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                            <div class="card border shadow-sm h-100">
                                <iframe class="card-img-top" height="180"
                                    src="https://www.youtube.com/embed/{{ $video->youtube_id }}"
                                    title="{{ $video->judul }}" allowfullscreen></iframe>
                                <div class="card-body">
                                    <span
                                        class="badge badge-{{ $video->jenis_pelatihan == 'inti' ? 'primary' : 'secondary' }}">
                                        {{ ucfirst($video->jenis_pelatihan) }}
                                    </span>
                                    <h6 class="card-title mt-2">{{ $video->judul }}</h6>
                                    <p class="card-text small">{{ $video->deskripsi }}</p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center">
                            <p>Tidak ada video pelatihan ditemukan.</p>
                        </div>
                    @endforelse
                </div>
                <div class="d-flex justify-content-center">
                    {{ $videos->withQueryString()->links() }}
                </div>
            </div>
        </section>
    </main>
    @include('masyarakat/layouts.js')
</body>
@include('masyarakat/layouts.footer')

</html>
