@extends($layout)
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Verifikasi Akun Masyarakat</h3>
                    <p class="text-subtitle text-muted">Daftar akun masyarakat yang perlu diverifikasi.</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Verifikasi Akun Masyarakat</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Daftar Akun Masyarakat</h4>
                </div>
                <div class="card-body">
                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Telepon</th>
                                <th>NIK</th>
                                <th>Alamat</th>
                                <th>Status Verifikasi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($masyarakatUsers as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->telepon }}</td>
                                    <td>{{ $user->nik }}</td>
                                    <td>{{ $user->alamat }}</td>
                                    <td>
                                        @if ($user->status_verifikasi == 'terverifikasi')
                                            <span class="badge bg-success">Terverifikasi</span>
                                        @elseif ($user->status_verifikasi == 'ditolak')
                                            <span class="badge bg-danger">Ditolak</span>
                                        @else
                                            <span class="badge bg-warning">Belum Verifikasi</span>
                                        @endif
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editUserModal{{ $user->id }}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        @if ($user->status_verifikasi == 'belum_verifikasi')
                                            <form action="{{ route('admin.verifikasi-masyarakat.verifikasi', $user->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm">Verifikasi</button>
                                            </form>
                                            <form action="{{ route('admin.verifikasi-masyarakat.tolak', $user->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-danger btn-sm">Tolak</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>

                                <!-- Edit User Modal -->
                                <div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel{{ $user->id }}" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editUserModalLabel{{ $user->id }}">Edit Data Masyarakat</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="{{ route('admin.verifikasi-masyarakat.update', $user->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label for="name{{ $user->id }}">Nama</label>
                                                        <input type="text" class="form-control" id="name{{ $user->id }}" name="name" value="{{ $user->name }}" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="email{{ $user->id }}">Email</label>
                                                        <input type="email" class="form-control" id="email{{ $user->id }}" name="email" value="{{ $user->email }}" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="telepon{{ $user->id }}">Telepon</label>
                                                        <input type="text" class="form-control" id="telepon{{ $user->id }}" name="telepon" value="{{ $user->telepon }}" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="nik{{ $user->id }}">NIK</label>
                                                        <input type="text" class="form-control" id="nik{{ $user->id }}" name="nik" value="{{ $user->nik }}" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="alamat{{ $user->id }}">Alamat</label>
                                                        <textarea class="form-control" id="alamat{{ $user->id }}" name="alamat" required>{{ $user->alamat }}</textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="status_verifikasi{{ $user->id }}">Status Verifikasi</label>
                                                        <select class="form-control" id="status_verifikasi{{ $user->id }}" name="status_verifikasi">
                                                            <option value="belum_verifikasi" {{ $user->status_verifikasi == 'belum_verifikasi' ? 'selected' : '' }}>Belum Verifikasi</option>
                                                            <option value="terverifikasi" {{ $user->status_verifikasi == 'terverifikasi' ? 'selected' : '' }}>Terverifikasi</option>
                                                            <option value="ditolak" {{ $user->status_verifikasi == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
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
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
@endsection