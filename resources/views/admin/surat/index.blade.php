@extends($layout)
@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Master Data Surat</h6>
            @if(auth()->user()->role !== 'kasubag')
            <div>
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#tambahModal">
                    <i class="fas fa-plus"></i> Tambah Data
                </button>
            </div>
            @endif
        </div>
        <div class="card-body">
            <!-- Filter Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Filter Data Surat</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.master.surat') }}" method="GET">
                        <div class="form-row align-items-end">
                            <div class="form-group col-md-3">
                                <label for="filter">Pilih Periode:</label>
                                <select name="filter" id="filter" class="form-control">
                                    <option value="all_time"
                                        {{ request()->input('filter', 'all_time') == 'all_time' ? 'selected' : '' }}>Semua Waktu
                                    </option>
                                    <option value="harian" {{ request()->input('filter') == 'harian' ? 'selected' : '' }}>
                                        Harian</option>
                                    <option value="mingguan" {{ request()->input('filter') == 'mingguan' ? 'selected' : '' }}>
                                        Mingguan</option>
                                    <option value="bulanan" {{ request()->input('filter') == 'bulanan' ? 'selected' : '' }}>Bulanan
                                    </option>
                                    <option value="tahunan" {{ request()->input('filter') == 'tahunan' ? 'selected' : '' }}>Tahunan
                                    </option>
                                </select>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="status_filter">Status Surat:</label>
                                <select name="status_filter" id="status_filter" class="form-control">
                                    <option value="all" {{ request()->input('status_filter', 'all') == 'all' ? 'selected' : '' }}>
                                        Semua</option>
                                    <option value="Proses" {{ request()->input('status_filter') == 'Proses' ? 'selected' : '' }}>
                                        Proses</option>
                                    <option value="Terima" {{ request()->input('status_filter') == 'Terima' ? 'selected' : '' }}>
                                        Terima</option>
                                    <option value="Tolak" {{ request()->input('status_filter') == 'Tolak' ? 'selected' : '' }}>Tolak
                                    </option>
                                </select>
                            </div>

                            <div class="form-group col-md-4" id="date-input-container">
                                {{-- Input dinamis berdasarkan filter --}}
                            </div>

                            <div class="form-group col-md-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-filter"></i> Filter
                                </button>
                                <a href="{{ route('admin.master.surat') }}" class="btn btn-outline-secondary ml-2">
                                    <i class="fas fa-sync"></i> Reset
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Tabel Data -->
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="bg-primary text-white">
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
                        @foreach ($masterSurat as $key => $item)
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
                                        <i class="fas fa-eye"></i>
                                    </button>

                                    <!-- Modal Detail -->
                                    <div class="modal fade" id="detailModal{{ $item->id_surat }}" tabindex="-1"
                                        role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="detailModalLabel">Detail Surat</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body" style="max-height:70vh;overflow-y:auto;">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            @if ($item->nomor_surat)
                                                                <div class="form-group mb-2">
                                                                    <label>Nomor Surat:</label>
                                                                    <p class="mb-1">{{ $item->nomor_surat }}</p>
                                                                </div>
                                                            @endif

                                                            @if ($item->tanggal_surat)
                                                                <div class="form-group mb-2">
                                                                    <label>Tanggal Surat:</label>
                                                                    <p class="mb-1">{{ $item->tanggal_surat }}</p>
                                                                </div>
                                                            @endif

                                                            @if ($item->pengirim)
                                                                <div class="form-group mb-2">
                                                                    <label>Pengirim:</label>
                                                                    <p class="mb-1">{{ $item->pengirim }}</p>
                                                                </div>
                                                            @endif

                                                            @if ($item->telepon)
                                                                <div class="form-group mb-2">
                                                                    <label>Telepon:</label>
                                                                    <p class="mb-1">{{ $item->telepon }}</p>
                                                                </div>
                                                            @endif

                                                            @if ($item->perihal)
                                                                <div class="form-group mb-2">
                                                                    <label>Perihal:</label>
                                                                    <p class="mb-1">{{ $item->perihal }}</p>
                                                                </div>
                                                            @endif

                                                            @if ($item->status)
                                                                <div class="form-group mb-2">
                                                                    <label>Status:</label>
                                                                    <p class="mb-1">{{ $item->status }}</p>
                                                                </div>
                                                            @endif

                                                            @if ($item->keterangan)
                                                                <div class="form-group mb-2">
                                                                    <label>Keterangan:</label>
                                                                    <p class="mb-1">{{ $item->keterangan }}</p>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div class="col-md-6">
                                                            @if ($item->file_path)
                                                                <div class="form-group mb-2">
                                                                    <label>File:</label>
                                                                    @php
                                                                        $ext = strtolower(
                                                                            pathinfo(
                                                                                $item->file_path,
                                                                                PATHINFO_EXTENSION,
                                                                            ),
                                                                        );
                                                                        $imgExt = [
                                                                            'jpg',
                                                                            'jpeg',
                                                                            'png',
                                                                            'gif',
                                                                            'bmp',
                                                                            'webp',
                                                                        ];
                                                                    @endphp
                                                                    @if (in_array($ext, $imgExt))
                                                                        <p>
                                                                            <a href="{{ asset('storage/' . $item->file_path) }}"
                                                                                target="_blank">
                                                                                <img src="{{ asset('storage/' . $item->file_path) }}"
                                                                                    alt="Preview Gambar"
                                                                                    style="max-width: 100%; max-height: 200px; border:1px solid #ddd; border-radius:4px; padding:2px;">
                                                                            </a>
                                                                        </p>
                                                                    @elseif ($ext === 'pdf')
                                                                        <p>
                                                                            <a href="{{ asset('storage/' . $item->file_path) }}"
                                                                                target="_blank">
                                                                                <embed
                                                                                    src="{{ asset('storage/' . $item->file_path) }}"
                                                                                    type="application/pdf" width="100%"
                                                                                    height="200px" />
                                                                            </a>
                                                                        </p>
                                                                    @else
                                                                        <p>
                                                                            <a href="{{ asset('storage/' . $item->file_path) }}"
                                                                                target="_blank">Lihat File</a>
                                                                        </p>
                                                                    @endif
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            @if ($item->status === 'Terima' && $item->suratTerima)
                                                                <h6>Informasi Penerimaan</h6>
                                                                @if ($item->suratTerima->first()->tanggal_terima)
                                                                    <div class="form-group mb-2">
                                                                        <label>Tanggal Terima:</label>
                                                                        <p class="mb-1">
                                                                            {{ $item->suratTerima->first()->tanggal_terima }}
                                                                        </p>
                                                                    </div>
                                                                @endif

                                                                @if ($item->suratTerima->first()->catatan_terima)
                                                                    <div class="form-group mb-2">
                                                                        <label>Catatan Terima:</label>
                                                                        <p class="mb-1">
                                                                            {{ $item->suratTerima->first()->catatan_terima }}
                                                                        </p>
                                                                    </div>
                                                                @endif
                                                            @endif
                                                        </div>
                                                        <div class="col-md-6">
                                                            @if ($item->status !== 'Terima')
                                                                <h6>Informasi Proses</h6>
                                                                @if (optional($item->suratProses->first())->tanggal_proses)
                                                                    <div class="form-group mb-2">
                                                                        <label>Tanggal Proses:</label>
                                                                        <p class="mb-1">
                                                                            {{ $item->suratProses->first()->tanggal_proses }}
                                                                        </p>
                                                                    </div>
                                                                @endif

                                                                @if (optional($item->suratProses->first())->catatan_proses)
                                                                    <div class="form-group mb-2">
                                                                        <label>Catatan Proses:</label>
                                                                        <p class="mb-1">
                                                                            {{ $item->suratProses->first()->catatan_proses }}
                                                                        </p>
                                                                    </div>
                                                                @endif

                                                                <hr>

                                                                <h6>Informasi Penolakan</h6>
                                                                @if (optional($item->suratTolak->first())->tanggal_tolak)
                                                                    <div class="form-group mb-2">
                                                                        <label>Tanggal Tolak:</label>
                                                                        <p class="mb-1">
                                                                            {{ $item->suratTolak->first()->tanggal_tolak }}
                                                                        </p>
                                                                    </div>
                                                                @endif

                                                                @if (optional($item->suratTolak->first())->alasan_tolak)
                                                                    <div class="form-group mb-2">
                                                                        <label>Catatan Tolak:</label>
                                                                        <p class="mb-1">
                                                                            {{ $item->suratTolak->first()->alasan_tolak }}
                                                                        </p>
                                                                    </div>
                                                                @endif
                                                            @endif
                                                        </div>
                                                    </div>
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
                                    {{-- Kasubag hanya bisa verifikasi (terima/tolak) untuk surat dengan status Proses --}}
                                    @if ($item->status == 'Proses')
                                        <!-- Tombol Terima dengan konfirmasi modal -->
                                        <button type="button" class="btn btn-success btn-sm" data-toggle="modal"
                                            data-target="#terimaModal{{ $item->id_surat }}">
                                            <i class="fas fa-check"></i>
                                        </button>
                                        <!-- Modal Konfirmasi Terima -->
                                        <div class="modal fade" id="terimaModal{{ $item->id_surat }}" tabindex="-1"
                                            role="dialog" aria-labelledby="terimaModalLabel{{ $item->id_surat }}"
                                            aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title"
                                                            id="terimaModalLabel{{ $item->id_surat }}">Konfirmasi
                                                            Penerimaan
                                                        </h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Apakah Anda yakin ingin menerima surat dengan nomor
                                                        <strong>{{ $item->nomor_surat }}</strong>?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Batal</button>
                                                        <form action="{{ route('admin.surat.terima', $item->id_surat) }}"
                                                            method="POST" style="display:inline;"
                                                            enctype="multipart/form-data">
                                                            @csrf
                                                            <button type="submit" class="btn btn-success">Terima</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Tombol Tolak dengan konfirmasi modal -->
                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                            data-target="#tolakModal{{ $item->id_surat }}">
                                            <i class="fas fa-times"></i>
                                        </button>
                                        <!-- Modal Konfirmasi Tolak -->
                                        <div class="modal fade" id="tolakModal{{ $item->id_surat }}" tabindex="-1"
                                            role="dialog" aria-labelledby="tolakModalLabel{{ $item->id_surat }}"
                                            aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title"
                                                            id="tolakModalLabel{{ $item->id_surat }}">Konfirmasi Penolakan
                                                        </h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Apakah Anda yakin ingin menolak surat dengan nomor
                                                        <strong>{{ $item->nomor_surat }}</strong>?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Batal</button>
                                                        <form action="{{ route('admin.surat.tolak', $item->id_surat) }}"
                                                            method="POST" style="display:inline;"
                                                            enctype="multipart/form-data">
                                                            @csrf
                                                            <button type="submit" class="btn btn-danger">Tolak</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    {{-- Admin dapat melakukan semua operasi CRUD, kasubag tidak bisa --}}
                                    @if(auth()->user()->role !== 'kasubag')
                                        <!-- Tombol Edit -->
                                        <button type="button" class="btn btn-warning btn-sm" data-toggle="modal"
                                            data-target="#editModal{{ $item->id_surat }}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <!-- Tombol Hapus -->
                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                            data-target="#deleteModal{{ $item->id_surat }}">
                                            <i class="fas fa-trash"></i>
                                        </button>

                                        <!-- Modal Konfirmasi Hapus -->
                                        <div class="modal fade" id="deleteModal{{ $item->id_surat }}" tabindex="-1"
                                            role="dialog" aria-labelledby="deleteModalLabel{{ $item->id_surat }}"
                                            aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="deleteModalLabel{{ $item->id_surat }}">
                                                            Konfirmasi Hapus</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Apakah Anda yakin ingin menghapus surat dengan nomor
                                                        <strong>{{ $item->nomor_surat }}</strong>?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Batal</button>
                                                        <form action="{{ route('admin.surat.hapus', $item->id_surat) }}"
                                                            method="POST">
                                                            @csrf
                                                            <button type="submit" class="btn btn-danger">Hapus</button>
                                                            @include('sweetalert::alert')
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Modal Edit -->
                                        <div class="modal fade" id="editModal{{ $item->id_surat }}" tabindex="-1"
                                            role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
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
                                                        @method('PUT')
                                                        <div class="modal-body" style="max-height:70vh;overflow-y:auto;">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label>Nomor Surat</label>
                                                                        <input type="text" name="nomor_surat"
                                                                            class="form-control"
                                                                            value="{{ $item->nomor_surat }}" required>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>Tanggal Surat</label>
                                                                        <input type="date" name="tanggal_surat"
                                                                            class="form-control"
                                                                            value="{{ $item->tanggal_surat }}" required>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>Pengirim</label>
                                                                        <input type="text" name="pengirim"
                                                                            class="form-control"
                                                                            value="{{ $item->pengirim }}" required>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>Telepon</label>
                                                                        <input type="text" name="telepon"
                                                                            class="form-control" value="{{ $item->telepon }}"
                                                                            required>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
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
                                                                                {{ $item->status == 'Tolak' ? 'selected' : '' }}>
                                                                                Tolak
                                                                            </option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>Keterangan</label>
                                                                        <textarea name="keterangan" class="form-control" required>{{ $item->keterangan }}</textarea>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="file">File</label>
                                                                        <input type="file" class="form-control"
                                                                            id="file" name="file">
                                                                        <small class="form-text text-muted">Biarkan kosong jika
                                                                            tidak
                                                                            ingin mengubah file.</small>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Batal</button>
                                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                                        </div>
                                                        @include('sweetalert::alert')
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            {{-- Modal Tambah hanya untuk non-kasubag --}}
            @if(auth()->user()->role !== 'kasubag')
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
                                    <label>Telepon</label>
                                    <input type="text" name="telepon" class="form-control" required>
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
                                <div class="form-group">
                                    <label for="file">File</label>
                                    <input type="file" class="form-control" id="file" name="file" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                            @include('sweetalert::alert')
                        </form>
                    </div>
                </div>
            </div>
            @endif
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

        document.addEventListener('DOMContentLoaded', function() {
            const filterSelect = document.getElementById('filter');
            const dateInputContainer = document.getElementById('date-input-container');
            const currentFilter = '{{ request('filter', 'all_time') }}';
            const currentValue = '{{ request('tanggal', '') }}';

            function updateDateInput(filter, value) {
                let inputHtml = '';
                const today = new Date().toISOString().slice(0, 10);
                switch (filter) {
                    case 'bulanan':
                        inputHtml = `<input type="month" name="tanggal" id="tanggal" class="form-control" value="${value || today.slice(0, 7)}" required>`;
                        break;
                    case 'tahunan':
                        const currentYear = new Date().getFullYear();
                        inputHtml = `<input type="number" name="tanggal" id="tanggal" class="form-control" placeholder="Tahun" value="${value || currentYear}" min="2000" max="${currentYear}" required>`;
                        break;
                    case 'harian':
                    case 'mingguan':
                        inputHtml = `<input type="date" name="tanggal" id="tanggal" class="form-control" value="${value || today}" required>`;
                        break;
                }
                dateInputContainer.innerHTML = inputHtml;
            }

            filterSelect.addEventListener('change', function() {
                if (this.value === 'all_time') {
                    dateInputContainer.innerHTML = '';
                } else {
                    updateDateInput(this.value, '');
                }
            });

            // Initial call
            if (currentFilter !== 'all_time') {
                updateDateInput(currentFilter, currentValue);
            }
        });
    </script>
@endsection