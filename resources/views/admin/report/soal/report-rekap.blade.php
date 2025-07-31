@extends($layout)

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Report Rekap Nilai Keseluruhan</h6>
            <div>
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

            <form action="{{ route('report-rekap-nilai') }}" method="GET" class="mb-4" id="filterForm">
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
