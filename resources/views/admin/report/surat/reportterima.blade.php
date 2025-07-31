@extends($layout)
@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Laporan Surat Yang Diterima</h6>
            <div>
                <a href="{{ route('admin.surat.report.cetak', ['type' => 'terima']) }}" class="btn btn-primary btn-icon-split">
                    <span class="icon text-white-50">
                        <i class="fas fa-file-pdf"></i>
                    </span>
                    <span class="text">Cetak PDF</span>
                </a>
            </div>
        </div>
        <div class="card-body">
            @if (!empty($message))
                <div class="alert alert-warning">
                    {{ $message }}
                </div>
            @endif
            <!-- Filter Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Filter Laporan</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.surat.report', ['type' => 'terima']) }}" method="GET">
                        <div class="form-row align-items-end">
                            <div class="form-group col-md-4">
                                <label for="filter">Pilih Periode</label>
                                <select name="filter" id="filter" class="form-control">
                                    <option value="harian" {{ request('filter') == 'harian' ? 'selected' : '' }}>Harian</option>
                                    <option value="mingguan" {{ request('filter') == 'mingguan' ? 'selected' : '' }}>Mingguan</option>
                                    <option value="bulanan" {{ request('filter') == 'bulanan' ? 'selected' : '' }}>Bulanan</option>
                                    <option value="tahunan" {{ request('filter') == 'tahunan' ? 'selected' : '' }}>Tahunan</option>
                                </select>
                            </div>
                            <div class="form-group col-md-5" id="date-input-container">
                                {{-- Input dinamis berdasarkan filter --}}
                            </div>
                            <div class="form-group col-md-3">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-filter"></i> Filter
                                </button>
                                <a href="{{ route('admin.surat.report.reset', ['type' => 'terima']) }}" class="btn btn-outline-secondary ml-2">
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
                            <th>Perihal</th>
                            <th>Pengirim</th>
                            <th>Telepon</th>
                            <th>Keterangan</th>
                            <th>Tanggal Terima</th>
                            <th>Catatan Terima</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $key => $item)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $item->masterSurat->nomor_surat ?? '-' }}</td>
                                <td>{{ $item->masterSurat->tanggal_surat ?? '-' }}</td>
                                <td>{{ $item->masterSurat->perihal ?? '-' }}</td>
                                <td>{{ $item->masterSurat->pengirim ?? '-' }}</td>
                                <td>{{ $item->masterSurat->telepon ?? '-' }}</td>
                                <td>{{ $item->masterSurat->keterangan ?? '-' }}</td>
                                <td>{{ $item->tanggal_terima ?? '-' }}</td>
                                <td>{{ $item->catatan_terima ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable();
        });

        document.addEventListener('DOMContentLoaded', function() {
            const filterSelect = document.getElementById('filter');
            const dateInputContainer = document.getElementById('date-input-container');
            const currentFilter = '{{ request('filter', 'harian') }}';
            const currentValue = '{{ request('tanggal', '') }}';

            function updateDateInput(filter, value) {
                let inputHtml = '';
                const today = new Date().toISOString().slice(0, 10);
                switch (filter) {
                    case 'bulanan':
                        inputHtml = `<label for="tanggal">Pilih Bulan</label><input type="month" name="tanggal" id="tanggal" class="form-control" value="${value || today.slice(0, 7)}" required>`;
                        break;
                    case 'tahunan':
                        const currentYear = new Date().getFullYear();
                        inputHtml = `<label for="tanggal">Pilih Tahun</label><input type="number" name="tanggal" id="tanggal" class="form-control" placeholder="Tahun" value="${value || currentYear}" min="2000" max="${currentYear}" required>`;
                        break;
                    case 'harian':
                    case 'mingguan':
                    default:
                        inputHtml = `<label for="tanggal">Pilih Tanggal</label><input type="date" name="tanggal" id="tanggal" class="form-control" value="${value || today}" required>`;
                        break;
                }
                dateInputContainer.innerHTML = inputHtml;
            }

            filterSelect.addEventListener('change', function() {
                updateDateInput(this.value, '');
            });

            updateDateInput(currentFilter, currentValue);
        });
    </script>
@endsection