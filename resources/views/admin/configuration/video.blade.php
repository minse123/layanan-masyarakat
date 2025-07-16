@extends('admin.app')
@include('sweetalert::alert')
@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Konfigurasi Video Pelatihan</h6>
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#tambahVideoModal">
                <i class="fas fa-plus"></i> Tambah Video
            </button>
            <a href="{{ route('admin.video.print_report', ['jenis_pelatihan' => request('jenis_pelatihan')]) }}" class="btn btn-info" target="_blank">
                <i class="fas fa-print"></i> Cetak Laporan
            </a>
        </div>
        <div class="card-body">
            {{-- Filter --}}
            <div class="row mb-3">
                <div class="col-md-4">
                    <form action="{{ route('admin.video.index') }}" method="GET">
                        <div class="input-group">
                            <select name="jenis_pelatihan" class="form-control">
                                <option value="">Semua Jenis</option>
                                <option value="inti" {{ request('jenis_pelatihan') == 'inti' ? 'selected' : '' }}>Inti</option>
                                <option value="pendukung" {{ request('jenis_pelatihan') == 'pendukung' ? 'selected' : '' }}>Pendukung</option>
                            </select>
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">Filter</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            {{-- Tabel Data --}}
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th style="width: 5%;">No.</th>
                            <th>Judul</th>
                            <th>Jenis Pelatihan</th>
                            <th>Ditampilkan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($videos as $key => $video)
                            <tr>
                                <td style="width: 5%;">{{ $key + 1 }}</td>
                                <td>{{ $video->judul }}</td>
                                <td>
                                    @if ($video->jenis_pelatihan == 'inti')
                                        <span class="badge badge-primary">Inti</span>
                                    @else
                                        <span class="badge badge-secondary">Pendukung</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($video->ditampilkan)
                                        <span class="badge badge-success">Ya</span>
                                    @else
                                        <span class="badge badge-secondary">Tidak</span>
                                    @endif
                                </td>
                                <td>
                                    <!-- Tombol Detail -->
                                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                        data-target="#detailVideoModal{{ $video->id }}">
                                        <i class="fas fa-info-circle"></i>
                                    </button>
                                    <!-- Tombol Edit -->
                                    <button type="button" class="btn btn-warning btn-sm" data-toggle="modal"
                                        data-target="#editVideoModal{{ $video->id }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <!-- Tombol Hapus -->
                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                        data-target="#deleteVideoModal{{ $video->id }}">
                                        <i class="fas fa-trash"></i>
                                    </button>

                                    <!-- Modal Konfirmasi Hapus -->
                                    <div class="modal fade" id="deleteVideoModal{{ $video->id }}" tabindex="-1"
                                        role="dialog" aria-labelledby="deleteVideoModalLabel{{ $video->id }}"
                                        aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <form action="{{ route('admin.video.destroy', $video->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title"
                                                            id="deleteVideoModalLabel{{ $video->id }}">Konfirmasi
                                                            Hapus</h5>
                                                        <button type="button" class="close text-white" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Apakah Anda yakin ingin menghapus video
                                                        <strong>{{ $video->judul }}</strong>?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-danger">Hapus</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                            <!-- Modal Detail Video -->
                            <div class="modal fade" id="detailVideoModal{{ $video->id }}" tabindex="-1" role="dialog"
                                aria-labelledby="detailVideoModalLabel{{ $video->id }}" aria-hidden="true"
                                data-video-id="{{ $video->youtube_id }}">
                                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="detailVideoModalLabel{{ $video->id }}">Detail
                                                Video</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body" style="max-height:70vh;overflow-y:auto;">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group mb-2">
                                                        <label>Judul:</label>
                                                        <p class="mb-1">{{ $video->judul }}</p>
                                                    </div>
                                                    <div class="form-group mb-2">
                                                        <label>Jenis Pelatihan:</label>
                                                        <p class="mb-1">
                                                            {{ $video->jenis_pelatihan == 'inti' ? 'Inti' : 'Pendukung' }}
                                                        </p>
                                                    </div>
                                                    <div class="form-group mb-2">
                                                        <label>Deskripsi:</label>
                                                        <p class="mb-1">{{ $video->deskripsi }}</p>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group mb-2">
                                                        <label>Ditampilkan:</label>
                                                        <p class="mb-1">
                                                            {{ $video->ditampilkan ? 'Ya' : 'Tidak' }}
                                                        </p>
                                                    </div>
                                                    <div class="form-group mb-2">
                                                        <label>Link YouTube:</label>
                                                        <p class="mb-1">
                                                            <a href="https://www.youtube.com/watch?v={{ $video->youtube_id }}"
                                                                target="_blank">
                                                                https://www.youtube.com/watch?v={{ $video->youtube_id }}
                                                            </a>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row mt-3">
                                                <div class="col-12 text-center">
                                                    <iframe width="100%" height="315" src="" frameborder="0"
                                                        allowfullscreen id="videoFrame{{ $video->id }}"></iframe>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Tutup</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal Edit Video -->
                            <div class="modal fade" id="editVideoModal{{ $video->id }}" tabindex="-1"
                                role="dialog" aria-labelledby="editVideoModalLabel{{ $video->id }}"
                                aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                    <form action="{{ route('admin.video.update', $video->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editVideoModalLabel{{ $video->id }}">Edit
                                                    Video Pelatihan</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body" style="max-height:70vh;overflow-y:auto;">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Judul Video</label>
                                                            <input type="text" name="judul" class="form-control"
                                                                value="{{ $video->judul }}" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Link YouTube</label>
                                                            <input type="text" name="youtube_id" class="form-control"
                                                                value="{{ $video->youtube_id }}" required>
                                                            <small class="text-muted">Masukkan link lengkap atau hanya ID video
                                                                YouTube.</small>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Deskripsi</label>
                                                            <textarea name="deskripsi" class="form-control" rows="2">{{ $video->deskripsi }}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Jenis Pelatihan</label>
                                                            <select name="jenis_pelatihan" class="form-control" required>
                                                                <option value="inti"
                                                                    {{ $video->jenis_pelatihan == 'inti' ? 'selected' : '' }}>Inti
                                                                </option>
                                                                <option value="pendukung"
                                                                    {{ $video->jenis_pelatihan == 'pendukung' ? 'selected' : '' }}>
                                                                    Pendukung</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Ditampilkan</label>
                                                            <select name="ditampilkan" class="form-control">
                                                                <option value="1"
                                                                    {{ $video->ditampilkan ? 'selected' : '' }}>
                                                                    Ya</option>
                                                                <option value="0"
                                                                    {{ !$video->ditampilkan ? 'selected' : '' }}>Tidak</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-primary">Simpan</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Video -->
    <div class="modal fade" id="tambahVideoModal" tabindex="-1" role="dialog" aria-labelledby="tambahVideoModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="{{ route('admin.video.store') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="tambahVideoModalLabel">Tambah Video Pelatihan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Judul Video</label>
                            <input type="text" name="judul" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Link YouTube</label>
                            <input type="text" name="youtube_id" class="form-control"
                                placeholder="https://www.youtube.com/watch?v=VIDEO_ID" required>
                            <small class="text-muted">Masukkan link lengkap atau hanya ID video YouTube.</small>
                        </div>
                        <div class="form-group">
                            <label>Deskripsi</label>
                            <textarea name="deskripsi" class="form-control" rows="2"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Jenis Pelatihan</label>
                            <select name="jenis_pelatihan" class="form-control" required>
                                <option value="inti" selected>Inti</option>
                                <option value="pendukung">Pendukung</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Ditampilkan</label>
                            <select name="ditampilkan" class="form-control">
                                <option value="1" selected>Ya</option>
                                <option value="0">Tidak</option>
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
@endsection

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @section('script')
        <script>
            $(document).ready(function() {
                $('#dataTable').DataTable();

                // Handle the 'show' event for the detail modal
                $('[id^="detailVideoModal"]').on('show.bs.modal', function(event) {
                    var modal = $(this);
                    var youtubeId = modal.data('video-id');
                    if (youtubeId) {
                        var videoUrl = 'https://www.youtube.com/embed/' + youtubeId + '?autoplay=1';
                        modal.find('iframe').attr('src', videoUrl);
                    }
                });

                // Handle the 'hidden' event for the detail modal to stop the video
                $('[id^="detailVideoModal"]').on('hidden.bs.modal', function(event) {
                    var modal = $(this);
                    modal.find('iframe').attr('src', '');
                });
            });
        </script>
    @endsection