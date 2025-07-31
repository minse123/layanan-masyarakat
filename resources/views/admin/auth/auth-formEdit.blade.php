@extends($layout)

@section('content')
    <div class="container">
        <h2>Edit Akun</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Form Edit Pengguna</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.auth.update', $user->id) }}">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}"
                            required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}"
                            required>
                    </div>

                    <div class="mb-3">
                        <label for="telepon" class="form-label">Telepon</label>
                        <input type="text" class="form-control" id="telepon" name="telepon"
                            value="{{ $user->telepon }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="nik" class="form-label">NIK</label>
                        <input type="text" class="form-control" id="nik" name="nik" value="{{ $user->nik }}"
                            required>
                    </div>

                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea class="form-control" id="alamat" name="alamat" rows="3" required>{{ $user->alamat }}</textarea>
                    </div>

                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Pilih Role Pengguna</h6>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="role" class="font-weight-bold">Role <span class="text-danger">*</span></label>
                                <select class="form-control" id="role" name="role" required>
                                    <option value="" disabled {{ !$user->role ? 'selected' : '' }}>-- Pilih Role --
                                    </option>
                                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="operator" {{ $user->role == 'operator' ? 'selected' : '' }}>Operator
                                    </option>
                                    <option value="psm" {{ $user->role == 'psm' ? 'selected' : '' }}>PSM</option>
                                    <option value="masyarakat" {{ $user->role == 'masyarakat' ? 'selected' : '' }}>Masyarakat
                                    </option>
                                </select>
                                <small class="form-text text-muted">
                                    Pilih peran pengguna sesuai tugasnya.
                                </small>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="current_password" class="font-weight-bold">
                            Password Lama <span class="text-danger">*</span>
                        </label>
                        <input type="password" class="form-control" id="current_password" name="current_password"
                            autocomplete="current-password" placeholder="Masukkan password lama">
                        <small class="form-text text-muted">
                            Masukkan password lama Anda untuk konfirmasi perubahan password.
                        </small>
                    </div>
                    <div class="form-group">
                        <label for="password" class="font-weight-bold">
                            Password Baru
                            <small class="text-muted">(Kosongkan jika tidak ingin mengubah)</small>
                        </label>
                        <input type="password" class="form-control" id="password" name="password"
                            autocomplete="new-password" placeholder="Password baru">
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </form>
            </div>
        </div>
    </div>
    @include('sweetalert::alert')
@endsection
