@extends('kasubag.app')
@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>Laporan Konsultasi Sedang Di Proses</span>
            <div class="d-flex">
                <!-- Tombol Cetak PDF -->
                <a href="{{ route('report.konsultasi.pending.cetak-pdf') }}" class="btn btn-primary btn-icon-split">
                    <span class="icon text-white-50">
                        <i class="fas fa-file-pdf"></i>
                    </span>
                    <span class="text">Cetak PDF</span>
                </a>
            </div>
        </div>
        <div class="card-body">
            <!-- Filter Data -->
            <div class="mb-4">
                <form action="{{ route('kasubag.pending.konsultasi.filter') }}" method="GET" class="form-inline">
                    <div class="form-group mb-2">
                        <label for="filter" class="mr-2">Pilih Periode</label>
                        <select name="filter" id="filter" class="form-control" onchange="updateFilterInput()">
                            <option value="harian" {{ request('filter') == 'harian' ? 'selected' : '' }}>Harian</option>
                            <option value="mingguan" {{ request('filter') == 'mingguan' ? 'selected' : '' }}>Mingguan
                            </option>
                            <option value="bulanan" {{ request('filter') == 'bulanan' ? 'selected' : '' }}>Bulanan</option>
                            <option value="tahunan" {{ request('filter') == 'tahunan' ? 'selected' : '' }}>Tahunan</option>
                        </select>
                    </div>

                    <div class="form-group mx-sm-3 mb-2" id="filter-harian">
                        <input type="date" name="tanggal" class="form-control" value="{{ request('tanggal') }}">
                    </div>

                    <div class="form-group mx-sm-3 mb-2" id="filter-mingguan" style="display: none;">
                        <input type="week" name="minggu" class="form-control" value="{{ request('minggu') }}">
                    </div>

                    <div class="form-group mx-sm-3 mb-2" id="filter-bulanan" style="display: none;">
                        <input type="month" name="bulan" class="form-control" value="{{ request('bulan') }}">
                    </div>

                    <div class="form-group mx-sm-3 mb-2" id="filter-tahunan" style="display: none;">
                        <input type="number" name="tahun" class="form-control" min="2000" max="2099"
                            step="1" value="{{ request('tahun') ?? now()->year }}">
                    </div>

                    <button type="submit" class="btn btn-primary mb-2">
                        <i class="fas fa-filter"></i> Filter
                    </button>
                    <a href="{{ route('kasubag.pending.konsultasi.resetfilter') }}" class="btn btn-outline-secondary mb-2">
                        <i class="fas fa-sync"></i> Reset
                    </a>
                </form>
            </div>
            <script>
                function updateFilterInput() {
                    const selectedFilter = document.getElementById("filter").value;
                    document.getElementById("filter-harian").style.display = (selectedFilter === "harian") ? "block" : "none";
                    document.getElementById("filter-mingguan").style.display = (selectedFilter === "mingguan") ? "block" : "none";
                    document.getElementById("filter-bulanan").style.display = (selectedFilter === "bulanan") ? "block" : "none";
                    document.getElementById("filter-tahunan").style.display = (selectedFilter === "tahunan") ? "block" : "none";
                }

                // Jalankan fungsi saat halaman pertama kali dimuat
                document.addEventListener("DOMContentLoaded", updateFilterInput);
            </script>

            <!-- Tabel Data -->
            <div class="table-responsive">
                <table class="table" id="myTable">
                    <thead class="thead-dark">
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
        </div>
    </div>
@endsection

@section('script')
    <script>
        let table = new DataTable('#myTable');
    </script>
@endsection
