<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Konsultasi Pelatihan Inti</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

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
            table-layout: fixed;
            word-break: break-word;
            font-size: 11px;
        }

        .table th,
        .table td {
            border: 1px solid #000;
            padding: 6px 4px;
            text-align: left;
            vertical-align: top;
            max-width: 120px;
            overflow-wrap: break-word;
            word-break: break-word;
        }

        .table th.no-col,
        .table td.no-col {
            width: 18px !important;
            max-width: 18px !important;
            min-width: 16px !important;
            text-align: center !important;
            padding-left: 0 !important;
            padding-right: 0 !important;
            font-size: 10px !important;
            white-space: nowrap !important;
            overflow: hidden !important;
        }

        td:nth-child(6) {
            max-width: 120px;
            white-space: pre-line;
        }

        .table th {
            background-color: #f2f2f2;
            font-weight: bold;
            text-align: center;
        }

        .text-center {
            text-align: center;
        }

        tr {
            page-break-inside: avoid;
        }

        table {
            page-break-after: auto;
        }

        .signature-section {
            margin-top: 40px;
            display: flex;
            justify-content: flex-end;
            padding: 0 50px;
        }

        .signature {
            text-align: center;
            width: 30%;
        }

        .signature-line {
            border-top: 1px solid #000;
            margin-top: 50px;
        }

        @media print {
            .table {
                page-break-inside: auto;
            }

            tr {
                page-break-inside: avoid;
                page-break-after: auto;
            }

            thead {
                display: table-header-group;
            }

            tfoot {
                display: table-footer-group;
            }
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
                <p>
                    <a href="https://www.kemendesa.go.id" target="_blank">www.kemendesa.go.id</a>
                </p>
            </td>
        </tr>
    </table>
    <hr>
    <!-- Judul Laporan -->
    <h2 class="text-center">Laporan Konsultasi Pelatihan Inti</h2>

    <!-- Info Filter -->
    @if (request('judul_konsultasi') || request('jenis_pelatihan'))
        <div style="margin-bottom: 10px; font-size: 12px;">
            @if (request('judul_konsultasi'))
                <strong>Judul Konsultasi:</strong> {{ request('judul_konsultasi') }}<br>
            @endif
            @if (request('jenis_pelatihan'))
                <strong>Jenis Pelatihan:</strong>
                @php
                    $jenis = [
                        'bumdes' => 'Bumdes',
                        'kpmd' => 'KPMD',
                        'masyarakat_hukum_adat' => 'Masyarakat Hukum Adat',
                        'pembangunan_desa_wisata' => 'Pembangunan Desa Wisata',
                        'catrans' => 'Catrans',
                        'pelatihan_perencanaan_pembangunan_partisipatif' => 'Perencanaan Partisipatif',
                    ];
                @endphp
                {{ $jenis[request('jenis_pelatihan')] ?? request('jenis_pelatihan') }}
            @endif
        </div>
    @endif

    <p class="text-center">
        Periode: {{ session('filter') }} -
        {{ session('tanggal') }}{{ session('bulan') ? '-' . session('bulan') : '' }}{{ session('tahun') ? '-' . session('tahun') : '' }}
    </p>

    <!-- Tabel Data -->
    <div style="overflow-x: auto;">
        <table class="table">
            <thead>
                <tr>
                    <th class="no-col">No.</th>
                    <th>Nama</th>
                    <th>Telepon</th>
                    <th>Email</th>
                    <th>Judul Konsultasi</th>
                    <th>Deskripsi</th>
                    @if (request('jenis_pelatihan'))
                        <th>Jenis Pelatihan</th>
                    @endif
                    <th>Tanggal Pengajuan</th>
                    <th>Jawaban</th>
                    <th>Tanggal Dijawab</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $key => $item)
                    @foreach ($item->kategoriPelatihan as $kategori)
                        <tr>
                            <td class="no-col">{{ $key + 1 }}</td>
                            <td>{{ $item->nama ?? '-' }}</td>
                            <td>{{ $item->telepon ?? '-' }}</td>
                            <td>{{ $item->email ?? '-' }}</td>
                            <td>{{ $item->judul_konsultasi ?? '-' }}</td>
                            <td>{{ $item->deskripsi ?? '-' }}</td>
                            @if (request('jenis_pelatihan'))
                                <td>{{ $kategori->jenisPelatihan->nama ?? '-' }}</td>
                            @endif
                            <td>{{ $kategori->jenisPelatihan->tanggal_pengajuan ?? '-' }}</td>
                            <td>{{ $item->jawabPelatihan->jawaban ?? '-' }}</td>
                            <td>{{ $item->jawabPelatihan->tanggal_dijawab ?? '-' }}</td>
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Tanda Tangan -->
    <div class="signature-section" style="margin-top: 60px;">
        <div class="signature" style="margin-left: auto;">
            <p>Kepala Balai PPMDDTT Banjarmasin,</p>
            <div class="signature-line"></div>
            <p>Ahmad Syahir, S.H.I., M.H.</p>
            <p>NIP. 19780602 201101 1 012</p>
        </div>
    </div>
</body>

</html>
