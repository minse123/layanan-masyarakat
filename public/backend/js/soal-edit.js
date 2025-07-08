// Handle edit button click
$(document).on('click', '.edit-soal', function() {
    var $button = $(this);
    var id = $button.data('id');
    var formAction = $button.closest('form').attr('action') || '';
    
    if (!formAction) {
        // If no form action found, construct it from route
        var baseUrl = window.location.origin;
        formAction = baseUrl + '/admin/soal-pelatihan/' + id;
    }
    
    // Set form action
    $('#editSoalForm').attr('action', formAction);
    
    // Fill form with data
    var form = $('#editSoalForm');
    form.find('textarea[name="pertanyaan"]').val($button.data('pertanyaan'));
    form.find('select[name="id_kategori_soal_pelatihan"]').val($button.data('kategori'));
    form.find('input[name="pilihan_a"]').val($button.data('pilihan_a'));
    form.find('input[name="pilihan_b"]').val($button.data('pilihan_b'));
    form.find('input[name="pilihan_c"]').val($button.data('pilihan_c'));
    form.find('input[name="pilihan_d"]').val($button.data('pilihan_d'));
    form.find('select[name="jawaban_benar"]').val($button.data('jawaban_benar'));
});

// Handle form submission
$(document).on('submit', '#editSoalForm', function(e) {
    e.preventDefault();
    var form = $(this);
    var formData = form.serialize();
    
    $.ajax({
        url: form.attr('action'),
        type: 'POST',
        data: formData,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if(response.success) {
                $('#editSoalModal').modal('hide');
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: 'Soal berhasil diperbarui',
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    window.location.reload();
                });
            }
        },
        error: function(xhr) {
            var errorMessage = 'Terjadi kesalahan saat memperbarui soal';
            if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMessage = xhr.responseJSON.message;
            }
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: errorMessage
            });
        }
    });
});
