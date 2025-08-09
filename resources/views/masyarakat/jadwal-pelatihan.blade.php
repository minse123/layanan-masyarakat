@extends('masyarakat.app')

@section('content')
    <div style="background-color: black; height: 100px;"></div>
    <section class="py-4">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-12 mx-auto text-center">
                    <h1 class="text-black mb-3">Jadwal Pelatihan</h1>
                    <p class="lead text-muted">Ikuti pelatihan kami untuk meningkatkan keahlian Anda.</p>
                </div>
            </div>
        </div>
    </section>
    <section class="pb-5">
        <div class="container">
            <div class="row mb-4">
                <div class="col-lg-8 col-12 mx-auto">
                    <form action="{{ route('jadwal-pelatihan') }}" method="GET">
                        <div class="input-group mb-3">
                            <select class="form-select" name="jenis_pelatihan">
                                <option value="">Semua Jenis Pelatihan</option>
                                <option value="pelatihan_inti" {{ request('jenis_pelatihan') == 'pelatihan_inti' ? 'selected' : '' }}>Pelatihan Inti</option>
                                <option value="pelatihan_pendukung" {{ request('jenis_pelatihan') == 'pelatihan_pendukung' ? 'selected' : '' }}>Pelatihan Pendukung</option>
                            </select>
                            <input type="text" class="form-control" name="search" placeholder="Cari pelatihan..."
                                value="{{ request('search') }}">
                            <button class="btn btn-primary" type="submit">Cari</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="row">
                @forelse ($data as $jadwal)
                    <div class="col-lg-4 col-md-6 col-12 mb-4">
                        <div class="card h-100 shadow-sm border-0 rounded-lg" data-bs-toggle="modal" data-bs-target="#detailModal-{{ $jadwal->id }}" style="cursor: pointer;">
                            <img src="{{ $jadwal->file_path ? asset('storage/' . $jadwal->file_path) : asset('frontend/images/logo-kementerian.png') }}"
                                class="card-img-top rounded-top" alt="..." style="height: 200px; object-fit: cover;">
                            <div class="card-body">
                                <h5 class="card-title text-truncate">{{ $jadwal->nama_pelatihan }}</h5>
                                <div class="my-2">
                                    @if ($jadwal->pelatihan_inti)
                                        <span class="badge bg-primary">{{ str_replace('_', ' ', ucwords($jadwal->pelatihan_inti)) }}</span>
                                    @elseif ($jadwal->pelatihan_pendukung)
                                        <span class="badge bg-info">{{ str_replace('_', ' ', ucwords($jadwal->pelatihan_pendukung)) }}</span>
                                    @endif
                                </div>
                                <p class="card-text text-muted"><small>
                                        <i class="bi bi-calendar me-1"></i>{{ \Carbon\Carbon::parse($jadwal->tanggal_mulai)->format('d M Y') }}
                                        - {{ \Carbon\Carbon::parse($jadwal->tanggal_selesai)->format('d M Y') }}</small></p>
                                <p class="card-text">{{ Str::limit($jadwal->deskripsi, 100) }}</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <p class="text-center">Belum ada jadwal pelatihan yang tersedia.</p>
                    </div>
                @endforelse
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $data->links() }}
            </div>
        </div>
    </section>

    @foreach ($data as $item)
        <!-- Detail Modal -->
        <div class="modal fade" id="detailModal-{{ $item->id }}" tabindex="-1" role="dialog"
            aria-labelledby="detailModalLabel-{{ $item->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="detailModalLabel-{{ $item->id }}">Detail Jadwal Pelatihan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <img src="{{ $item->file_path ? asset('storage/' . $item->file_path) : asset('frontend/images/logo-kementerian.png') }}" class="img-fluid rounded mb-4" alt="..." style="max-height: 350px; width: 100%; object-fit: cover;">
                        <h4 class="mb-3 text-primary">{{ $item->nama_pelatihan }}</h4>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <p class="mb-1"><i class="bi bi-calendar me-2"></i><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d M Y') }} - {{ \Carbon\Carbon::parse($item->tanggal_selesai)->format('d M Y') }}</p>
                                <p class="mb-1"><i class="bi bi-clock me-2"></i><strong>Jam:</strong> {{ $item->jam_mulai }} - {{ $item->jam_selesai }}</p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-1"><i class="bi bi-geo-alt me-2"></i><strong>Lokasi:</strong> {{ $item->lokasi }}</p>
                                <p class="mb-1"><strong>Jenis Pelatihan:</strong>
                                    @if ($item->pelatihan_inti)
                                        <span class="badge bg-primary">{{ str_replace('_', ' ', ucwords($item->pelatihan_inti)) }}</span>
                                    @elseif ($item->pelatihan_pendukung)
                                        <span class="badge bg-info">{{ str_replace('_', ' ', ucwords($item->pelatihan_pendukung)) }}</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                        <hr class="my-4">
                        <h5 class="mb-3">Deskripsi:</h5>
                        <p>{{ $item->deskripsi }}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
