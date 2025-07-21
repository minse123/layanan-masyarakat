@extends('admin.app')
@include('sweetalert::alert')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Konfigurasi Jadwal Pelatihan</h6>
            <div>
                <a href="{{ route('report.jadwal-pelatihan', ['jenis_pelatihan' => request('jenis_pelatihan')]) }}"
                    target="_blank" class="btn btn-primary">
                    <i class="fas fa-print"></i> Cetak Jadwal
                </a>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('laporan.jadwal-pelatihan') }}" method="GET" class="mb-3">
                <div class="row">
                    <div class="col-md-4">
                        <select name="jenis_pelatihan" class="form-control" onchange="this.form.submit()">
                            <option value="">Semua Jenis Pelatihan</option>
                            <optgroup label="Pelatihan Inti">
                                <option value="inti_bumdes"
                                    {{ request('jenis_pelatihan') == 'inti_bumdes' ? 'selected' : '' }}>Bumdes</option>
                                <option value="inti_kpmd" {{ request('jenis_pelatihan') == 'inti_kpmd' ? 'selected' : '' }}>
                                    KPMD</option>
                                <option value="inti_masyarakat_hukum_adat"
                                    {{ request('jenis_pelatihan') == 'inti_masyarakat_hukum_adat' ? 'selected' : '' }}>
                                    Masyarakat Hukum Adat</option>
                                <option value="inti_pembangunan_desa_wisata"
                                    {{ request('jenis_pelatihan') == 'inti_pembangunan_desa_wisata' ? 'selected' : '' }}>
                                    Pembangunan Desa Wisata</option>
                                <option value="inti_catrans"
                                    {{ request('jenis_pelatihan') == 'inti_catrans' ? 'selected' : '' }}>Catrans</option>
                                <option value="inti_pelatihan_perencanaan_pembangunan_partisipatif"
                                    {{ request('jenis_pelatihan') == 'inti_pelatihan_perencanaan_pembangunan_partisipatif' ? 'selected' : '' }}>
                                    Pelatihan Perencanaan Pembangunan Partisipatif</option>
                            </optgroup>
                            <optgroup label="Pelatihan Pendukung">
                                <option value="pendukung_prukades"
                                    {{ request('jenis_pelatihan') == 'pendukung_prukades' ? 'selected' : '' }}>Prukades
                                </option>
                                <option value="pendukung_prudes"
                                    {{ request('jenis_pelatihan') == 'pendukung_prudes' ? 'selected' : '' }}>Prudes</option>
                                <option value="pendukung_ecomerce"
                                    {{ request('jenis_pelatihan') == 'pendukung_ecomerce' ? 'selected' : '' }}>E-commerce
                                </option>
                            </optgroup>
                        </select>
                    </div>
                </div>
            </form>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th style="width: 5%;">No.</th>
                            <th>Nama Pelatihan</th>
                            <th>Tanggal Mulai</th>
                            <th>Tanggal Selesai</th>
                            <th>Lokasi</th>
                            <th>Jenis Pelatihan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $key => $item)
                            <tr>
                                <td style="width: 5%;">{{ $key + 1 }}</td>
                                <td>{{ $item->nama_pelatihan }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d M Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->tanggal_selesai)->format('d M Y') }}</td>
                                <td>{{ $item->lokasi }}</td>
                                <td>
                                    @if ($item->pelatihan_inti)
                                        <span
                                            class="badge badge-primary">{{ str_replace('_', ' ', ucwords($item->pelatihan_inti)) }}</span>
                                    @elseif ($item->pelatihan_pendukung)
                                        <span
                                            class="badge badge-info">{{ str_replace('_', ' ', ucwords($item->pelatihan_pendukung)) }}</span>
                                    @endif
                                </td>
                                <td>
                                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                        data-target="#detailModal-{{ $item->id }}">
                                        <i class="fas fa-info-circle"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Detail Modal -->
    <div class="modal fade" id="detailModal-{{ $item->id }}" tabindex="-1" role="dialog"
        aria-labelledby="detailModalLabel-{{ $item->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailModalLabel-{{ $item->id }}">Detail Jadwal Pelatihan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-2">
                                <label>Nama Pelatihan:</label>
                                <p class="mb-1">{{ $item->nama_pelatihan }}</p>
                            </div>
                            <div class="form-group mb-2">
                                <label>Tanggal:</label>
                                <p class="mb-1">
                                    {{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d M Y') }} -
                                    {{ \Carbon\Carbon::parse($item->tanggal_selesai)->format('d M Y') }}
                                </p>
                            </div>
                            <div class="form-group mb-2">
                                <label>Jam:</label>
                                <p class="mb-1">{{ $item->jam_mulai }} - {{ $item->jam_selesai }}</p>
                            </div>
                            <div class="form-group mb-2">
                                <label>File:</label>
                                @if ($item->file_path)
                                    <p class="mb-1"><a
                                            href="{{ route('admin.jadwal-pelatihan.file', ['filename' => $item->file_path]) }}"
                                            target="_blank">Lihat File</a></p>
                                @else
                                    <p class="mb-1">Tidak ada file</p>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-2">
                                <label>Lokasi:</label>
                                <p class="mb-1">{{ $item->lokasi }}</p>
                            </div>
                            <div class="form-group mb-2">
                                <label>Jenis Pelatihan:</label>
                                <p class="mb-1">
                                    @if ($item->pelatihan_inti)
                                        {{ str_replace('_', ' ', ucwords($item->pelatihan_inti)) }} (Inti)
                                    @elseif ($item->pelatihan_pendukung)
                                        {{ str_replace('_', ' ', ucwords($item->pelatihan_pendukung)) }} (Pendukung)
                                    @else
                                        -
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row mt-3">
                        <div class="col-12">
                            <label>Deskripsi:</label>
                            <p>{{ $item->deskripsi }}</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
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

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
