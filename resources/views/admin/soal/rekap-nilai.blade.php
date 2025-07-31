@extends($layout)

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Rekap Nilai Peserta</h6>
            <div>
                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modalCetakHasil">
                    <i class="fas fa-print"></i> Cetak Hasil Peserta
                </button>
                <a href="{{ route('rekap-nilai.cetak-pdf') }}" class="btn btn-success" target="_blank">
                    <i class="fas fa-file-pdf"></i> Cetak Rekap Nilai Keseluruhan
                </a>
            </div>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <form action="{{ route('admin.rekap-nilai.index') }}" method="GET" class="mb-4" id="filterForm">
                <div class="form-row align-items-end">
                    <div class="col-md-4">
                        <label for="kategori_id">Filter by Kategori:</label>
                        <select name="kategori_id" id="kategori_id" class="form-control" onchange="this.form.submit()">
                            <option value=""> Semua Kategori</option>
                            @foreach ($kategoriList as $kategori)
                                <option value="{{ $kategori->id }}"
                                    {{ request('kategori_id') == $kategori->id ? 'selected' : '' }}>
                                    {{ $kategori->nama_kategori }} ({{ ucfirst($kategori->tipe) }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th>No</th>
                            <th>Nama Peserta</th>
                            <th>Kategori</th>
                            <th>Tipe</th>
                            <th>Total Soal</th>
                            <th>Benar</th>
                            <th>Salah</th>
                            <th>Nilai</th>
                            <th>Waktu</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rekapList as $i => $row)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $row->user->name ?? '-' }}</td>
                                <td>{{ $row->kategori->nama_kategori ?? '-' }}</td>
                                <td>{{ ucfirst($row->kategori->tipe ?? '-') }}</td>
                                <td>{{ $row->total_soal }}</td>
                                <td>{{ $row->benar }}</td>
                                <td>{{ $row->salah }}</td>
                                <td><span
                                        class="badge badge-{{ $row->nilai >= 70 ? 'success' : 'danger' }}">{{ $row->nilai }}</span>
                                </td>
                                <td>{{ $row->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    {{-- <button type="button" class="btn btn-warning btn-sm" data-toggle="modal"
                                        data-target="#modalEditRekap{{ str_replace(['.', '-'], '', $row->id) }}">
                                        <i class="fas fa-edit"></i>
                                    </button> --}}
                                    <form action="{{ route('admin.rekap-nilai.destroy', $row->id) }}" method="POST"
                                        style="display:inline-block" onsubmit="return confirm('Hapus rekap nilai ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        @if ($rekapList->isEmpty())
                            <tr>
                                <td colspan="10" class="text-center">Belum ada data</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- <!-- Modal Tambah Rekap -->
    <div class="modal fade" id="modalTambahRekap" tabindex="-1" role="dialog" aria-labelledby="modalTambahRekapLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form action="{{ route('admin.rekap-nilai.store') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTambahRekapLabel">Tambah Rekap Nilai</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Peserta</label>
                            <select name="id_user" class="form-control" required>
                                <option value="">-- Pilih Peserta --</option>
                                @forelse($users ?? [] as $user)
                                    @if (isset($user->id) && isset($user->name))
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endif
                                @empty
                                    <option value="" disabled>Tidak ada peserta tersedia</option>
                                @endforelse
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Kategori Soal</label>
                            <select name="id_kategori" id="kategoriSelect" class="form-control" required>
                                <option value="">-- Pilih Kategori --</option>
                                @forelse($kategoriList ?? [] as $kategori)
                                    @if (isset($kategori->id) && isset($kategori->nama_kategori) && isset($kategori->tipe))
                                        <option value="{{ $kategori->id }}">
                                            {{ $kategori->nama_kategori }} ({{ ucfirst($kategori->tipe) }})
                                        </option>
                                    @endif
                                @empty
                                    <option value="" disabled>Tidak ada kategori tersedia</option>
                                @endforelse
                            </select>
                        </div>
                        <div id="soalContainer">
                            <!-- Soal akan dimuat melalui AJAX -->
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div> --}}

    {{-- @foreach ($rekapList as $rekapRow)
        @php
            $modalId = str_replace(['.', '-'], '', $rekapRow->id);
            $kategori = $rekapRow->kategori;
            $user = $rekapRow->user;
        @endphp
        <!-- Modal Edit Rekap -->
        <div class="modal fade" id="modalEditRekap{{ $modalId }}" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <form action="{{ route('admin.rekap-nilai.update', $rekapRow->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Rekap Nilai</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Peserta</label>
                                <input type="text" class="form-control" value="{{ $user->name ?? 'N/A' }}" readonly>
                            </div>
                            <div class="form-group">
                                <label>Kategori Soal</label>
                                <input type="text" class="form-control"
                                    value="{{ $kategori ? $kategori->nama_kategori . ' (' . ucfirst($kategori->tipe) . ')' : 'N/A' }}"
                                    readonly>
                            </div>
                            <div id="editSoalContainer{{ $modalId }}">
                                <!-- Soal akan dimuat melalui AJAX -->
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endforeach --}}
@endsection

@include('admin.soal.modals.cetak-hasil')

@push('scripts')
    <script>
        $(document).ready(function() {
            // Inisialisasi DataTable
            $('#dataTable').DataTable({
                "order": [
                    [8, "desc"]
                ] // Urutkan berdasarkan kolom waktu terbaru
            });

            // Auto-submit form when kategori_id changes
            $('#kategori_id').change(function() {
                $('#filterForm').submit();
            });
        });
    </script>
@endpush
