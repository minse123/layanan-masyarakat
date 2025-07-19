@extends('masyarakat.app')

@section('content')
    <div style="background-color: black; height: 100px;"></div>
    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-12 mx-auto text-center">
                    <h1 class="text-black mb-3">Latihan Soal</h1>
                    <p class="lead text-muted">Kerjakan soal-soal berikut untuk menguji pemahaman Anda.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="pb-5">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <a href="{{ route('masyarakat.dashboard') }}#section_2" class="btn btn-secondary btn-sm">
                    <i class="bi bi-arrow-left me-2"></i>Kembali
                </a>
            </div>
            <div class="card shadow mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Latihan Soal: {{ $kategori->nama_kategori ?? '-' }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('masyarakat.soal.jawab.submit', $kategori->id) }}" method="POST">
                        @csrf
                        @foreach ($soalList as $i => $soal)
                            <div class="mb-4 p-3 border rounded">
                                <div class="fw-bold mb-3 fs-5">
                                    {{ $i + 1 }}. {{ $soal->pertanyaan }}
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="radio" name="jawaban[{{ $soal->id }}]"
                                                id="soal{{ $soal->id }}a" value="a" required>
                                            <label class="form-check-label" for="soal{{ $soal->id }}a">
                                                A. {{ $soal->pilihan_a }}
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="radio" name="jawaban[{{ $soal->id }}]"
                                                id="soal{{ $soal->id }}b" value="b">
                                            <label class="form-check-label" for="soal{{ $soal->id }}b">
                                                B. {{ $soal->pilihan_b }}
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="radio" name="jawaban[{{ $soal->id }}]"
                                                id="soal{{ $soal->id }}c" value="c">
                                            <label class="form-check-label" for="soal{{ $soal->id }}c">
                                                C. {{ $soal->pilihan_c }}
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="radio" name="jawaban[{{ $soal->id }}]"
                                                id="soal{{ $soal->id }}d" value="d">
                                            <label class="form-check-label" for="soal{{ $soal->id }}d">
                                                D. {{ $soal->pilihan_d }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if (!$loop->last)
                                <hr class="my-4">
                            @endif
                        @endforeach

                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-success btn-lg fw-bold">Kirim Jawaban</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('styles')
<style>
    .form-check-label {
        cursor: pointer;
    }
    .form-check-input:checked + .form-check-label {
        font-weight: bold;
        color: #0d6efd; /* Bootstrap primary color */
    }
</style>
@endpush