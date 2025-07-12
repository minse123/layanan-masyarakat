<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Statistik Soal Tersulit</title>
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
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .table th,
        .table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        .table th {
            background-color: #f2f2f2;
            font-weight: bold;
            text-align: center;
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

        <h2 class="text-center">Laporan Statistik Soal Tersulit</h2>
        <p class="text-center">Dicetak pada: {{ date('d F Y H:i') }}</p>

        <table class="table">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Kategori</th>
                    <th>Pertanyaan</th>
                    <th>Total Percobaan</th>
                    <th>Jawaban Salah</th>
                    <th>Persentase Kesalahan (%)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($soalStats as $index => $soal)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $soal->nama_kategori }}</td>
                        <td>{{ $soal->pertanyaan }}</td>
                        <td class="text-center">{{ $soal->total_attempts }}</td>
                        <td class="text-center">{{ $soal->incorrect_attempts }}</td>
                        <td class="text-center">{{ number_format(($soal->incorrect_attempts / $soal->total_attempts) * 100, 2) }}%</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="footer">
            Laporan ini dibuat secara otomatis oleh sistem.
        </div>
    </div>
</body>
</html>