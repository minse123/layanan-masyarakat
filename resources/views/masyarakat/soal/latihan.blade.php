<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('frontend/images/logo-kementerian.png') }}">
    <title>Layanan Masyarakat</title>

    <!-- Include CSS -->
    @include('masyarakat/layouts.css')
    <style>
        /* Style khusus untuk navbar di halaman ini saja */
        body .navbar {
            background-color: #000 !important;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        body .navbar .nav-link,
        body .navbar .navbar-brand {
            color: #fff !important;
        }
    </style>

</head>

<body>

    @include('masyarakat/layouts.navbar')

    <main>
        @yield('content')
        <div class="container py-4">
            <div class="card shadow mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Latihan Soal: {{ $kategori->nama_kategori ?? '-' }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('masyarakat.soal.jawab.submit', $kategori->id) }}" method="POST">
                        @csrf
                        @foreach ($soalList as $i => $soal)
                            <div class="mb-4">
                                <div class="fw-bold mb-2">
                                    {{ $i + 1 }}. {{ $soal->pertanyaan }}
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="jawaban[{{ $soal->id }}]"
                                        id="soal{{ $soal->id }}a" value="a" required>
                                    <label class="form-check-label" for="soal{{ $soal->id }}a">
                                        A. {{ $soal->pilihan_a }}
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="jawaban[{{ $soal->id }}]"
                                        id="soal{{ $soal->id }}b" value="b">
                                    <label class="form-check-label" for="soal{{ $soal->id }}b">
                                        B. {{ $soal->pilihan_b }}
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="jawaban[{{ $soal->id }}]"
                                        id="soal{{ $soal->id }}c" value="c">
                                    <label class="form-check-label" for="soal{{ $soal->id }}c">
                                        C. {{ $soal->pilihan_c }}
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="jawaban[{{ $soal->id }}]"
                                        id="soal{{ $soal->id }}d" value="d">
                                    <label class="form-check-label" for="soal{{ $soal->id }}d">
                                        D. {{ $soal->pilihan_d }}
                                    </label>
                                </div>
                            </div>
                            <hr>
                        @endforeach

                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-success btn-lg fw-bold">Kirim Jawaban</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
</body>