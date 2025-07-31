<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Video Pelatihan</title>
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
        .badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: 600;
            text-transform: uppercase;
            color: #fff;
        }
        .badge-primary {
            background-color: #007bff;
        }
        .badge-secondary {
            background-color: #6c757d;
        }
        .badge-success {
            background-color: #28a745;
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

        <h2 class="text-center">Laporan Data Video Pelatihan</h2>
        <p class="text-center">Dicetak pada: {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y H:i:s') }}</p>

        <table class="table">
            <thead>
                <tr>
                    <th style="width: 5%; text-align:center;">No.</th>
                    <th>Judul</th>
                    <th style="width: 15%;">Jenis Pelatihan</th>
                    <th>Deskripsi</th>
                    <th style="width: 20%;">Link YouTube</th>
                    <th style="width: 12%; text-align:center;">Ditampilkan</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($videos as $key => $video)
                    <tr>
                        <td style="text-align:center;">{{ $key + 1 }}</td>
                        <td>{{ $video->judul }}</td>
                        <td>
                            @if ($video->jenis_pelatihan == 'inti')
                                <span class="badge badge-primary">Inti</span>
                            @else
                                <span class="badge badge-secondary">Pendukung</span>
                            @endif
                        </td>
                        <td>{{ $video->deskripsi ?: '-' }}</td>
                        <td>
                            <a href="https://www.youtube.com/watch?v={{ $video->youtube_id }}" target="_blank">
                                {{ $video->youtube_id }}
                            </a>
                        </td>
                        <td style="text-align:center;">
                            @if ($video->ditampilkan)
                                <span class="badge badge-success">Ya</span>
                            @else
                                <span class="badge badge-secondary">Tidak</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align:center; padding: 20px;">
                            Tidak ada data video yang tersedia untuk ditampilkan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="footer">
            Laporan ini dihasilkan oleh sistem dan merupakan dokumen resmi.
        </div>
    </div>
</body>
</html>