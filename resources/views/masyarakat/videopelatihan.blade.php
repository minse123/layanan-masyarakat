@extends('masyarakat.app')

@section('content')
    <div style="background-color: black; height: 100px;"></div>
    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-12 mx-auto text-center">
                    <h1 class="text-black mb-3">Video Pelatihan</h1>
                    <p class="lead text-muted">Tingkatkan keahlian Anda dengan berbagai video pelatihan kami.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="pb-5">
        <div class="container">
            <div class="row mb-4">
                <div class="col-lg-8 col-12 mx-auto">
                    <form action="{{ route('masyarakat.videopelatihan') }}" method="GET">
                        <div class="input-group mb-3">
                            <select class="form-select" name="jenis_pelatihan" onchange="this.form.submit()">
                                <option value="">Semua Jenis Pelatihan</option>
                                <option value="inti" {{ request('jenis_pelatihan') == 'inti' ? 'selected' : '' }}>Inti</option>
                                <option value="pendukung" {{ request('jenis_pelatihan') == 'pendukung' ? 'selected' : '' }}>Pendukung</option>
                            </select>
                        </div>
                    </form>
                </div>
            </div>

            <div class="row">
                @forelse ($videos as $video)
                    <div class="col-lg-4 col-md-6 col-12 mb-4">
                        <div class="card h-100 shadow-sm border-0 rounded-lg" data-bs-toggle="modal" data-bs-target="#videoModal-{{ $video->id }}" style="cursor: pointer;">
                            <div class="video-thumbnail-container">
                                <img src="https://img.youtube.com/vi/{{ $video->youtube_id }}/hqdefault.jpg" class="card-img-top rounded-top" alt="{{ $video->judul }}" style="height: 200px; object-fit: cover;">
                                <div class="play-button-overlay">
                                    <i class="bi bi-play-circle-fill"></i>
                                </div>
                            </div>
                            <div class="card-body">
                                <span class="badge {{ $video->jenis_pelatihan == 'inti' ? 'bg-primary' : 'bg-info' }} mb-2">
                                    {{ ucfirst($video->jenis_pelatihan) }}
                                </span>
                                <h5 class="card-title text-truncate">{{ $video->judul }}</h5>
                                <p class="card-text text-muted">{{ Str::limit($video->deskripsi, 100) }}</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <p class="text-center">Tidak ada video pelatihan ditemukan.</p>
                    </div>
                @endforelse
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $videos->withQueryString()->links() }}
            </div>
        </div>
    </section>

    @foreach ($videos as $video)
        <!-- Video Modal -->
        <div class="modal fade" id="videoModal-{{ $video->id }}" tabindex="-1" aria-labelledby="videoModalLabel-{{ $video->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="videoModalLabel-{{ $video->id }}">{{ $video->judul }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="embed-responsive embed-responsive-16by9">
                            <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/{{ $video->youtube_id }}" allowfullscreen style="width: 100%; height: 400px;"></iframe>
                        </div>
                        <p class="mt-3">{{ $video->deskripsi }}</p>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection

@push('styles')
<style>
    .video-thumbnail-container {
        position: relative;
        width: 100%;
        padding-top: 56.25%; /* 16:9 Aspect Ratio */
        overflow: hidden;
    }

    .video-thumbnail-container img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .play-button-overlay {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 3rem;
        color: white;
        opacity: 0.8;
        transition: opacity 0.3s ease;
    }

    .card:hover .play-button-overlay {
        opacity: 1;
    }
</style>
@endpush