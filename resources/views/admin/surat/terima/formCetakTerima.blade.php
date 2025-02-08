<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Surat Diterima</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .kop-surat {
            text-align: center;
            margin-bottom: 20px;
        }

        .kop-surat h4 {
            margin: 0;
            font-weight: bold;
        }

        .kop-surat p {
            margin: 0;
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
    </style>
</head>

<body>
    <!-- Kop Surat -->
    <div class="kop-surat">
        <img src="{{ public_path('frontend/images/logo-kementerian-1.png') }}" alt="Logo Kementerian" width="50">
        <h4>KEMENTERIAN DESA, PEMBANGUNAN DAERAH TERTINGGAL DAN TRANSMIGRASI RI</h4>
        <h4>BADAN PENGEMBANGAN SUMBER DAYA MANUSIA DAN PEMBERDAYAAN MASYARAKAT</h4>
        <h4>DESA, DAERAH TERTINGGAL DAN TRANSMIGRASI</h4>
        <h4>BALAI PELATIHAN DAN PEMBERDAYAAN MASYARAKAT</h4>
        <h4>DESA, DAERAH TERTINGGAL, DAN TRANSMIGRASI BANJARMASIN</h4>
        <p>Jalan Handil Bhakti KM.9,5 No. 95 Banjarmasin Kalimantan Selatan, 70582</p>
        <p>Telepon: 08115000344 | <a href="https://www.kemendesa.go.id" target="_blank">www.kemendesa.go.id</a></p>
        <hr>
    </div>

    <!-- Judul Laporan -->
    <h2 class="text-center">Laporan Surat Diterima</h2>
    <p class="text-center">Periode: {{ session('filter') }} - {{ session('tanggal') }}</p>

    <!-- Tabel Data -->
    <table class="table">
        <thead>
            <tr>
                <th>No.</th>
                <th>Nomor Surat</th>
                <th>Tanggal Surat</th>
                <th>Pengirim</th>
                <th>Perihal</th>
                <th>Tanggal Di Terima</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $key => $item)
                <tr>
                    <td class="text-center">{{ $key + 1 }}</td>
                    <td>{{ $item->masterSurat->nomor_surat ?? '-' }}</td>
                    <td class="text-center">{{ $item->masterSurat->tanggal_surat ?? '-' }}</td>
                    <td>{{ $item->masterSurat->pengirim ?? '-' }}</td>
                    <td>{{ $item->masterSurat->perihal ?? '-' }}</td>
                    <td>{{ $item->masterSurat->suratTerima->first()->tanggal_terima ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
