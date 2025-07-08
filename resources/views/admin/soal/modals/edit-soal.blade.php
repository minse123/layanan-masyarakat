<!-- Modal Edit Soal -->
<div class="modal fade" id="editSoalModal" tabindex="-1" role="dialog" aria-labelledby="editSoalModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editSoalModalLabel">Edit Soal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editSoalForm" method="POST" action="">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label>Pertanyaan</label>
                        <textarea name="pertanyaan" class="form-control" rows="3" required></textarea>
                    </div>
                    <div class="form-group">
                        <label>Kategori</label>
                        <select name="id_kategori_soal_pelatihan" class="form-control" required>
                            @foreach($kategoriList as $kategori)
                                <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Pilihan A</label>
                        <input type="text" name="pilihan_a" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Pilihan B</label>
                        <input type="text" name="pilihan_b" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Pilihan C</label>
                        <input type="text" name="pilihan_c" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Pilihan D</label>
                        <input type="text" name="pilihan_d" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Jawaban Benar</label>
                        <select name="jawaban_benar" class="form-control" required>
                            <option value="a">A</option>
                            <option value="b">B</option>
                            <option value="c">C</option>
                            <option value="d">D</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
