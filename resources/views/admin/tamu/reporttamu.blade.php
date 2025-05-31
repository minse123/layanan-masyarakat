@extends('admin.app')
@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>Report Buku Tamu</span>
            <div class="d-flex">
                <!-- Tombol Cetak PDF -->
                <a href="{{ route('admin.report.tamu.cetak-pdf', ['filter' => session('filter'), 'tanggal' => session('tanggal')]) }}"
                    class="btn btn-primary btn-icon-split">
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
                <form action="{{ route('admin.report.tamu.filter-data') }}" method="GET" class="form-inline">
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
                    <a href="{{ route('admin.report.tamu.resetfilter-data') }}" class="btn btn-outline-secondary mb-2">
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
                            <th scope="col">No.</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Telepon</th>
                            <th scope="col">Alamat</th>
                            <th scope="col">Email</th>
                            <th scope="col">Keperluan</th>
                            <th scope="col">Waktu</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif
                        @foreach ($data as $key => $item)
                            <tr>
                                <th scope="row">{{ $key + 1 }}</th>
                                <td>{{ $item->nama }}</td>
                                <td>{{ $item->telepon }}</td>
                                <td>{{ $item->alamat }}</td>
                                <td>{{ $item->email }}</td>
                                <td>{{ $item->keperluan }}</td>
                                <td class="text-center">{{ $item->date }}</td>
                            </tr>

                            <!-- Modal Edit -->
                            <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1"
                                aria-labelledby="editModalLabel{{ $item->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editModalLabel{{ $item->id }}">Edit Buku Tamu
                                            </h5>
                                            <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">
                                                <i class="fas fa-times"></i> Tutup
                                            </button>

                                        </div>
                                    </div>
                                </div>
                            </div>
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
