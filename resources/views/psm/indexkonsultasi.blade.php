@extends('psm.app')
@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Master Data Konsultasi</h6>
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
            <!-- Filter Data -->
            <div class="mb-4">
                <form action="{{ route('psm.konsultasi.filter') }}" method="GET" class="form-inline">
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
                    <a href="{{ route('psm.konsultasi.resetfilter') }}" class="btn btn-outline-secondary mb-2">
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
                            <th>Nama</th>
                            <th>Telepon</th>
                            <th>Email</th>
                            <th>Judul Konsultasi</th>
                            <th>Status</th>
                            {{-- <th>Tanggal Pengajuan/Dijawab</th> --}}
                            <th>Detail</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($konsultasi->sortByDesc(fn($item) => $item->status === 'Pending' ? 1 : 0) as $key => $item)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $item->nama }}</td>
                                <td>{{ $item->telepon }}</td>
                                <td>{{ $item->email }}</td>
                                <td>{{ $item->judul_konsultasi }}</td>
                                <td>
                                    <span
                                        class="badge 
                            @if ($item->status == 'Pending') badge-warning 
                            @elseif ($item->status == 'Dijawab') badge-success @endif">
                                        {{ $item->status }}
                                    </span>
                                </td>
                                <td>
                                    <!-- Tombol untuk membuka modal detail -->
                                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                        data-target="#detailModal{{ $item->id_konsultasi }}" title="Lihat Detail">
                                        <i class="fas fa-eye"></i> Detail
                                    </button>
                                </td>
                                <td>
                                    <!-- Button to Answer Consultation -->
                                    @if ($item->status == 'Pending')
                                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                            data-target="#answerModal{{ $item->id_konsultasi }}" title="Jawab Konsultasi">
                                            <i class="fas fa-reply"></i> Jawab
                                        </button>
                                    @endif
                                </td>
                                @include('sweetalert::alert')
                            </tr>

                            <!-- Modal Detail -->
                            <div class="modal fade" id="detailModal{{ $item->id_konsultasi }}" tabindex="-1"
                                role="dialog" aria-labelledby="detailModalLabel{{ $item->id_konsultasi }}"
                                aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="detailModalLabel{{ $item->id_konsultasi }}">
                                                Detail
                                                Konsultasi</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            @if ($item->nama)
                                                <div class="form-group">
                                                    <label>Nama:</label>
                                                    <p>{{ $item->nama }}</p>
                                                </div>
                                            @endif
                                            @if ($item->telepon)
                                                <div class="form-group">
                                                    <label>Telepon:</label>
                                                    <p>{{ $item->telepon }}</p>
                                                </div>
                                            @endif
                                            @if ($item->email)
                                                <div class="form-group">
                                                    <label>Email:</label>
                                                    <p>{{ $item->email }}</p>
                                                </div>
                                            @endif
                                            @if ($item->judul_konsultasi)
                                                <div class="form-group">
                                                    <label>Judul Konsultasi:</label>
                                                    <p>{{ $item->judul_konsultasi }}</p>
                                                </div>
                                            @endif
                                            @if ($item->deskripsi)
                                                <div class="form-group">
                                                    <label>Deskripsi:</label>
                                                    <p>{{ $item->deskripsi }}</p>
                                                </div>
                                            @endif
                                            @if ($item->status)
                                                <div class="form-group">
                                                    <label>Status:</label>
                                                    <p>{{ $item->status }}</p>
                                                </div>
                                            @endif
                                            <div class="form-group">
                                                <label>Tanggal Pengajuan:</label>
                                                @if ($item->konsultasiPending && $item->konsultasiPending->isNotEmpty())
                                                    @foreach ($item->konsultasiPending as $pending)
                                                        <p>{{ $pending->tanggal_pengajuan }}</p>
                                                    @endforeach
                                                @else
                                                    <p>Tidak ada pengajuan</p>
                                                @endif
                                            </div>
                                            @if ($item->status == 'Dijawab')
                                                @if (optional($item->konsultasiDijawab)->jawaban)
                                                    <div class="form-group">
                                                        <label>Jawaban:</label>
                                                        <p>{{ optional($item->konsultasiDijawab)->jawaban }}</p>
                                                    </div>
                                                @endif
                                                @if (optional($item->konsultasiDijawab)->tanggal_dijawab)
                                                    <div class="form-group">
                                                        <label>Tanggal Dijawab:</label>
                                                        <p>{{ optional($item->konsultasiDijawab)->tanggal_dijawab }}
                                                        </p>
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
                            <!-- Modal untuk Menjawab Konsultasi -->
                            <div class="modal fade" id="answerModal{{ $item->id_konsultasi }}" tabindex="-1"
                                role="dialog" aria-labelledby="answerModalLabel{{ $item->id_konsultasi }}"
                                aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <form action="{{ route('psm.konsultasi.jawab', $item->id_konsultasi) }}"
                                        method="POST"
                                        id="answerForm{{ $item->id_konsultasi }}"enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="answerModalLabel{{ $item->id_konsultasi }}">
                                                    Jawab Konsultasi dari {{ $item->nama }}</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="jawaban{{ $item->id_konsultasi }}">Jawaban</label>
                                                    <textarea name="jawaban" id="jawaban" class="form-control" required></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-primary">Simpan</button>
                                            </div>
                                        </div>
                                    </form>
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
