<div class="modal fade" id="modalCetakHasil" tabindex="-1" role="dialog" aria-labelledby="modalCetakHasilLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{ route('hasil-pelatihan.cetak-pdf') }}" method="GET" target="_blank">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCetakHasilLabel">Cetak Hasil Peserta</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="user_id">Pilih Peserta:</label>
                        <select name="user_id" id="user_id" class="form-control" required>
                            <option value="">-- Pilih Peserta --</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="kategori_id">Pilih Kategori Pelatihan:</label>
                        <select name="kategori_id" id="kategori_id" class="form-control" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach ($kategoriList as $kategori)
                                <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }} ({{ ucfirst($kategori->tipe) }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-print"></i> Cetak Hasil</button>
                </div>
            </div>
        </form>
    </div>
</div>
