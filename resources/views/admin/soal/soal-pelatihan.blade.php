@extends('admin.app')
@include('sweetalert::alert')
@section('content')
    <!-- Filter Form -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Filter Soal</h6>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.soal-pelatihan.index') }}" class="form-inline">
                <div class="form-group mr-3">
                    <label class="mr-2 font-weight-bold">Kategori:</label>
                    <select name="kategori" class="form-control mr-2" onchange="this.form.submit()">
                        <option value="">-- Semua Kategori --</option>
                        @foreach ($kategoriList as $kategori)
                            <option value="{{ $kategori->id }}"
                                {{ request('kategori') == $kategori->id ? 'selected' : '' }}>
                                {{ $kategori->nama_kategori }} ({{ ucfirst($kategori->tipe) }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Filter</button>
            </form>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Kelola Soal Berdasarkan Kategori</h6>
            <div>
                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modalCetakSoal">
                    <i class="fas fa-print"></i> Cetak PDF
                </button>
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalTambahSoal">
                    <i class="fas fa-plus"></i> Tambah Soal
                </button>
            </div>
        </div>
        <div class="card-body">
            <!-- Tabel Soal -->
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th width="40">No</th>
                            <th>Pertanyaan</th>
                            <th>Pilihan A</th>
                            <th>Pilihan B</th>
                            <th>Pilihan C</th>
                            <th>Pilihan D</th>
                            <th>Jawaban Benar</th>
                            <th width="120">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($soalList as $i => $soal)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $soal->pertanyaan }}</td>
                                <td>{{ $soal->pilihan_a }}</td>
                                <td>{{ $soal->pilihan_b }}</td>
                                <td>{{ $soal->pilihan_c }}</td>
                                <td>{{ $soal->pilihan_d }}</td>
                                <td>
                                    <span
                                        class="badge badge-success text-uppercase">{{ strtoupper($soal->jawaban_benar) }}</span>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-warning btn-sm" data-toggle="modal"
                                        data-target="#modalEditSoal{{ $soal->id }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form action="{{ route('admin.soal-pelatihan.destroy', $soal->id) }}" method="POST"
                                        style="display:inline-block" onsubmit="return confirm('Hapus soal ini?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>

                            <!-- Modal Edit Soal -->
                            <div class="modal fade" id="modalEditSoal{{ $soal->id }}" tabindex="-1" role="dialog"
                                aria-labelledby="modalEditSoalLabel{{ $soal->id }}" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <form action="{{ route('admin.soal-pelatihan.update', $soal->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalEditSoalLabel{{ $soal->id }}">Edit
                                                    Soal</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label>Kategori</label>
                                                    <select name="id_kategori_soal_pelatihan" class="form-control" required>
                                                        @foreach ($kategoriList as $kategori)
                                                            <option value="{{ $kategori->id }}"
                                                                {{ $soal->id_kategori_soal_pelatihan == $kategori->id ? 'selected' : '' }}>
                                                                {{ $kategori->nama_kategori }}
                                                                ({{ ucfirst($kategori->tipe) }})
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>Pertanyaan</label>
                                                    <textarea name="pertanyaan" class="form-control" required>{{ $soal->pertanyaan }}</textarea>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <label>Pilihan A</label>
                                                        <input type="text" name="pilihan_a" class="form-control"
                                                            value="{{ $soal->pilihan_a }}" required>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label>Pilihan B</label>
                                                        <input type="text" name="pilihan_b" class="form-control"
                                                            value="{{ $soal->pilihan_b }}" required>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <label>Pilihan C</label>
                                                        <input type="text" name="pilihan_c" class="form-control"
                                                            value="{{ $soal->pilihan_c }}" required>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label>Pilihan D</label>
                                                        <input type="text" name="pilihan_d" class="form-control"
                                                            value="{{ $soal->pilihan_d }}" required>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Jawaban Benar</label>
                                                    <select name="jawaban_benar" class="form-control" required>
                                                        <option value="a"
                                                            {{ $soal->jawaban_benar == 'a' ? 'selected' : '' }}>A</option>
                                                        <option value="b"
                                                            {{ $soal->jawaban_benar == 'b' ? 'selected' : '' }}>B</option>
                                                        <option value="c"
                                                            {{ $soal->jawaban_benar == 'c' ? 'selected' : '' }}>C</option>
                                                        <option value="d"
                                                            {{ $soal->jawaban_benar == 'd' ? 'selected' : '' }}>D</option>
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
                        @if ($soalList->isEmpty())
                            <tr>
                                <td colspan="8" class="text-center">Belum ada soal</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Soal -->
    @include('admin.soal.modals.tambah-soal')

    <!-- Modal Cetak Soal -->
    @include('admin.soal.modals.cetak-soal')
    <div class="modal fade" id="modalTambahSoal" tabindex="-1" role="dialog" aria-labelledby="modalTambahSoalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="{{ route('admin.soal-pelatihan.store') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTambahSoalLabel">Tambah Soal</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Kategori</label>
                            <select name="id_kategori_soal_pelatihan" class="form-control" required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach ($kategoriList as $kategori)
                                    <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}
                                        ({{ ucfirst($kategori->tipe) }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Pertanyaan</label>
                            <textarea name="pertanyaan" class="form-control" required></textarea>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Pilihan A</label>
                                <input type="text" name="pilihan_a" class="form-control" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Pilihan B</label>
                                <input type="text" name="pilihan_b" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Pilihan C</label>
                                <input type="text" name="pilihan_c" class="form-control" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Pilihan D</label>
                                <input type="text" name="pilihan_d" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Jawaban Benar</label>
                            <select name="jawaban_benar" class="form-control" required>
                                <option value="">-- Pilih Jawaban --</option>
                                <option value="a">A</option>
                                <option value="b">B</option>
                                <option value="c">C</option>
                                <option value="d">D</option>
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
