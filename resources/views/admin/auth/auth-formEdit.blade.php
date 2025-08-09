@extends($layout)
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Edit Akun Pengguna</h3>
                    <p class="text-subtitle text-muted">Formulir untuk mengedit akun pengguna.</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ url('admin/auth') }}">Data Akun Pengguna</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Akun</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Edit Akun: {{ $user->name }}</h4>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <form method="POST" action="{{ route('admin.auth.update', $user->id) }}">
                        @csrf
                        <div class="form-group">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="name" name="name"
                                value="{{ $user->name }}" required>
                        </div>

                        <div class="form-group">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email"
                                value="{{ $user->email }}" required>
                        </div>

                        <div class="form-group">
                            <label for="telepon" class="form-label">Telepon</label>
                            <input type="text" class="form-control" id="telepon" name="telepon"
                                value="{{ $user->telepon }}" required>
                        </div>

                        <div class="form-group">
                            <label for="nik" class="form-label">NIK</label>
                            <input type="text" class="form-control" id="nik" name="nik"
                                value="{{ $user->nik }}" required>
                        </div>

                        <div class="form-group">
                            <label for="alamat" class="form-label">Alamat</label>
                            <textarea class="form-control" id="alamat" name="alamat" rows="3" required>{{ $user->alamat }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="role" class="font-weight-bold">Role <span class="text-danger">*</span></label>
                            <select class="form-control" id="role" name="role" required>
                                <option value="" disabled {{ !$user->role ? 'selected' : '' }}>-- Pilih Role --
                                </option>
                                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="operator" {{ $user->role == 'operator' ? 'selected' : '' }}>Operator
                                </option>
                                <option value="psm" {{ $user->role == 'psm' ? 'selected' : '' }}>PSM</option>
                                <option value="kasubag" {{ $user->role == 'kasubag' ? 'selected' : '' }}>Kasubag</option>
                                <option value="masyarakat" {{ $user->role == 'masyarakat' ? 'selected' : '' }}>Masyarakat
                                </option>
                            </select>
                            <small class="form-text text-muted">
                                Pilih peran pengguna sesuai tugasnya.
                            </small>
                        </div>

                        <div class="form-group">
                            <label for="current_password" class="font-weight-bold">
                                Password Lama
                            </label>
                            <input type="password" class="form-control" id="current_password" name="current_password"
                                autocomplete="current-password" placeholder="Masukkan password lama">
                            <small class="form-text text-muted">
                                Kosongkan jika tidak ingin mengubah password. Isi hanya jika ingin mengubah password.
                            </small>
                        </div>
                        <div class="form-group">
                            <label for="password" class="font-weight-bold">
                                Password Baru
                            </label>
                            <input type="password" class="form-control" id="password" name="password"
                                autocomplete="new-password" placeholder="Password baru">
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </form>
                </div>
            </div>
        </section>
    </div>
    @include('sweetalert::alert')
@endsection
