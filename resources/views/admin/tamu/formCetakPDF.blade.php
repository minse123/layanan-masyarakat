<!DOCTYPE html>
<html>

<head>
    <title>Laporan Buku Tamu Harian</title>
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
        }

        .text-center {
            text-align: center;
        }
    </style>
</head>

<body>
    <!-- Kop Surat -->
    <div class="kop-surat">
        <img src="{{ url('/frontend/images/logo-kementerian-1.png') }}" alt="" width="30">
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
    <h2 class="text-center">Laporan Buku Tamu Harian</h2>
    <p class="text-center">Tanggal: {{ $tanggal }}</p>

    <!-- Tabel Data -->
    <table class="table">
        <thead>
            <tr>
                <th class="text-center">No.</th>
                <th class="text-center">Nama</th>
                <th class="text-center">Telepon</th>
                <th class="text-center">Alamat</th>
                <th class="text-center">Email</th>
                <th class="text-center">Keperluan</th>
                <th class="text-center">Waktu</th>
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
</body>

</html>
