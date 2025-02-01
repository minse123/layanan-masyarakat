@extends('admin.app')
@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>Data Buku Tamu</span>
            <div class="d-flex">
                <a href="{{ url('admin/form-tambah') }}" class="btn btn-success me-2">
                    <i class="fas fa-plus"></i> Tambah Data
                </a>
                <a href="{{ route('admin.cetak-pdf', ['filter' => session('filter'), 'tanggal' => session('tanggal')]) }}"
                    class="btn btn-primary">
                    Cetak PDF
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <form action="{{ url('admin/filter-data') }}" method="GET">
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
                                <a href="{{ url('admin/tamu') }}" class="btn btn-outline-secondary w-100">
                                    <i class="fas fa-sync me-2"></i> Reset
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table" id="myTable">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">No.</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Telepon</th>
                            <th scope="col">Alamat</th>
                            <th scope="col">Email</th>
                            <th scope="col">Keperluan</th>
                            <th scope="col">Waktu</th>
                            <th scope="col" style="width: 15%">Aksi</th>
                        </tr>
                    </thead>
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <tbody class="table-group-divider">
                        @foreach ($data as $key => $item)
                            <tr>
                                <th scope="row">{{ $key + 1 }}</th>
                                <td>{{ $item->nama }}</td>
                                <td>{{ $item->telepon }}</td>
                                <td>{{ $item->alamat }}</td>
                                <td>{{ $item->email }}</td>
                                <td>{{ $item->keperluan }}</td>
                                <td class="text-center">{{ $item->date }}</td>
                                <td>
                                    <div class="row">
                                        <div class="col-4">
                                            <a href="{{ url('admin/form-edit', $item->id) }}" class="btn btn-warning">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                        </div>
                                        <div class="col-4">
                                            <form action="{{ url('admin/hapus-data') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $item->id }}">
                                                <button type="submit" class="btn btn-danger" data-bs-toggle="modal">
                                                    <i class="fas fa-trash"></i> Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
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
        let table = new DataTable('#myTable');
    </script>
@endsection
