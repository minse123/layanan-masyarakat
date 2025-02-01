@extends('admin.app')
@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>Data Surat Masuk</span>
            <div class="d-flex">
                <!-- Tombol Tambah Data -->
                <button type="button" class="btn btn-success me-2" data-bs-toggle="modal" data-bs-target="#tambahModal">
                    <i class="fas fa-plus"></i> Tambah Data
                </button>
                <!-- Tombol Cetak PDF -->
                <a href="{{ route('admin.surat-masuk.cetak-pdf', ['filter' => session('filter'), 'tanggal' => session('tanggal')]) }}"
                    class="btn btn-primary">
                    Cetak PDF
                </a>
            </div>
        </div>
        <div class="card-body">
            <!-- Filter Data -->
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <form action="{{ url('admin/surat-masuk/filter-data') }}" method="GET">
                        <div class="row g-3 align-items-end">
                            <div class="col-md-3">
                                <label for="filter" class="form-label">Pilih Periode</label>
                                <select name="filter" id="filter" class="form-select">
                                    <option value="harian" {{ request('filter') == 'harian' ? 'selected' : '' }}>Harian
                                    </option>
                                    <option value="mingguan" {{ request('filter') == 'mingguan' ? 'selected' : '' }}>
                                        Mingguan</option>
                                    <option value="bulanan" {{ request('filter') == 'bulanan' ? 'selected' : '' }}>Bulanan
                                    </option>
                                    <option value="tahunan" {{ request('filter') == 'tahunan' ? 'selected' : '' }}>Tahunan
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <input type="date" name="tanggal" id="tanggal" class="form-control"
                                    value="{{ request('tanggal') }}">
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-filter me-2"></i> Filter
                                </button>
                            </div>
                            <div class="col-md-3">
                                <a href="{{ url('admin/surat-masuk') }}" class="btn btn-outline-secondary w-100">
                                    <i class="fas fa-sync me-2"></i> Reset
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Tabel Data -->
            <div class="table-responsive">
                <table class="table" id="myTable">
                    <thead class="thead-dark">
                        <tr>
                            <th>No.</th>
                            <th>Nomor Surat</th>
                            <th>Tanggal Surat</th>
                            <th>Pengirim</th>
                            <th>Perihal</th>
                            <th>Disposisi</th>
                            <th>File</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $key => $item)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $item->masterSurat->nomor_surat ?? '-' }}</td>
                                <td>{{ $item->masterSurat->tanggal_surat ?? '-' }}</td>
                                <td>{{ $item->masterSurat->pengirim ?? '-' }}</td>
                                <td>{{ $item->masterSurat->perihal ?? '-' }}</td>
                                <td>{{ $item->disposisi }}</td>
                                <td>
                                    @if ($item->file)
                                        <a href="{{ asset('storage/' . $item->file) }}" target="_blank"
                                            class="btn btn-sm btn-info">
                                            <i class="fas fa-download"></i> Download
                                        </a>
                                    @else
                                        <span class="text-muted">Tidak ada file</span>
                                    @endif
                                </td>
                                <td>
                                    <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                        data-bs-target="#editModal{{ $item->id }}">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#hapusModal{{ $item->id }}">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </td>
                            </tr>
                            <!-- Modal Edit -->
                            <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Surat Masuk</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ url('admin/surat-masuk/update') }}" method="post">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $item->id }}">
                                                <div class="form-group">
                                                    <label>Nomor Surat</label>
                                                    <input type="text" class="form-control" name="nomor_surat"
                                                        value="{{ $item->masterSurat->nomor_surat }}">
                                                </div>
                                                <button type="submit" class="btn btn-primary">Update</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Modal Hapus -->
                            <div class="modal fade" id="hapusModal{{ $item->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Konfirmasi Hapus</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Apakah Anda yakin ingin menghapus surat masuk ini?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <form action="{{ url('admin/surat-masuk/hapus-data') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $item->id }}">
                                                <button type="submit" class="btn btn-danger">Hapus</button>
                                            </form>
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Batal</button>
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
