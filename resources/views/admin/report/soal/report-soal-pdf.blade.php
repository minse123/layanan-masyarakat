<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Soal Pelatihan</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
        }
        .container {
            width: 100%;
            margin: 0 auto;
        }
        .kop-surat {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        .kop-surat td {
            vertical-align: middle;
        }

        .kop-surat img {
            width: 100px;
            height: auto;
        }

        .kop-text {
            text-align: center;
            width: 100%;
        }

        .kop-text h4 {
            font-weight: normal;
            margin: 4px 0;
            font-size: 12px;
        }

        .kop-text h5 {
            margin: 5px 0;
            font-size: 16px;
        }

        .kop-text p {
            margin: 5px 0;
            font-size: 10px;
        }

        hr {
            border: 2px solid black;
            margin: 20px 0;
        }
        .content {
            margin-top: 20px;
        }
        .category-title {
            font-size: 18px;
            font-weight: bold;
            margin-top: 30px;
            margin-bottom: 15px;
            padding-bottom: 5px;
            border-bottom: 1px solid #ccc;
            color: #333;
        }
        .question-block {
            margin-bottom: 20px;
            padding-left: 15px;
            border-left: 3px solid #eee;
        }
        .question {
            font-weight: bold;
            margin-bottom: 8px;
            font-size: 14px;
        }
        .options {
            list-style-type: none;
            padding-left: 10px;
            margin: 0;
        }
        .options li {
            margin-bottom: 5px;
            color: #555;
        }
        .correct-answer {
            margin-top: 8px;
            font-weight: bold;
            color: #28a745;
        }
        .footer {
            text-align: center;
            margin-top: 40px;
            padding-top: 10px;
            border-top: 1px solid #ccc;
            font-size: 10px;
            color: #999;
        }
        .empty-message {
            text-align: center;
            font-style: italic;
            color: #888;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Kop Surat -->
        <table class="kop-surat">
            <tr>
                <td width="10%">
                    <img src="{{ public_path('frontend/images/logo-kementerian-1.png') }}" alt="Logo Kementerian">
                </td>
                <td class="kop-text">
                    <h4>KEMENTERIAN DESA, PEMBANGUNAN DAERAH TERTINGGAL DAN TRANSMIGRASI RI</h4>
                    <h4>BADAN PENGEMBANGAN SUMBER DAYA MANUSIA DAN PEMBERDAYAAN MASYARAKAT</h4>
                    <h4>DESA, DAERAH TERTINGGAL DAN TRANSMIGRASI</h4>
                    <h5>BALAI PELATIHAN DAN PEMBERDAYAAN MASYARAKAT</h5>
                    <h5>DESA, DAERAH TERTINGGAL, DAN TRANSMIGRASI BANJARMASIN</h5>
                    <p>Jalan Handil Bhakti KM.9,5 No. 95 Banjarmasin Kalimantan Selatan, 70582 Telepon: 08115000344</p>
                    <p><a href="https://www.kemendesa.go.id" target="_blank">www.kemendesa.go.id</a>
                    </p>
                </td>
            </tr>
        </table>
        <hr>
        <h2 class="text-center">Laporan Daftar Soal Pelatihan</h2>
        <p class="text-center">Dicetak pada: {{ date('d F Y H:i') }}</p>

        <div class="content">
            @forelse($kategoriWithSoal as $kategori)
                <h2 class="category-title">{{ $kategori->nama_kategori }} ({{ ucfirst($kategori->tipe) }})</h2>

                @forelse($kategori->soalPelatihan as $index => $soal)
                    <div class="question-block">
                        <div class="question">{{ $index + 1 }}. {{ $soal->pertanyaan }}</div>
                        <ul class="options">
                            <li>A. {{ $soal->pilihan_a }}</li>
                            <li>B. {{ $soal->pilihan_b }}</li>
                            <li>C. {{ $soal->pilihan_c }}</li>
                            <li>D. {{ $soal->pilihan_d }}</li>
                        </ul>
                        <div class="correct-answer">Jawaban Benar: {{ strtoupper($soal->jawaban_benar) }}</div>
                    </div>
                @empty
                    <p class="empty-message">Tidak ada soal dalam kategori ini.</p>
                @endforelse
            @empty
                <p class="empty-message">Tidak ada kategori soal yang tersedia.</p>
            @endforelse
        </div>

        <div class="footer">
            Laporan ini dibuat secara otomatis oleh sistem.
        </div>
    </div>
</body>
</html>