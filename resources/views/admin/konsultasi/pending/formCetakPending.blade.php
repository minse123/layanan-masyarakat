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
            size: A4;
            margin: 2cm;
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
    <h2 class="text-center">Laporan Konsultasi Sedang Pending</h2>
    <p class="text-center">Periode: {{ session('filter') }} - {{ session('tanggal') }}</p>

    <!-- Tabel Data -->
    <div style="overflow-x: auto;">
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
</body>

</html>
