<div class="modal fade" id="modalTambahSoal" tabindex="-1" role="dialog" aria-labelledby="modalTambahSoalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="{{ route('admin.soal-pelatihan.store') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTambahSoalLabel">Tambah Soal</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Kategori</label>
                            <select name="id_kategori_soal_pelatihan" class="form-control" required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach ($kategoriList as $kategori)
                                    <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}
                                        ({{ ucfirst($kategori->tipe) }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Pertanyaan</label>
                            <textarea name="pertanyaan" class="form-control" required></textarea>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Pilihan A</label>
                                <input type="text" name="pilihan_a" class="form-control" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Pilihan B</label>
                                <input type="text" name="pilihan_b" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Pilihan C</label>
                                <input type="text" name="pilihan_c" class="form-control" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Pilihan D</label>
                                <input type="text" name="pilihan_d" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Jawaban Benar</label>
                            <select name="jawaban_benar" class="form-control" required>
                                <option value="">-- Pilih Jawaban --</option>
                                <option value="a">A</option>
                                <option value="b">B</option>
                                <option value="c">C</option>
                                <option value="d">D</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>