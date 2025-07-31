<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Surat Ditolak</title>
    <style>
        body {
            font-family: Arial, sans-serif;
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
        }

        .table th {
            background-color: #f2f2f2;
            font-weight: bold;
            text-align: center;
        }

        .text-center {
            text-align: center;
        }

        /* Tanda Tangan */
        .signature-section {
            margin-top: 60px;
            /* Increased space above the signature section */
            page-break-inside: avoid;
            /* Prevents the signature section from being split */
            text-align: right;
        }

        /* .table-signature {
            page-break-after: auto;
            
        } */

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
    <h2 class="text-center">Laporan Surat Ditolak</h2>
    <p class="text-center">Periode: {{ $filter ?? '-' }} - {{ $tanggal ?? '-' }}</p>

    <!-- Tabel Data -->
    <table class="table">
        <thead>
            <tr>
                <th>No.</th>
                <th>Nomor Surat</th>
                <th>Tanggal Surat</th>
                <th>Pengirim</th>
                <th>Telepon</th>
                <th>Perihal</th>
                <th>Tanggal Di Tolak</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $key => $item)
                <tr>
                    <td class="text-center">{{ $key + 1 }}</td>
                    <td>{{ $item->masterSurat->nomor_surat ?? '-' }}</td>
                    <td class="text-center">{{ $item->masterSurat->tanggal_surat ?? '-' }}</td>
                    <td>{{ $item->masterSurat->pengirim ?? '-' }}</td>
                    <td>{{ $item->masterSurat->telepon ?? '-' }}</td>
                    <td>{{ $item->masterSurat->perihal ?? '-' }}</td>
                    <td>{{ $item->tanggal_tolak ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
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
