@extends($layout)
@include('sweetalert::alert')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Statistik Soal Tersulit</h1>

    <!-- Filter Form -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Filter Statistik</h6>
        </div>
        <div class="card-body">
            @include('admin.soal.partials.filter-form', [
                'route' => route('admin.statistik-soal.index'),
                'kategoriList' => $kategoriList,
                'selectedKategori' => $selectedKategori,
                'limit' => $limit
            ])
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Soal Berdasarkan Tingkat Kesulitan</h6>
            <a href="{{ route('statistik-tersulit.cetak-pdf') }}" class="btn btn-info btn-sm">Cetak PDF</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th>No</th>
                            <th>Soal</th>
                            <th>Kategori</th>
                            <th>Total Jawaban</th>
                            <th>Jawaban Salah</th>
                            <th>Persentase Kesalahan</th>
                            <th>Detail</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($soalTersulit as $index => $soal)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{!! Str::limit(strip_tags($soal->pertanyaan), 100) !!}</td>
                                <td>{{ $soal->nama_kategori }}</td>
                                <td class="text-center">{{ $soal->total_jawaban }}</td>
                                <td class="text-center">{{ $soal->total_salah }}</td>
                                <td>
                                    @include('admin.soal.partials.progress-bar', [
                                        'persentase' => $soal->persentase_salah,
                                        'showValue' => true
                                    ])
                                </td>
                                <td class="text-center">
                                    @include('admin.soal.partials.edit-button', ['soal' => $soal])
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Tidak ada data soal</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@include('admin.soal.modals.edit-soal')
@endsection

@push('scripts')
<script src="{{ asset('backend/js/soal-edit.js') }}"></script>
<script>
    $(document).ready(function() {
        // Handle edit button click
        $('.edit-soal').on('click', function() {
            var id = $(this).data('id');
            var formAction = '{{ route('admin.soal-pelatihan.update', '') }}' + '/' + id;

            // Set form action
            $('#editSoalForm').attr('action', formAction);

            // Fill form with data
            $('textarea[name="pertanyaan"]').val($(this).data('pertanyaan'));
            $('select[name="id_kategori_soal_pelatihan"]').val($(this).data('kategori'));
            $('input[name="pilihan_a"]').val($(this).data('pilihan_a'));
            $('input[name="pilihan_b"]').val($(this).data('pilihan_b'));
            $('input[name="pilihan_c"]').val($(this).data('pilihan_c'));
            $('input[name="pilihan_d"]').val($(this).data('pilihan_d'));
            $('select[name="jawaban_benar"]').val($(this).data('jawaban_benar'));
        });

        // Handle form submission
        $('#editSoalForm').on('submit', function(e) {
            e.preventDefault();
            var form = $(this);
            var formData = form.serialize();

            $.ajax({
                url: form.attr('action'),
                type: 'POST',
                data: formData,
                success: function(response) {
                    if (response.success) {
                        $('#editSoalModal').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: 'Soal berhasil diperbarui',
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => {
                            location.reload();
                        });
                    }
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Terjadi kesalahan saat memperbarui soal'
                    });
                }
            });
        });
    });
</script>
@endpush