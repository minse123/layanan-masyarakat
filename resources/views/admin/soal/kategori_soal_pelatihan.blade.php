{{-- filepath: resources/views/admin/soal/kategori_soal_pelatihan.blade.php --}}
@extends('admin.app')

@section('content')
    <div class="container-fluid">
        <h4 class="mb-4 font-weight-bold text-primary">Manajemen Kategori Soal Pelatihan</h4>

        <!-- Tombol Tambah Kategori -->
        <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#modalTambahKategori">
            <i class="fas fa-plus"></i> Tambah Kategori
        </button>

        <!-- Modal Tambah Kategori -->
        <div class="modal fade" id="modalTambahKategori" tabindex="-1" role="dialog" aria-labelledby="modalTambahLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form action="{{ route('admin.kategori-soal-pelatihan.store') }}" method="POST">
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
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Card Table -->
        <div class="card shadow mb-4">
            <div class="card-header py-3 bg-primary">
                <h6 class="m-0 font-weight-bold text-white">Daftar Kategori Soal Pelatihan</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" width="100%" cellspacing="0">
                        <thead class="thead-dark">
                            <tr>
                                <th width="40">No</th>
                                <th>Nama Kategori</th>
                                <th>Tipe</th>
                                <th width="120">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($kategori as $i => $row)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td>{{ $row->nama_kategori }}</td>
                                    <td>
                                        <span class="badge badge-{{ $row->tipe == 'inti' ? 'primary' : 'success' }}">
                                            {{ ucfirst($row->tipe) }}
                                        </span>
                                    </td>
                                    <td>
                                        <!-- Tombol Edit Modal -->
                                        <button type="button" class="btn btn-warning btn-sm" data-toggle="modal"
                                            data-target="#modalEditKategori{{ $row->id }}">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>
                                        <!-- Hapus -->
                                        <form action="{{ route('admin.kategori-soal-pelatihan.destroy', $row->id) }}"
                                            method="POST" style="display:inline-block"
                                            onsubmit="return confirm('Hapus kategori ini?')">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i>
                                                Hapus</button>
                                        </form>
                                    </td>
                                </tr>

                                <!-- Modal Edit Kategori -->
                                <div class="modal fade" id="modalEditKategori{{ $row->id }}" tabindex="-1"
                                    role="dialog" aria-labelledby="modalEditLabel{{ $row->id }}" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <form action="{{ route('admin.kategori-soal-pelatihan.update', $row->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="modalEditLabel{{ $row->id }}">Edit
                                                        Kategori Soal</h5>
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
    </div>
@endsection
