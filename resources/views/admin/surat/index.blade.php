@extends('admin.app')
@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Master Data Surat</h6>
            <div>
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#tambahModal">
                    <i class="fas fa-plus"></i> Tambah Data
                </button>
                <a href="{{ route('admin.surat-masuk.cetak-pdf', ['filter' => session('filter'), 'tanggal' => session('tanggal')]) }}"
                    class="btn btn-primary">
                    <i class="fas fa-file-pdf"></i> Cetak PDF
                </a>
            </div>
        </div>
        <div class="card-body">
            <!-- Filter Data -->
            <div class="mb-4">
                <form action="{{ route('admin.surat-masuk.filter') }}" method="GET" class="form-inline">
                    <div class="form-group mb-2">
                        <label for="filter" class="mr-2">Pilih Periode</label>
                        <select name="filter" id="filter" class="form-control">
                            <option value="harian" {{ request('filter') == 'harian' ? 'selected' : '' }}>Harian</option>
                            <option value="mingguan" {{ request('filter') == 'mingguan' ? 'selected' : '' }}>Mingguan
                            </option>
                            <option value="bulanan" {{ request('filter') == 'bulanan' ? 'selected' : '' }}>Bulanan</option>
                            <option value="tahunan" {{ request('filter') == 'tahunan' ? 'selected' : '' }}>Tahunan</option>
                        </select>
                    </div>
                    <div class="form-group mx-sm-3 mb-2">
                        <input type="date" name="tanggal" id="tanggal" class="form-control"
                            value="{{ request('tanggal') }}">
                    </div>
                    <button type="submit" class="btn btn-primary mb-2">
                        <i class="fas fa-filter"></i> Filter
                    </button>
                    <a href="{{ url('/surat-masuk') }}" class="btn btn-outline-secondary mb-2">
                        <i class="fas fa-sync"></i> Reset
                    </a>
                </form>
            </div>
            <!-- Tabel Data -->
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-dark">
                        <tr>
                            <th>No.</th>
                            <th>Nomor Surat</th>
                            <th>Tanggal Surat</th>
                            <th>Pengirim</th>
                            <th>Perihal</th>
                            <th>Status</th>
                            <th>Detail</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($masterSurat as $key => $item)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $item->nomor_surat }}</td>
                                <td>{{ $item->tanggal_surat }}</td>
                                <td>{{ $item->pengirim }}</td>
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
                                                    <div class="form-group">
                                                        <label>Nomor Surat:</label>
                                                        <p>{{ $item->nomor_surat }}</p>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Tanggal Surat:</label>
                                                        <p>{{ $item->tanggal_surat }}</p>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Pengirim:</label>
                                                        <p>{{ $item->pengirim }}</p>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Perihal:</label>
                                                        <p>{{ $item->perihal }}</p>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Status:</label>
                                                        <p>{{ $item->status }}</p>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Keterangan:</label>
                                                        <p>{{ $item->keterangan }}</p>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>File:</label>
                                                        <p><a href="{{ asset('storage/' . $item->file_path) }}"
                                                                target="_blank">Lihat File</a></p>
                                                    </div>

                                                    <hr> <!-- Garis pemisah -->

                                                    @if ($item->status === 'diterima')
                                                        <h6>Informasi Penerimaan</h6>
                                                        <div class="form-group">
                                                            <label>Tanggal Terima:</label>
                                                            <p>{{ optional($item->suratTerima)->tanggal_terima ?? 'Belum diterima' }}
                                                            </p>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Catatan Terima:</label>
                                                            <p>{{ optional($item->suratTerima)->catatan_terima ?? 'Tidak ada catatan' }}
                                                            </p>
                                                        </div>
                                                    @else
                                                        <h6>Informasi Proses</h6>
                                                        <div class="form-group">
                                                            <label>Tanggal Proses:</label>
                                                            <p>{{ optional($item->suratProses->first())->tanggal_proses ?? 'Belum diproses' }}
                                                            </p>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Catatan Proses:</label>
                                                            <p>{{ optional($item->suratProses->first())->catatan_proses ?? 'Tidak ada catatan' }}
                                                            </p>
                                                        </div>

                                                        <hr> <!-- Garis pemisah -->

                                                        <h6>Informasi Penolakan</h6>
                                                        <div class="form-group">
                                                            <label>Tanggal Tolak:</label>
                                                            <p>{{ optional($item->suratTolak)->tanggal_tolak ?? 'Belum ditolak' }}
                                                            </p>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Catatan Tolak:</label>
                                                            <p>{{ optional($item->suratTolak)->catatan_tolak ?? 'Tidak ada catatan' }}
                                                            </p>
                                                        </div>
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
                                        <form action="{{ route('admin.surat.terima', $item->id_surat) }}" method="POST"
                                            style="display:inline;" enctype="multipart/form-data">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm">
                                                <i class="fas fa-check"></i> Terima
                                            </button>
                                        </form>

                                        <form action="{{ route('admin.surat.tolak', $item->id_surat) }}" method="POST"
                                            style="display:inline;"enctype="multipart/form-data">
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fas fa-times"></i> Tolak
                                            </button>
                                        </form>
                                    @endif

                                    <!-- Tombol Edit -->
                                    <button type="button" class="btn btn-warning btn-sm" data-toggle="modal"
                                        data-target="#editModal{{ $item->id_surat }}">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>

                                    <!-- Tombol Hapus -->
                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                        data-target="#deleteModal{{ $item->id_surat }}">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>

                                    <!-- Modal Edit -->
                                    <div class="modal fade" id="editModal{{ $item->id_surat }}" tabindex="-1"
                                        role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editModalLabel">Edit Data Surat</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="{{ route('admin.master.surat.update', $item->id_surat) }}"
                                                    method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT') <!-- Menggunakan metode PUT untuk update -->
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label>Nomor Surat</label>
                                                            <input type="text" name="nomor_surat" class="form-control"
                                                                value="{{ $item->nomor_surat }}" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Tanggal Surat</label>
                                                            <input type="date" name="tanggal_surat"
                                                                class="form-control" value="{{ $item->tanggal_surat }}"
                                                                required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Pengirim</label>
                                                            <input type="text" name="pengirim" class="form-control"
                                                                value="{{ $item->pengirim }}" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Perihal</label>
                                                            <textarea name="perihal" class="form-control" required>{{ $item->perihal }}</textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Status</label>
                                                            <select name="status" class="form-control">
                                                                <option value="Proses"
                                                                    {{ $item->status == 'Proses' ? 'selected' : '' }}>
                                                                    Proses</option>
                                                                <option value="Terima"
                                                                    {{ $item->status == 'Terima' ? 'selected' : '' }}>
                                                                    Terima</option>
                                                                <option value="Tolak"
                                                                    {{ $item->status == 'Tolak' ? 'selected' : '' }}>Tolak
                                                                </option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Keterangan</label>
                                                            <textarea name="keterangan" class="form-control" required>{{ $item->keterangan }}</textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="file">File</label>
                                                            <input type="file" class="form-control" id="file"
                                                                name="file">
                                                            <small class="form-text text-muted">Biarkan kosong jika tidak
                                                                ingin mengubah file.</small>
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
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="modal fade" id="tambahModal" tabindex="-1" role="dialog" aria-labelledby="tambahModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="tambahModalLabel">Tambah Data Surat</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('admin.surat.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>Nomor Surat</label>
                                    <input type="text" name="nomor_surat" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Tanggal Surat</label>
                                    <input type="date" name="tanggal_surat" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Pengirim</label>
                                    <input type="text" name="pengirim" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Perihal</label>
                                    <textarea name="perihal" class="form-control" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Status</label>
                                    <select name="status" class="form-control">
                                        <option value="Proses">Proses</option>
                                        <option value="Terima">Terima</option>
                                        <option value="Tolak">Tolak</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Keterangan</label>
                                    <textarea name="keterangan" class="form-control" required></textarea>
                                </div>
                                {{-- <div class="form-group">
                                    <label for="file">File</label>
                                    <input type="file" class="form-control" id="file" name="file" required>
                                </div> --}}
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
    @endsection
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @section('script')
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
