@extends('kasubag.app')
@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>Data Buku Tamu</span>
        </div>
        <div class="card-body">
            <!-- Filter Data -->
            <div class="mb-4">
                <form action="{{ route('kasubag.filterdatatamu') }}" method="GET" class="form-inline">
                    <div class="form-group mb-2">
                        <label for="filter" class="mr-2">Pilih Periode</label>
                        <select name="filter" id="filter" class="form-control">
                            <option value="harian" {{ request('filter') == 'harian' ? 'selected' : '' }}>Harian</option>
                            <option value="mingguan" {{ request('filter') == 'mingguan' ? 'selected' : '' }}>Mingguan
                            </option>
                            <option value="bulanan" {{ request('filter') == 'bulanan' ? 'selected' : '' }}>Bulanan</option>
                            <option value="tahunan" {{ request('filter') == 'tahunan' ? 'selected' : '' }}>Tahunan</option>
                        </select>
                    </div>
                    <div class="form-group mx-sm-3 mb-2">
                        <input type="date" name="tanggal" id="tanggal" class="form-control"
                            value="{{ request('tanggal') }}">
                    </div>
                    <button type="submit" class="btn btn-primary mb-2">
                        <i class="fas fa-filter"></i> Filter
                    </button>
                    <a href="{{ route('kasubag.filterresetdatatamu') }}" class="btn btn-outline-secondary mb-2">
                        <i class="fas fa-sync"></i> Reset
                    </a>
                </form>
            </div>

            <!-- Tabel Data -->
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
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif
                        @foreach ($data as $key => $item)
                            <tr>
                                <th scope="row">{{ $key + 1 }}</th>
                                <td>{{ $item->nama }}</td>
                                <td>{{ $item->telepon }}</td>
                                <td>{{ $item->alamat }}</td>
                                <td>{{ $item->email }}</td>
                                <td>{{ $item->keperluan }}</td>
                                <td class="text-center">{{ $item->date }}</td>
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
