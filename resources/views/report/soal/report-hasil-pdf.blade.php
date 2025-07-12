<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Hasil Pelatihan</title>
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
        .text-center {
            text-align: center;
        }
        .section-title {
            font-size: 18px;
            font-weight: bold;
            margin-top: 20px;
            margin-bottom: 10px;
            padding-bottom: 5px;
            border-bottom: 1px solid #ccc;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .info-table td {
            padding: 5px 0;
        }
        .question-block {
            margin-bottom: 15px;
            padding-left: 15px;
            border-left: 3px solid #eee;
        }
        .question {
            font-weight: bold;
            margin-bottom: 5px;
            font-size: 14px;
        }
        .options {
            list-style-type: none;
            padding-left: 10px;
            margin: 0;
        }
        .options li {
            margin-bottom: 3px;
            color: #555;
        }
        .correct-answer {
            font-weight: bold;
            color: #28a745;
        }
        .participant-answer {
            font-weight: bold;
            color: #007bff; /* Blue for participant's answer */
        }
        .score-section {
            margin-top: 30px;
            text-align: right;
            font-size: 16px;
            font-weight: bold;
        }
        .footer {
            text-align: center;
            margin-top: 40px;
            padding-top: 10px;
            border-top: 1px solid #ccc;
            font-size: 10px;
            color: #999;
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

        <h2 class="text-center">Laporan Hasil Pelatihan</h2>
        <p class="text-center">Dicetak pada: {{ date('d F Y H:i') }}</p>

        <table class="info-table">
            <tr>
                <td><strong>Nama Peserta:</strong></td>
                <td>{{ $user->name }}</td>
            </tr>
            <tr>
                <td><strong>Kategori Pelatihan:</strong></td>
                <td>{{ $kategori->nama_kategori }} ({{ ucfirst($kategori->tipe) }})</td>
            </tr>
            <tr>
                <td><strong>Total Soal:</strong></td>
                <td>{{ $soalPelatihan->count() }}</td>
            </tr>
        </table>

        <h3 class="section-title">Detail Jawaban</h3>

        @forelse($soalPelatihan as $index => $soal)
            <div class="question-block">
                <div class="question">{{ $index + 1 }}. {{ $soal->pertanyaan }}</div>
                <ul class="options">
                    <li>A. {{ $soal->pilihan_a }}</li>
                    <li>B. {{ $soal->pilihan_b }}</li>
                    <li>C. {{ $soal->pilihan_c }}</li>
                    <li>D. {{ $soal->pilihan_d }}</li>
                </ul>
                <div class="participant-answer">Jawaban Peserta: {{ isset($jawabanPeserta[$soal->id]) ? strtoupper($jawabanPeserta[$soal->id]->jawaban_peserta) : 'Tidak Dijawab' }}</div>
                <div class="correct-answer">Jawaban Benar: {{ strtoupper($soal->jawaban_benar) }}</div>
            </div>
        @empty
            <p class="empty-message">Tidak ada soal untuk kategori ini.</p>
        @endforelse

        <div class="score-section">
            Nilai Akhir: {{ number_format($score, 2) }}
        </div>

        <div class="footer">
            Laporan ini dibuat secara otomatis oleh sistem.
        </div>
    </div>
</body>
</html>