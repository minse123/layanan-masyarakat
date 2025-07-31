@extends($layout)
@include('sweetalert::alert')
@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Laporan Konsultasi Pelatihan Pendukung</h6>
            <a href="{{ route('report.konsultasi.pendukung.cetak-pdf', request()->query()) }}"
                class="btn btn-primary btn-icon-split" target="_blank">
                <span class="icon text-white-50">
                    <i class="fas fa-file-pdf"></i>
                </span>
                <span class="text">Cetak PDF</span>
            </a>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <!-- Filter Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Filter Data Konsultasi</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('konsultasi.pendukung.report') }}" method="GET">
                        <div class="form-row align-items-end">
                            <div class="form-group col-md-3">
                                <label for="jenis_pelatihan">Jenis Pelatihan</label>
                                <select name="jenis_pelatihan" id="jenis_pelatihan" class="form-control">
                                    <option value="">-- Semua --</option>
                                    <option value="prukades" {{ request('jenis_pelatihan') == 'prukades' ? 'selected' : '' }}>
                                        Prukades
                                    </option>
                                    <option value="prudes" {{ request('jenis_pelatihan') == 'prudes' ? 'selected' : '' }}>
                                        Prudes
                                    </option>
                                    <option value="ecomerce" {{ request('jenis_pelatihan') == 'ecomerce' ? 'selected' : '' }}>
                                        E-Commerce
                                    </option>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="filter">Pilih Periode:</label>
                                <select name="filter" id="filter" class="form-control" onchange="updateFilterInput()">
                                    <option value="all_time"
                                        {{ request('filter', 'all_time') == 'all_time' ? 'selected' : '' }}>Semua Waktu
                                    </option>
                                    <option value="harian" {{ request('filter') == 'harian' ? 'selected' : '' }}>Harian
                                    </option>
                                    <option value="mingguan" {{ request('filter') == 'mingguan' ? 'selected' : '' }}>
                                        Mingguan</option>
                                    <option value="bulanan" {{ request('filter') == 'bulanan' ? 'selected' : '' }}>
                                        Bulanan</option>
                                    <option value="tahunan" {{ request('filter') == 'tahunan' ? 'selected' : '' }}>
                                        Tahunan</option>
                                </select>
                            </div>

                            <div class="form-group col-md-3" id="filter-harian">
                                <label for="tanggal">Tanggal:</label>
                                <input type="date" name="tanggal" class="form-control"
                                    value="{{ request('tanggal', date('Y-m-d')) }}">
                            </div>

                            <div class="form-group col-md-3" id="filter-mingguan" style="display: none;">
                                <label for="minggu">Minggu:</label>
                                <input type="week" name="minggu" class="form-control"
                                    value="{{ request('minggu') }}">
                            </div>

                            <div class="form-group col-md-3" id="filter-bulanan" style="display: none;">
                                <label for="bulan">Bulan:</label>
                                <input type="month" name="bulan" class="form-control"
                                    value="{{ request('bulan') }}">
                            </div>

                            <div class="form-group col-md-3" id="filter-tahunan" style="display: none;">
                                <label for="tahun">Tahun:</label>
                                <input type="number" name="tahun" class="form-control" min="2000"
                                    max="2099" step="1" value="{{ request('tahun', now()->year) }}">
                            </div>

                            <div class="form-group col-md-3">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-filter"></i> Filter
                                </button>
                                <a href="{{ route('konsultasi.pendukung.report') }}"
                                    class="btn btn-outline-secondary ml-2">
                                    <i class="fas fa-sync"></i> Reset
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <script>
                function updateFilterInput() {
                    const selectedFilter = document.getElementById("filter").value;
                    const isDateFilter = (selectedFilter === "harian" || selectedFilter === "mingguan" || selectedFilter ===
                        "bulanan" || selectedFilter === "tahunan");

                    document.getElementById("filter-harian").style.display = (selectedFilter === "harian") ? "block" : "none";
                    document.getElementById("filter-mingguan").style.display = (selectedFilter === "mingguan") ? "block" :
                        "none";
                    document.getElementById("filter-bulanan").style.display = (selectedFilter === "bulanan") ? "block" :
                        "none";
                    document.getElementById("filter-tahunan").style.display = (selectedFilter === "tahunan") ? "block" :
                        "none";

                    // If no date filter is selected, clear the values of date inputs
                    if (!isDateFilter) {
                        document.querySelector('#filter-harian input[name="tanggal"]').value = '';
                        document.querySelector('#filter-mingguan input[name="minggu"]').value = '';
                        document.querySelector('#filter-bulanan input[name="bulan"]').value = '';
                        document.querySelector('#filter-tahunan input[name="tahun"]').value = '';
                    }
                }
                document.addEventListener('DOMContentLoaded', function() {
                    updateFilterInput();
                });
            </script>
            <!-- Tabel Data -->
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th>No.</th>
                            <th>Nama</th>
                            <th>Telepon</th>
                            <th>Email</th>
                            <th>Judul Konsultasi</th>
                            <th>Jenis Pelatihan</th>
                            <th>Tanggal Pengajuan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $key => $item)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $item->nama ?? '-' }}</td>
                                <td>{{ $item->telepon ?? '-' }}</td>
                                <td>{{ $item->email ?? '-' }}</td>
                                <td>{{ $item->judul_konsultasi ?? '-' }}</td>
                                <td>
                                    {{ optional(optional($item->kategoriPelatihan->first())->jenisPelatihan)->pelatihan_pendukung ?? '-' }}
                                </td>
                                <td>
                                    {{ optional(optional($item->kategoriPelatihan->first())->jenisPelatihan)->tanggal_pengajuan ?? '-' }}
                                </td>
                                <td>
                                    <!-- Button Detail dipindah ke Aksi -->
                                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                        data-target="#detailModal{{ $item->id_konsultasi }}" title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                            <!-- Modal Detail -->
                            <div class="modal fade" id="detailModal{{ $item->id_konsultasi }}" tabindex="-1"
                                role="dialog" aria-labelledby="detailModalLabel{{ $item->id_konsultasi }}"
                                aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header bg-primary text-white">
                                            <h5 class="modal-title" id="detailModalLabel{{ $item->id_konsultasi }}">
                                                Detail Konsultasi
                                            </h5>
                                            <button type="button" class="close text-white" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <dl class="row mb-0">
                                                <dt class="col-sm-4">Nama</dt>
                                                <dd class="col-sm-8">{{ $item->nama }}</dd>

                                                <dt class="col-sm-4">Telepon</dt>
                                                <dd class="col-sm-8">{{ $item->telepon }}</dd>

                                                <dt class="col-sm-4">Email</dt>
                                                <dd class="col-sm-8">{{ $item->email }}</dd>

                                                <dt class="col-sm-4">Judul Konsultasi</dt>
                                                <dd class="col-sm-8">{{ $item->judul_konsultasi }}</dd>

                                                <dt class="col-sm-4">Deskripsi</dt>
                                                <dd class="col-sm-8">{{ $item->deskripsi }}</dd>

                                                <dt class="col-sm-4">Status</dt>
                                                <dd class="col-sm-8">{{ $item->status }}</dd>

                                                <dt class="col-sm-4">Tanggal Pengajuan</dt>
                                                <dd class="col-sm-8">
                                                    {{ optional(optional($item->kategoriPelatihan->first())->jenisPelatihan)->tanggal_pengajuan ?? '-' }}
                                                </dd>

                                                <dt class="col-sm-4">Jenis Kategori</dt>
                                                <dd class="col-sm-8">
                                                    {{ optional($item->kategoriPelatihan->first())->jenis_kategori ?? '-' }}
                                                </dd>

                                                <dt class="col-sm-4">Jenis Pelatihan</dt>
                                                <dd class="col-sm-8">
                                                    @if (optional($item->kategoriPelatihan->first())->jenis_kategori == 'inti')
                                                        {{ optional($item->kategoriPelatihan->first()->jenisPelatihan)->pelatihan_inti ?? '-' }}
                                                    @elseif (optional($item->kategoriPelatihan->first())->jenis_kategori == 'pendukung')
                                                        {{ optional($item->kategoriPelatihan->first()->jenisPelatihan)->pelatihan_pendukung ?? '-' }}
                                                    @else
                                                        -
                                                    @endif
                                                </dd>

                                                @if ($item->status == 'Dijawab')
                                                    @if (optional($item->jawabPelatihan)->jawaban)
                                                        <dt class="col-sm-4">Jawaban</dt>
                                                        <dd class="col-sm-8">{{ $item->jawabPelatihan->jawaban }}
                                                        </dd>
                                                    @endif
                                                    @if (optional($item->jawabPelatihan)->tanggal_dijawab)
                                                        <dt class="col-sm-4">Tanggal Dijawab</dt>
                                                        <dd class="col-sm-8">
                                                            {{ $item->jawabPelatihan->tanggal_dijawab }}
                                                        </dd>
                                                    @endif
                                                @endif
                                            </dl>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Tutup</button>
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
        $(document).ready(function() {
            $('#dataTable').DataTable();
        });
    </script>
@endsection

