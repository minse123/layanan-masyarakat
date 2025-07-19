@extends('masyarakat.app')

@section('content')
    <div style="background-color: black; height: 100px;"></div>

    <div class="container-fluid" style="padding-top: 100px;">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Hasil Latihan Soal</h1>
            <a href="{{ route('masyarakat.dashboard') }}#section_2"
                class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
                <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
            </a>
        </div>

        <!-- Content Row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Filter Hasil Latihan</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('masyarakat.soal.hasil') }}" method="GET"
                            class="row g-3 align-items-center">
                            <div class="col-md-4">
                                <label for="jenis_pelatihan" class="form-label mb-0">Filter Jenis Pelatihan:</label>
                            </div>
                            <div class="col-md-6">
                                <select class="form-select" id="jenis_pelatihan" name="jenis_pelatihan"
                                    onchange="this.form.submit()">
                                    <option value="">Semua Jenis Pelatihan</option>
                                    @foreach ($jenisPelatihan as $jenis)
                                        <option value="{{ $jenis->id }}"
                                            {{ request('jenis_pelatihan') == $jenis->id ? 'selected' : '' }}>
                                            {{ $jenis->nama_kategori }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary w-100">Filter</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Detail Hasil Latihan:
                            {{ $kategori->nama_kategori ?? 'Semua Kategori' }}</h6>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th width="35%">Pertanyaan</th>
                                        <th width="20%">Jawaban Kamu</th>
                                        <th width="20%">Jawaban Benar</th>
                                        <th width="10%">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $counter = 1; @endphp
                                    @foreach ($jawabanPeserta as $jawaban)
                                        @php
                                            $soal = $jawaban->soal;
                                            $options = [
                                                'a' => $soal->pilihan_a ?? 'Tidak ada pilihan',
                                                'b' => $soal->pilihan_b ?? 'Tidak ada pilihan',
                                                'c' => $soal->pilihan_c ?? 'Tidak ada pilihan',
                                                'd' => $soal->pilihan_d ?? 'Tidak ada pilihan',
                                            ];

                                            $userAnswer = strtolower(trim($jawaban->jawaban_peserta));
                                            $correctAnswer = strtolower(trim($soal->jawaban_benar));
                                        @endphp

                                        <tr>
                                            <td>{{ $counter++ }}</td>
                                            <td>{{ $soal->pertanyaan }}</td>
                                            <td>
                                                @if (array_key_exists($userAnswer, $options))
                                                    <strong>({{ strtoupper($userAnswer) }})</strong>
                                                    {{ $options[$userAnswer] }}
                                                @else
                                                    <span class="text-danger">Jawaban tidak valid</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if (array_key_exists($correctAnswer, $options))
                                                    <strong>({{ strtoupper($correctAnswer) }})</strong>
                                                    {{ $options[$correctAnswer] }}
                                                @else
                                                    <span class="text-danger">Kunci jawaban tidak valid</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($jawaban->is_correct)
                                                    <span class="badge bg-success">Benar</span>
                                                @else
                                                    <span class="badge bg-danger">Salah</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>


                        <div class="mt-4 text-right">
                            <h4>Total Skor: <strong class="text-primary">{{ $skor }}</strong> dari
                                {{ $totalSoal }} soal</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

{{-- @push('scripts')
    <!-- Page level plugins -->
    <script src="{{ asset('backend/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('backend/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('backend/js/demo/datatables-demo.js') }}"></script>
@endpush

@push('styles')
    <link href="{{ asset('backend/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush --}}
