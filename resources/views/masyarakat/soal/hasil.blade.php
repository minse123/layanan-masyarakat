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
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
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
        <div class="container">
            <h2 class="mb-4">Hasil Jawaban Kamu</h2>

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Pertanyaan</th>
                        <th>Jawaban Kamu</th>
                        <th>Kunci Jawaban</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jawabanPeserta as $index => $jawaban)
                        @php
                            $soal = $jawaban->soal;
                            $pilihan = [
                                'a' => $soal->pilihan_a ?? '-',
                                'b' => $soal->pilihan_b ?? '-',
                                'c' => $soal->pilihan_c ?? '-',
                                'd' => $soal->pilihan_d ?? '-',
                            ];
                
                            $jawabanKamu = strtolower(trim($jawaban->jawaban_peserta));
                            $jawabanBenar = strtolower(trim($soal->jawaban_benar ?? ''));
                        @endphp
                
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $soal->pertanyaan ?? '-' }}</td>
                            <td>
                                <strong>({{ strtoupper($jawabanKamu) }})</strong>
                                {{ $pilihan[$jawabanKamu] ?? 'Tidak diketahui' }}
                            </td>
                            <td>
                                <strong>({{ strtoupper($jawabanBenar) }})</strong>
                                {{ $pilihan[$jawabanBenar] ?? '-' }}
                            </td>
                            <td>
                                @if ($jawaban->benar == 1)
                                    <span class="badge bg-success">Benar</span>
                                @else
                                    <span class="badge bg-danger">Salah</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Belum ada jawaban</td>
                        </tr>
                    @endforelse
                </tbody>                
            </table>

            <div class="mt-4">
                <h4>Total Skor: <strong>{{ $skor }}</strong> dari {{ $totalSoal }} soal</h4>
            </div>
        </div>
    </main>
</body>
