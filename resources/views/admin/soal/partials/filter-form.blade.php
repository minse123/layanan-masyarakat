<form method="GET" action="{{ $route }}" class="form-inline">
    <div class="form-group mr-2">
        <label for="kategori" class="mr-2">Kategori Soal:</label>
        <select name="kategori" id="kategori" class="form-control">
            <option value="">Semua Kategori</option>
            @foreach($kategoriList as $kategori)
                <option value="{{ $kategori->id }}" {{ $selectedKategori == $kategori->id ? 'selected' : '' }}>
                    {{ $kategori->nama_kategori }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="form-group mr-2">
        <label for="limit" class="mr-2">Jumlah Data:</label>
        <select name="limit" id="limit" class="form-control">
            <option value="10" {{ $limit == 10 ? 'selected' : '' }}>10</option>
            <option value="25" {{ $limit == 25 ? 'selected' : '' }}>25</option>
            <option value="50" {{ $limit == 50 ? 'selected' : '' }}>50</option>
            <option value="100" {{ $limit == 100 ? 'selected' : '' }}>100</option>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Filter</button>
</form>
