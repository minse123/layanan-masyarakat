@extends('admin.app')
@include('sweetalert::alert')
@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Master Data Konsultasi</h6>
            <div>
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#tambahModal">
                    <i class="fas fa-plus"></i> Tambah Data
                </button>
            </div>
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
                    <form action="{{ route('admin.konsultasi.filter') }}" method="GET">
                        <div class="form-row align-items-end">
                            <div class="form-group col-md-3">
                                <label for="filter">Pilih Periode:</label>
                                <select name="filter" id="filter" class="form-control" onchange="updateFilterInput()">
                                    <option value="harian" {{ request('filter', 'harian') == 'harian' ? 'selected' : '' }}>Harian</option>
                                    <option value="mingguan" {{ request('filter') == 'mingguan' ? 'selected' : '' }}>Mingguan</option>
                                    <option value="bulanan" {{ request('filter') == 'bulanan' ? 'selected' : '' }}>Bulanan</option>
                                    <option value="tahunan" {{ request('filter') == 'tahunan' ? 'selected' : '' }}>Tahunan</option>
                                </select>
                            </div>

                            <div class="form-group col-md-3" id="filter-harian">
                                <label for="tanggal">Tanggal:</label>
                                <input type="date" name="tanggal" class="form-control" value="{{ request('tanggal', date('Y-m-d')) }}">
                            </div>

                            <div class="form-group col-md-3" id="filter-mingguan" style="display: none;">
                                <label for="minggu">Minggu:</label>
                                <input type="week" name="minggu" class="form-control" value="{{ request('minggu') }}">
                            </div>

                            <div class="form-group col-md-3" id="filter-bulanan" style="display: none;">
                                <label for="bulan">Bulan:</label>
                                <input type="month" name="bulan" class="form-control" value="{{ request('bulan') }}">
                            </div>

                            <div class="form-group col-md-3" id="filter-tahunan" style="display: none;">
                                <label for="tahun">Tahun:</label>
                                <input type="number" name="tahun" class="form-control" min="2000" max="2099" step="1" value="{{ request('tahun', now()->year) }}">
                            </div>

                            <div class="form-group col-md-3">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-filter"></i> Filter
                                </button>
                                <a href="{{ route('admin.konsultasi.resetfilter') }}" class="btn btn-outline-secondary ml-2">
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
                    document.getElementById("filter-harian").style.display = (selectedFilter === "harian") ? "block" : "none";
                    document.getElementById("filter-mingguan").style.display = (selectedFilter === "mingguan") ? "block" : "none";
                    document.getElementById("filter-bulanan").style.display = (selectedFilter === "bulanan") ? "block" : "none";
                    document.getElementById("filter-tahunan").style.display = (selectedFilter === "tahunan") ? "block" : "none";
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
                            <th>Jenis Kategori</th>
                            <th>Status</th>
                            <th>Tanggal Pengajuan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($konsultasi as $key => $item)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $item->nama }}</td>
                                <td>{{ $item->telepon }}</td>
                                <td>{{ $item->email }}</td>
                                <td>{{ optional($item->kategoriPelatihan->first())->jenis_kategori ?? '-' }}</td>
                                <td>{{ $item->status }}</td>
                                <td>{{ optional(optional($item->kategoriPelatihan->first())->jenisPelatihan)->tanggal_pengajuan ?? '-' }}</td>
                                <td>
                                    <!-- Button Detail dipindah ke Aksi -->
                                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                        data-target="#detailModal{{ $item->id_konsultasi }}" title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <!-- Tombol Edit -->
                                    <button type="button" class="btn btn-warning btn-sm" data-toggle="modal"
                                        data-target="#editModal{{ $item->id_konsultasi }}" title="Edit Konsultasi">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <!-- Tombol Hapus -->
                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                        data-target="#deleteModal{{ $item->id_konsultasi }}" title="Hapus Konsultasi">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    @if ($item->status == 'Pending')
                                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                            data-target="#answerModal{{ $item->id_konsultasi }}" title="Jawab Konsultasi">
                                            <i class="fas fa-reply"></i> Jawab
                                        </button>
                                    @endif
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
                                                    {{ optional($item->kategoriPelatihan->first())->jenis_kategori ?? '-' }}</dd>

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
                                                        <dd class="col-sm-8">{{ $item->jawabPelatihan->jawaban }}</dd>
                                                    @endif
                                                    @if (optional($item->jawabPelatihan)->tanggal_dijawab)
                                                        <dt class="col-sm-4">Tanggal Dijawab</dt>
                                                        <dd class="col-sm-8">{{ $item->jawabPelatihan->tanggal_dijawab }}
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

                            <!-- Modal Edit -->
                            <div class="modal fade" id="editModal{{ $item->id_konsultasi }}" tabindex="-1"
                                role="dialog" aria-labelledby="editModalLabel{{ $item->id_konsultasi }}"
                                aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header bg-primary text-white">
                                            <h5 class="modal-title" id="editModalLabel{{ $item->id_konsultasi }}">Edit
                                                Konsultasi</h5>
                                            <button type="button" class="close text-white" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="{{ route('admin.konsultasi.update', $item->id_konsultasi) }}"
                                            method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label>Nama</label>
                                                    <input type="text" name="nama" class="form-control"
                                                        value="{{ $item->nama }}" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Telepon</label>
                                                    <input type="text" name="telepon" class="form-control"
                                                        value="{{ $item->telepon }}" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Email</label>
                                                    <input type="email" name="email" class="form-control"
                                                        value="{{ $item->email }}" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Judul Konsultasi</label>
                                                    <input type="text" name="judul_konsultasi" class="form-control"
                                                        value="{{ $item->judul_konsultasi }}" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Deskripsi</label>
                                                    <textarea name="deskripsi" class="form-control" required>{{ $item->deskripsi }}</textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label for="status">Status</label>
                                                    <select name="status" id="status"
                                                        onchange="toggleJawabanField()">
                                                        <option value="Pending"
                                                            {{ $item->status == 'Pending' ? 'selected' : '' }}>Pending
                                                        </option>
                                                        <option value="Dijawab"
                                                            {{ $item->status == 'Dijawab' ? 'selected' : '' }}>Dijawab
                                                        </option>
                                                    </select>
                                                    <div id="jawabanField"
                                                        style="display: {{ $item->status == 'Dijawab' ? 'block' : 'none' }};">
                                                        <label for="jawaban">Jawaban</label>
                                                        <textarea name="jawaban" id="jawaban">{{ optional($item->konsultasiDijawab)->jawaban ?? '' }}</textarea>
                                                    </div>
                                                    <script>
                                                        function toggleJawabanField() {
                                                            const status = document.getElementById('status').value;
                                                            const jawabanField = document.getElementById('jawabanField');
                                                            const jawabanInput = document.getElementById('jawaban');

                                                            if (status === 'Dijawab') {
                                                                jawabanField.style.display = 'block';
                                                            } else {
                                                                jawabanField.style.display = 'none';
                                                                jawabanInput.value = ''; // Hapus nilai jawaban jika tidak diperlukan
                                                            }
                                                        }
                                                        toggleJawabanField();
                                                    </script>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-primary">Simpan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal Konfirmasi Hapus -->
                            <div class="modal fade" id="deleteModal{{ $item->id_konsultasi }}" tabindex="-1"
                                role="dialog" aria-labelledby="deleteModalLabel{{ $item->id_konsultasi }}"
                                aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header bg-primary text-white">
                                            <h5 class="modal-title" id="deleteModalLabel{{ $item->id_konsultasi }}">
                                                Konfirmasi Hapus</h5>
                                            <button type="button" class="close text-white" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            Apakah Anda yakin ingin menghapus <strong>{{ $item->nomor_surat }}</strong>?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Batal</button>
                                            <form action="{{ route('admin.konsultasi.destroy', $item->id_konsultasi) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Hapus</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal untuk Menjawab Konsultasi -->
                            <div class="modal fade" id="answerModal{{ $item->id_konsultasi }}" tabindex="-1"
                                role="dialog" aria-labelledby="answerModalLabel{{ $item->id_konsultasi }}"
                                aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <form action="{{ route('admin.konsultasi.answer', $item->id_konsultasi) }}"
                                        method="POST" id="answerForm{{ $item->id_konsultasi }}">
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

            <!-- Modal Tambah -->
            <div class="modal fade" id="tambahModal" tabindex="-1" role="dialog" aria-labelledby="tambahModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title" id="tambahModalLabel">Tambah Data Konsultasi</h5>
                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('admin.konsultasi.store') }}" method="POST">
                            @csrf
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Nama</label>
                                            <input type="text" name="nama" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Telepon</label>
                                            <input type="text" name="telepon" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input type="email" name="email" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Judul Konsultasi</label>
                                            <input type="text" name="judul_konsultasi" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Deskripsi</label>
                                            <textarea name="deskripsi" class="form-control" required></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Jenis Kategori</label>
                                            <select name="jenis_kategori" id="jenis_kategori" class="form-control" required
                                                onchange="toggleJenisPelatihan()">
                                                <option value="">Pilih Kategori</option>
                                                <option value="inti">Inti</option>
                                                <option value="pendukung">Pendukung</option>
                                            </select>
                                        </div>
                                        <div class="form-group" id="pelatihan_inti_group" style="display:none;">
                                            <label>Jenis Pelatihan Inti</label>
                                            <select name="pelatihan_inti" class="form-control">
                                                <option value="">Pilih Pelatihan Inti</option>
                                                <option value="bumdes">Bumdes</option>
                                                <option value="kpmd">KPMD</option>
                                                <option value="masyarakat_hukum_adat">Masyarakat Hukum Adat</option>
                                                <option value="pembangunan_desa_wisata">Pembangunan Desa Wisata</option>
                                                <option value="catrans">Catrans</option>
                                                <option value="pelatihan_perencanaan_pembangunan_partisipatif">Pelatihan
                                                    Perencanaan Pembangunan Partisipatif</option>
                                            </select>
                                        </div>
                                        <div class="form-group" id="pelatihan_pendukung_group" style="display:none;">
                                            <label>Jenis Pelatihan Pendukung</label>
                                            <select name="pelatihan_pendukung" class="form-control">
                                                <option value="">Pilih Pelatihan Pendukung</option>
                                                <option value="prukades">Prukades</option>
                                                <option value="prudes">Prudes</option>
                                                <option value="ecomerce">Ecomerce</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Tanggal Pengajuan</label>
                                            <input type="date" name="tanggal_pengajuan" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                                <script>
                                    function toggleJenisPelatihan() {
                                        var kategori = document.getElementById('jenis_kategori').value;
                                        document.getElementById('pelatihan_inti_group').style.display = kategori === 'inti' ? 'block' : 'none';
                                        document.getElementById('pelatihan_pendukung_group').style.display = kategori === 'pendukung' ? 'block' :
                                            'none';
                                    }
                                </script>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
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
