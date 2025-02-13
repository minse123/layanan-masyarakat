@extends('kasubag.app')
@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Master Data Surat</h6>
        </div>
        <div class="card-body">
            <!-- Filter Data -->
            <div class="mb-4">
                <form action="{{ route('kasubag.surat.filter') }}" method="GET" class="form-inline">
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
                    <a href="{{ route('kasubag.surat.resetfilter') }}" class="btn btn-outline-secondary mb-2">
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
                updateFilterInput(); // Jalankan saat halaman dimuat untuk menyesuaikan input sesuai filter yang dipilih
            </script>
            <!-- Tabel Data -->
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-dark">
                        <tr>
                            <th>No.</th>
                            <th>Nomor Surat</th>
                            <th>Tanggal Surat</th>
                            <th>Pengirim</th>
                            <th>Telepon</th>
                            <th>Perihal</th>
                            <th>Status</th>
                            <th>Detail</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data->sortByDesc(function ($item) {
            return $item->status == 'Proses';
        }) as $key => $item)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $item->nomor_surat }}</td>
                                <td>{{ $item->tanggal_surat }}</td>
                                <td>{{ $item->pengirim }}</td>
                                <td>{{ $item->telepon }}</td>
                                <td>{{ $item->perihal }}</td>
                                <td>
                                    <span
                                        class="badge 
                                        @if ($item->status == 'Proses') badge-warning 
                                        @elseif ($item->status == 'Terima') badge-success 
                                        @elseif ($item->status == 'Tolak') badge-danger @endif">
                                        {{ $item->status }}
                                    </span>
                                </td>
                                <td>
                                    <!-- Tombol untuk membuka modal detail -->
                                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                        data-target="#detailModal{{ $item->id_surat }}">
                                        <i class="fas fa-eye"></i> Detail
                                    </button>

                                    <!-- Modal Detail -->
                                    <div class="modal fade" id="detailModal{{ $item->id_surat }}" tabindex="-1"
                                        role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="detailModalLabel">Detail Surat</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    @if ($item->nomor_surat)
                                                        <div class="form-group">
                                                            <label>Nomor Surat:</label>
                                                            <p>{{ $item->nomor_surat }}</p>
                                                        </div>
                                                    @endif

                                                    @if ($item->tanggal_surat)
                                                        <div class="form-group">
                                                            <label>Tanggal Surat:</label>
                                                            <p>{{ $item->tanggal_surat }}</p>
                                                        </div>
                                                    @endif

                                                    @if ($item->pengirim)
                                                        <div class="form-group">
                                                            <label>Pengirim:</label>
                                                            <p>{{ $item->pengirim }}</p>
                                                        </div>
                                                    @endif

                                                    @if ($item->telepon)
                                                        <div class="form-group">
                                                            <label>Telepon:</label>
                                                            <p>{{ $item->telepon }}</p>
                                                        </div>
                                                    @endif

                                                    @if ($item->perihal)
                                                        <div class="form-group">
                                                            <label>Perihal:</label>
                                                            <p>{{ $item->perihal }}</p>
                                                        </div>
                                                    @endif

                                                    @if ($item->status)
                                                        <div class="form-group">
                                                            <label>Status:</label>
                                                            <p>{{ $item->status }}</p>
                                                        </div>
                                                    @endif

                                                    @if ($item->keterangan)
                                                        <div class="form-group">
                                                            <label>Keterangan:</label>
                                                            <p>{{ $item->keterangan }}</p>
                                                        </div>
                                                    @endif

                                                    @if ($item->file_path)
                                                        <div class="form-group">
                                                            <label>File:</label>
                                                            <p><a href="{{ asset('storage/' . $item->file_path) }}"
                                                                    target="_blank">Lihat File</a></p>
                                                        </div>
                                                    @endif

                                                    <hr> <!-- Garis pemisah -->

                                                    @if ($item->status === 'Terima' && $item->suratTerima)
                                                        <h6>Informasi Penerimaan</h6>
                                                        @if ($item->suratTerima->first()->tanggal_terima)
                                                            <div class="form-group">
                                                                <label>Tanggal Terima:</label>
                                                                <p>{{ $item->suratTerima->first()->tanggal_terima }}</p>
                                                            </div>
                                                        @endif

                                                        @if ($item->suratTerima->first()->catatan_terima)
                                                            <div class="form-group">
                                                                <label>Catatan Terima:</label>
                                                                <p>{{ $item->suratTerima->first()->catatan_terima }}</p>
                                                            </div>
                                                        @endif
                                                    @endif

                                                    @if ($item->status !== 'Terima')
                                                        <h6>Informasi Proses</h6>
                                                        @if (optional($item->suratProses->first())->tanggal_proses)
                                                            <div class="form-group">
                                                                <label>Tanggal Proses:</label>
                                                                <p>{{ $item->suratProses->first()->tanggal_proses }}</p>
                                                            </div>
                                                        @endif

                                                        @if (optional($item->suratProses->first())->catatan_proses)
                                                            <div class="form-group">
                                                                <label>Catatan Proses:</label>
                                                                <p>{{ $item->suratProses->first()->catatan_proses }}</p>
                                                            </div>
                                                        @endif

                                                        <hr> <!-- Garis pemisah -->

                                                        <h6>Informasi Penolakan</h6>
                                                        @if (optional($item->suratTolak->first())->tanggal_tolak)
                                                            <div class="form-group">
                                                                <label>Tanggal Tolak:</label>
                                                                <p>{{ $item->suratTolak->first()->tanggal_tolak }}</p>
                                                            </div>
                                                        @endif

                                                        @if (optional($item->suratTolak->first())->alasan_tolak)
                                                            <div class="form-group">
                                                                <label>Catatan Tolak:</label>
                                                                <p>{{ $item->suratTolak->first()->alasan_tolak }}</p>
                                                            </div>
                                                        @endif
                                                    @endif
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Tutup</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if ($item->status == 'Proses')
                                        <form action="{{ route('kasubag.surat.terima', $item->id_surat) }}"
                                            method="POST" style="display:inline;" enctype="multipart/form-data">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm">
                                                <i class="fas fa-check"></i> Terima
                                            </button>
                                            @include('sweetalert::alert')
                                        </form>

                                        <form action="{{ route('kasubag.surat.tolak', $item->id_surat) }}" method="POST"
                                            style="display:inline;"enctype="multipart/form-data">
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fas fa-times"></i> Tolak
                                            </button>
                                            @include('sweetalert::alert')
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <script>
            $(document).ready(function() {
                $('#dataTable').DataTable();
            });
        </script>
    @endsection
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
