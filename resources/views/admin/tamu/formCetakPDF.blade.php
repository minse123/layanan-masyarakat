<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Buku Tamu Harian</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 10px;
            line-height: 1;
        }

        @page {
            size: A4 landscape;
            margin: 2cm;
        }

        /* Kop Surat */
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

        /* Garis pembatas */
        hr {
            border: 2px solid black;
            margin: 20px 0;
        }

        /* Judul */
        h2 {
            text-align: center;
            margin: 20px 0;
            font-size: 24px;
        }

        .text-center {
            text-align: center;
        }

        /* Tabel */
        .table {
            width: 100%;
            table-layout: auto;
            border-collapse: collapse;
            margin-top: 20px;
            /* page-break-inside: auto; */
        }

        .table th,
        .table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
            white-space: nowrap;
        }

        .table th {
            background-color: #f2f2f2;
            font-weight: bold;
            text-align: center;
        }

        /* Tanda Tangan */
        .signature-section {
            margin-top: 60px;
            text-align: right;
            page-break-inside: avoid;
        }

        .signature {
            display: inline-block;
            text-align: center;
            margin-left: 50px;
        }

        .signature-line {
            border-top: 1px solid #000;
            width: 200px;
            margin: 80px auto 0;
        }
    </style>
</head>

<body>
    <!-- Kop Surat Menggunakan Tabel -->
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

    <!-- Judul Laporan -->
    <h2>Laporan Buku Tamu</h2>
    <p class="text-center">Tanggal: {{ $tanggal }}</p>

    <!-- Tabel Data -->
    <table class="table" style="auto">
        <thead>
            <tr>
                <th>No.</th>
                <th>Nama</th>
                <th>Telepon</th>
                <th>Alamat</th>
                <th>Email</th>
                <th>Keperluan</th>
                <th>Waktu</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $key => $item)
                <tr>
                    <td class="text-center">{{ $key + 1 }}</td>
                    <td>{{ $item->nama }}</td>
                    <td class="text-center">{{ $item->telepon }}</td>
                    <td>{{ $item->alamat }}</td>
                    <td>{{ $item->email }}</td>
                    <td>{{ $item->keperluan }}</td>
                    <td>{{ $item->date }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Tanda Tangan -->
    <div class="signature-section">
        <div class="signature">
            <p>Kepala Balai PPMDDTT Banjarmasin,</p>
            <div class="signature-line"></div>
            <p>Ahmad Syahir, S.H.I., M.H.</p>
            <p>NIP. 19780602 201101 1 012</p>
        </div>
    </div>
</body>

</html>
