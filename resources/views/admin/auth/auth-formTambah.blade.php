@extends($layout)
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Tambah Akun Pengguna</h3>
                    <p class="text-subtitle text-muted">Formulir untuk menambahkan akun pengguna baru.</p>
                </div>
                {{-- <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ url('admin/auth') }}">Data Akun Pengguna</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Tambah Akun</li>
                        </ol>
                    </nav>
                </div> --}}
            </div>
        </div>

        <section class="section">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Tambah Akun</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.auth.simpan') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name" class="font-weight-bold">Nama <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name"
                                placeholder="Nama lengkap" required>
                        </div>
                        <div class="form-group">
                            <label for="email" class="font-weight-bold">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="email" name="email"
                                placeholder="Alamat email" required>
                        </div>
                        <div class="form-group">
                            <label for="telepon" class="font-weight-bold">Telepon <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="telepon" name="telepon"
                                placeholder="Nomor telepon" required>
                        </div>
                        <div class="form-group">
                            <label for="nik" class="font-weight-bold">NIK <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nik" name="nik"
                                placeholder="Nomor Induk Kependudukan" required>
                        </div>
                        <div class="form-group">
                            <label for="alamat" class="font-weight-bold">Alamat <span class="text-danger">*</span></label>
                            <textarea name="alamat" id="alamat" rows="4" class="form-control" placeholder="Alamat lengkap" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="password" class="font-weight-bold">Password <span
                                    class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="password" name="password"
                                placeholder="Password" required>
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation" class="font-weight-bold">Konfirmasi Password <span
                                    class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="password_confirmation"
                                name="password_confirmation" placeholder="Konfirmasi password" required>
                        </div>
                        <div class="form-group">
                            <label for="role" class="font-weight-bold">Role <span class="text-danger">*</span></label>
                            <select class="form-control" id="role" name="role" required>
                                <option value="" disabled selected>-- Pilih Role --</option>
                                <option value="admin">Admin</option>
                                <option value="psm">PSM</option>
                                <option value="kasubag">Kasubag</option>
                                <option value="operator">Operator</option>
                                <option value="masyarakat">Masyarakat</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Tambah</button>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection
