@extends($layout)
@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Manajemen Kategori Soal Pelatihan</h6>
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalTambahKategori">
                <i class="fas fa-plus"></i> Tambah Kategori
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th width="40">No</th>
                            <th>ID</th>
                            <th>Nama Kategori</th>
                            <th>Tipe</th>
                            <th width="120">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kategori as $i => $row)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $row->id }}</td>
                                <td>{{ $row->nama_kategori }}</td>
                                <td>
                                    <span class="badge badge-{{ $row->tipe == 'inti' ? 'primary' : 'secondary' }}">
                                        {{ ucfirst($row->tipe) }}
                                    </span>
                                </td>
                                <td>
                                    <!-- Tombol Edit Modal -->
                                    <button type="button" class="btn btn-warning btn-sm" data-toggle="modal"
                                        data-target="#modalEditKategori{{ $row->id }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <!-- Tombol Hapus Modal -->
                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                        data-target="#modalDeleteKategori{{ $row->id }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>

                            <!-- Modal Edit Kategori -->
                            <div class="modal fade" id="modalEditKategori{{ $row->id }}" tabindex="-1" role="dialog"
                                aria-labelledby="modalEditLabel{{ $row->id }}" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <form action="{{ route('psm.kategori-soal-pelatihan.update', $row->id) }}"
                                        method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalEditLabel{{ $row->id }}">Edit
                                                    Kategori
                                                    Soal</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label>Nama Kategori</label>
                                                    <input type="text" name="nama_kategori" class="form-control"
                                                        value="{{ $row->nama_kategori }}" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Tipe</label>
                                                    <select name="tipe" class="form-control" required>
                                                        <option value="inti"
                                                            {{ $row->tipe == 'inti' ? 'selected' : '' }}>Inti</option>
                                                        <option value="pendukung"
                                                            {{ $row->tipe == 'pendukung' ? 'selected' : '' }}>Pendukung
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-primary">Update</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!-- Modal Hapus Kategori -->
                            <div class="modal fade" id="modalDeleteKategori{{ $row->id }}" tabindex="-1"
                                role="dialog" aria-labelledby="modalDeleteLabel{{ $row->id }}" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <form action="{{ route('psm.kategori-soal-pelatihan.destroy', $row->id) }}"
                                        method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <div class="modal-content">
                                            <div class="modal-header bg-danger text-white">
                                                <h5 class="modal-title" id="modalDeleteLabel{{ $row->id }}">Konfirmasi
                                                    Hapus</h5>
                                                <button type="button" class="close text-white" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                Apakah Anda yakin ingin menghapus kategori
                                                <strong>{{ $row->nama_kategori }}</strong>?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-danger">Hapus</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                        @if ($kategori->isEmpty())
                            <tr>
                                <td colspan="4" class="text-center">Belum ada data</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Kategori -->
    <div class="modal fade" id="modalTambahKategori" tabindex="-1" role="dialog" aria-labelledby="modalTambahLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="{{ route('psm.kategori-soal-pelatihan.store') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTambahLabel">Tambah Kategori Soal</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nama Kategori</label>
                            <input type="text" name="nama_kategori" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Tipe</label>
                            <select name="tipe" class="form-control" required>
                                <option value="">-- Pilih Tipe --</option>
                                <option value="inti">Inti</option>
                                <option value="pendukung">Pendukung</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                </div>
            </form>
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
