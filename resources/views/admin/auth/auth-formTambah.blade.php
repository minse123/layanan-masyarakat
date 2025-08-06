@extends($layout)

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Tambah Akun</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.auth.simpan') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="name" class="font-weight-bold">Nama <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="name" name="name"
                                    placeholder="Nama lengkap" required>
                            </div>
                            <div class="form-group">
                                <label for="email" class="font-weight-bold">Email <span
                                        class="text-danger">*</span></label>
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
                                <input type="text" class="form-control" id="nik" name="nik" placeholder="Nomor Induk Kependudukan" required>
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
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Konfirmasi password" required>
                            </div>
                            <div class="form-group">
                                <label for="role" class="font-weight-bold">Role <span
                                        class="text-danger">*</span></label>
                                <select class="form-control" id="role" name="role" required>
                                    <option value="" disabled selected>-- Pilih Role --</option>
                                    <option value="admin">Admin</option>
                                    <option value="psm">PSM</option>
                                    <option value="kasubag">Kasubag</option>
                                    <option value="operator">Operator</option>
                                    <option value="masyarakat">Masyarakat</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Tambah</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
