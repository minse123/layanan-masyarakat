<div class="modal fade" id="modalImportSoal" tabindex="-1" role="dialog" aria-labelledby="modalImportSoalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{ route('admin.soal-pelatihan.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalImportSoalLabel">Import Soal dari Excel</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="file_excel">Pilih File Excel</label>
                        <input type="file" name="file_excel" id="file_excel" class="form-control-file" required accept=".xls,.xlsx">
                        <small class="form-text text-muted">Pastikan format file Excel sesuai dengan contoh: <a href="{{ asset('excel/contoh_soal.xlsx') }}" target="_blank">contoh_soal.xlsx</a></small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Import</button>
                </div>
            </div>
        </form>
    </div>
</div>