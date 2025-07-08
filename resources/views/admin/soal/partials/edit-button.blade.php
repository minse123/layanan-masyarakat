@props(['soal'])

<button type="button" 
        class="btn btn-sm btn-info edit-soal" 
        data-toggle="modal" 
        data-target="#editSoalModal"
        data-id="{{ $soal->id }}"
        data-pertanyaan="{{ $soal->pertanyaan }}"
        data-kategori="{{ $soal->id_kategori_soal_pelatihan }}"
        data-pilihan_a="{{ $soal->pilihan_a }}"
        data-pilihan_b="{{ $soal->pilihan_b }}"
        data-pilihan_c="{{ $soal->pilihan_c }}"
        data-pilihan_d="{{ $soal->pilihan_d }}"
        data-jawaban_benar="{{ $soal->jawaban_benar }}"
        title="Edit Soal">
    <i class="fas fa-edit"></i>
</button>
