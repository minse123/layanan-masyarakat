<!-- Modal Cetak Soal -->
<div class="modal fade" id="modalCetakSoal" tabindex="-1" role="dialog" aria-labelledby="modalCetakSoalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{ route('soal-pelatihan.cetak-pdf') }}" method="GET" target="_blank">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCetakSoalLabel">Cetak Soal per Kategori</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Pilih Kategori (bisa pilih lebih dari satu):</label>
                        <select name="kategori_ids[]" class="form-control" multiple required size="8">
                            @foreach ($kategoriList as $kategori)
                                <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }} ({{ ucfirst($kategori->tipe) }})</option>
                            @endforeach
                        </select>
                        <small class="form-text text-muted">Gunakan Ctrl/Cmd + klik untuk memilih beberapa kategori.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-print"></i> Cetak</button>
                </div>
            </div>
        </form>
    </div>
</div>
