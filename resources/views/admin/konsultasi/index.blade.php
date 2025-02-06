@extends('admin.app')
@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Master Data Konsultasi</h6>
            <div>
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#tambahModal">
                    <i class="fas fa-plus"></i> Tambah Data
                </button>
                <a href="{{ route('admin.konsultasi.cetak-pdf') }}" class="btn btn-primary">
                    <i class="fas fa-file-pdf"></i> Cetak PDF
                </a>
            </div>
        </div>
        <div class="card-body">
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
                            <th>Tanggal Pengajuan</th>
                            <th>Detail</th>
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
                                    @if ($item->konsultasiPending->isNotEmpty())
                                        @foreach ($item->konsultasiPending as $pending)
                                            <p>{{ $pending->tanggal_pengajuan }}</p>
                                        @endforeach
                                    @else
                                        <p>Tidak ada pengajuan</p>
                                    @endif
                                </td>
                                <td>
                                    <!-- Tombol untuk membuka modal detail -->
                                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                        data-target="#detailModal{{ $item->id }}">
                                        <i class="fas fa-eye"></i> Detail
                                    </button>

                                    <!-- Modal Detail -->
                                    <div class="modal fade" id="detailModal{{ $item->id }}" tabindex="-1"
                                        role="dialog" aria-labelledby="detailModalLabel{{ $item->id }}"
                                        aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="detailModalLabel{{ $item->id }}">Detail
                                                        Konsultasi</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label>Nama:</label>
                                                        <p>{{ $item->nama }}</p>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Telepon:</label>
                                                        <p>{{ $item->telepon }}</p>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Email:</label>
                                                        <p>{{ $item->email }}</p>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Judul Konsultasi:</label>
                                                        <p>{{ $item->judul_konsultasi }}</p>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Deskripsi:</label>
                                                        <p>{{ $item->deskripsi }}</p>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Status:</label>
                                                        <p>{{ $item->status }}</p>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Tanggal Pengajuan:</label>
                                                        @if ($item->konsultasiPending->isNotEmpty())
                                                            @foreach ($item->konsultasiPending as $pending)
                                                                <p>{{ $pending->tanggal_pengajuan }}</p>
                                                            @endforeach
                                                        @else
                                                            <p>Tidak ada pengajuan</p>
                                                        @endif
                                                    </div>
                                                    @if ($item->status == 'Dijawab')
                                                        <div class="form-group">
                                                            <label>Jawaban:</label>
                                                            <p>{{ optional($item->konsultasiDijawab)->jawaban }}</p>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Tanggal Dijawab:</label>
                                                            <p>{{ optional($item->konsultasiDijawab)->tanggal_dijawab }}
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
                            <h5 class="modal-title" id="tambahModalLabel">Tambah Data Konsultasi</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('admin.konsultasi.store') }}" method="POST">
                            @csrf
                            <div class="modal-body">
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
