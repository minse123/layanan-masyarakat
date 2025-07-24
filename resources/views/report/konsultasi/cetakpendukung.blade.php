<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Konsultasi Pelatihan Pendukung</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #333;
        }

        @page {
            size: A4 landscape;
            margin: 1.5cm;
        }

        .header {
            width: 100%;
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }

        .header td {
            vertical-align: middle;
        }

        .header img {
            width: 90px;
            height: auto;
        }

        .header-text {
            text-align: center;
        }

        .header-text h4 {
            font-weight: bold;
            margin: 2px 0;
            font-size: 14px;
        }

        .header-text h5 {
            margin: 5px 0;
            font-size: 18px;
            font-weight: bold;
        }

        .header-text p {
            margin: 2px 0;
            font-size: 11px;
        }

        .report-title {
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .report-period {
            text-align: center;
            font-size: 12px;
            margin-bottom: 15px;
        }

        .filter-info {
            margin-bottom: 15px;
            font-size: 12px;
            padding: 10px;
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 4px;
        }

        .table-container {
            overflow-x: auto;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;
        }

        .table th,
        .table td {
            border: 1px solid #dee2e6;
            padding: 8px;
            text-align: left;
            vertical-align: top;
            word-wrap: break-word;
        }

        .table th {
            background-color: #e9ecef;
            font-weight: bold;
            text-align: center;
        }

        .table .no-col {
            width: 3%;
            text-align: center;
        }

        .text-center {
            text-align: center;
        }

        .signature-section {
            margin-top: 50px;
            width: 100%;
        }

        .signature {
            text-align: center;
            width: 35%;
            float: right;
        }

        .signature p {
            margin-bottom: 60px;
        }

        .signature-name {
            font-weight: bold;
            text-decoration: underline;
        }

        @media print {
            body {
                margin: 0;
            }
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
            .filter-info {
                border: 1px solid #ccc;
            }
        }
    </style>
</head>

<body>
    <!-- Header -->
    <table class="header">
        <tr>
            <td style="width: 15%;">
                <img src="{{ public_path('frontend/images/logo-kementerian-1.png') }}" alt="Logo Kementerian">
            </td>
            <td class="header-text">
                <h4>KEMENTERIAN DESA, PEMBANGUNAN DAERAH TERTINGGAL DAN TRANSMIGRASI RI</h4>
                <h4>BADAN PENGEMBANGAN SUMBER DAYA MANUSIA DAN PEMBERDAYAAN MASYARAKAT</h4>
                <h4>DESA, DAERAH TERTINGGAL DAN TRANSMIGRASI</h4>
                <h5>BALAI PELATIHAN DAN PEMBERDAYAAN MASYARAKAT</h5>
                <h5>DESA, DAERAH TERTINGGAL, DAN TRANSMIGRASI BANJARMASIN</h5>
                <p>Jalan Handil Bhakti KM.9,5 No. 95 Banjarmasin Kalimantan Selatan, 70582 Telepon: 08115000344</p>
                <p>
                    <a href="https://www.kemendesa.go.id" target="_blank" style="color: #007bff; text-decoration: none;">www.kemendesa.go.id</a>
                </p>
            </td>
        </tr>
    </table>

    <!-- Judul Laporan -->
    <h2 class="report-title">LAPORAN KONSULTASI PELATIHAN PENDUKUNG</h2>
    <p class="report-period">
        Periode: {{ session('filter') }}
        {{ session('tanggal') }}{{ session('bulan') ? ' ' . session('bulan') : '' }}{{ session('tahun') ? ' ' . session('tahun') : '' }}
    </p>

    <!-- Info Filter -->
    @if (request('judul_konsultasi') || request('jenis_pelatihan'))
        <div class="filter-info">
            @if (request('judul_konsultasi'))
                <strong>Judul Konsultasi:</strong> {{ request('judul_konsultasi') }}<br>
            @endif
            @if (request('jenis_pelatihan'))
                <strong>Jenis Pelatihan:</strong>
                @php
                    $jenis = [
                        'diklat_pmd' => 'Diklat PMD',
                        'pelatihan_masyarakat' => 'Pelatihan Masyarakat',
                        'pelatihan_aparatur' => 'Pelatihan Aparatur',
                        'studi_banding' => 'Studi Banding',
                    ];
                @endphp
                {{ $jenis[request('jenis_pelatihan')] ?? request('jenis_pelatihan') }}
            @endif
        </div>
    @endif

    <!-- Tabel Data -->
    <div class="table-container">
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
                    <th>Tgl Pengajuan</th>
                    <th>Jawaban</th>
                    <th>Tgl Dijawab</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data as $key => $item)
                    @foreach ($item->kategoriPelatihan as $kategori)
                        <tr>
                            <td class="no-col">{{ $key + 1 }}</td>
                            <td>{{ $item->nama ?? '-' }}</td>
                            <td>{{ $item->telepon ?? '-' }}</td>
                            <td>{{ $item->email ?? '-' }}</td>
                            <td>{{ $item->judul_konsultasi ?? '-' }}</td>
                            <td style="white-space: pre-wrap;">{{ $item->deskripsi ?? '-' }}</td>
                            @if (request('jenis_pelatihan'))
                                <td>{{ $kategori->jenisPelatihan->nama ?? '-' }}</td>
                            @endif
                            <td>{{ $kategori->jenisPelatihan->tanggal_pengajuan ? \Carbon\Carbon::parse($kategori->jenisPelatihan->tanggal_pengajuan)->format('d M Y') : '-' }}</td>
                            <td style="white-space: pre-wrap;">{{ $item->jawabPelatihan->jawaban ?? '-' }}</td>
                            <td>{{ $item->jawabPelatihan->tanggal_dijawab ? \Carbon\Carbon::parse($item->jawabPelatihan->tanggal_dijawab)->format('d M Y') : '-' }}</td>
                        </tr>
                    @endforeach
                @empty
                    <tr>
                        <td colspan="{{ request('jenis_pelatihan') ? '10' : '9' }}" class="text-center">Tidak ada data yang tersedia.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Tanda Tangan -->
    <div class="signature-section">
        <div class="signature">
            <p>Kepala Balai PPMDDTT Banjarmasin,</p>
            <p class="signature-name">Ahmad Syahir, S.H.I., M.H.</p>
            <p>NIP. 19780602 201101 1 012</p>
        </div>
    </div>
</body>

</html>