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
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .table th, .table td {
            border: 1px solid #dee2e6;
            padding: 8px;
            text-align: left;
            font-size: 12px;
        }
        .table th {
            background-color: #007bff;
            color: white;
        }
        .badge {
            padding: 0.35em 0.65em;
            border-radius: 0.25rem;
            font-size: 75%;
            font-weight: 700;
            line-height: 1;
            text-align: center;
            white-space: nowrap;
            vertical-align: baseline;
            display: inline-block;
        }
        .badge-primary {
            color: #fff;
            background-color: #007bff;
        }
        .badge-secondary {
            color: #fff;
            background-color: #6c757d;
        }
        .badge-success {
            color: #fff;
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
        <p class="text-center">Dicetak pada: {{ \Carbon\Carbon::now()->format('d F Y H:i:s') }}</p>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th style="width: 5%;">No.</th>
                    <th>Judul</th>
                    <th>Jenis Pelatihan</th>
                    <th>Deskripsi</th>
                    <th>Link YouTube</th>
                    <th>Ditampilkan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($videos as $key => $video)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $video->judul }}</td>
                        <td>
                            @if ($video->jenis_pelatihan == 'inti')
                                <span class="badge badge-primary">Inti</span>
                            @else
                                <span class="badge badge-secondary">Pendukung</span>
                            @endif
                        </td>
                        <td>{{ $video->deskripsi }}</td>
                        <td>https://www.youtube.com/watch?v={{ $video->youtube_id }}</td>
                        <td>
                            @if ($video->ditampilkan)
                                <span class="badge badge-success">Ya</span>
                            @else
                                <span class="badge badge-secondary">Tidak</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="footer">
            Laporan ini dibuat secara otomatis oleh sistem.
        </div>
    </div>

    <script>
        window.onload = function() {
            window.print();
        };
    </script>
</body>
</html>
