<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Konsultasi Sedang Pending</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        /* Pengaturan margin halaman PDF */
        @page {
            size: A4 landscape;
            margin: 2cm;
        }

        .kop-surat {
            width: 100%;
            text-align: center;
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
            word-wrap: break-word;
            /* Mencegah teks panjang keluar tabel */
            max-width: 150px;
            /* Batasi lebar kolom */
        }

        .table th {
            background-color: #f2f2f2;
            font-weight: bold;
            text-align: center;
        }

        .text-center {
            text-align: center;
        }

        /* Mencegah tabel terpotong saat cetak PDF */
        tr {
            page-break-inside: avoid;
        }

        /* Jika tabel terlalu panjang, pindahkan ke halaman baru */
        table {
            page-break-after: auto;
        }

        /* Tanda Tangan */
        .signature-section {
            margin-top: 60px;
            /* Increased space above the signature section */
            page-break-inside: avoid;
            /* Prevents the signature section from being split */
            text-align: right;
        }

        .table {
            page-break-after: auto;
            /* Allows the table to break after if it's too long */
        }

        .signature {
            display: inline-block;
            text-align: center;
            margin-left: 50px;
            /* Adjust spacing between signatures if needed */
        }

        .signature-line {
            border-top: 1px solid #000;
            width: 200px;
            /* Adjust width of the signature line */
            margin: 0 auto;
            /* Center the line */
            margin-top: 80px;
            /* Space above the line */
        }
    </style>
</head>

<body>
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

    <!-- Judul Laporan -->
    <h2 class="text-center">Laporan Konsultasi Sedang Pending</h2>
    <p class="text-center">Periode: {{ session('filter') }} - {{ session('tanggal') }}</p>

    <!-- Tabel Data -->
    <div>
        <table class="table">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama</th>
                    <th>Telepon</th>
                    <th>Email</th>
                    <th>Judul Konsultasi</th>
                    <th>Deskripsi</th>
                    <th>Tanggal Masuk</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $key => $item)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $item->masterKonsultasi->nama ?? '-' }}</td>
                        <td>{{ $item->masterKonsultasi->telepon ?? '-' }}</td>
                        <td>{{ $item->masterKonsultasi->email ?? '-' }}</td>
                        <td>{{ $item->masterKonsultasi->judul_konsultasi ?? '-' }}</td>
                        <td>{{ $item->masterKonsultasi->deskripsi ?? '-' }}</td>
                        <td>{{ $item->tanggal_pengajuan ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

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
