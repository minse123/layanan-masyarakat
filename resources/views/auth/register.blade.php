@extends('auth.auth')
@include('sweetalert::alert')
@section('content')
    <div class="row justify-content-center h-100">
        <div class="col-lg-9 col-12">
            <div id="auth-left">
                <div class="row justify-content-center">
                    <a href="/"><img style="width: 100px; height: 100%" src="/frontend/images/logo-kementerian.png"
                            alt="Logo"></a>
                </div>
                <p class="auth-subtitle mb-3">Masukkan data Anda untuk mendaftar ke situs web kami.</p>

                <form method="POST" action="{{ url('/register-process') }}">
                    @csrf
                    <div class="form-group position-relative has-icon-left mb-3">
                        <input required type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Nama" value="{{ old('name') }}">
                        <div class="form-control-icon">
                            <i class="bi bi-person"></i>
                        </div>
                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    {{-- <div class="form-group position-relative has-icon-left mb-3">
                        <input required type="date" name="birthday" class="form-control" placeholder="Tanggal Lahir">
                        <div class="form-control-icon">
                            <i class="bi bi-calendar"></i>
                        </div>
                        @error('birthday')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div> --}}
                    <div class="form-group position-relative has-icon-left mb-3">
                        <textarea required name="alamat" class="form-control @error('alamat') is-invalid @enderror" placeholder="Alamat">{{ old('alamat') }}</textarea>
                        <div class="form-control-icon">
                            <i class="bi bi-geo-alt"></i>
                        </div>
                        @error('alamat')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group position-relative has-icon-left mb-3">
                        <input required type="text" name="telepon" class="form-control @error('telepon') is-invalid @enderror" placeholder="Nomor Telepon"
                            data-parsley-type="number"
                            data-parsley-error-message="Masukkan format nomor telepon yang valid." value="{{ old('telepon') }}">
                        <div class="form-control-icon">
                            <i class="bi bi-telephone"></i>
                        </div>
                        @error('telepon')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group position-relative has-icon-left mb-3">
                        <input required type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" value="{{ old('email') }}">
                        <div class="form-control-icon">
                            <i class="bi bi-envelope"></i>
                        </div>
                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group position-relative has-icon-left mb-3">
                        <input required type="text" name="nik" class="form-control @error('nik') is-invalid @enderror" placeholder="NIK" value="{{ old('nik') }}">
                        <div class="form-control-icon">
                            <i class="bi bi-person-badge"></i>
                        </div>
                        @error('nik')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group position-relative has-icon-left mb-3">
                        <input required type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror"
                            placeholder="Password" data-parsley-minlength="8"
                            data-parsley-error-message="Kata sandi harus lebih besar dari atau sama dengan 8.">
                        <div class="form-control-icon">
                            <i class="bi bi-shield-lock"></i>
                        </div>
                        @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group position-relative has-icon-left mb-3">
                        <input required type="password" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror"
                            placeholder="Konfirmasi Password" data-parsley-equalto="#password"
                            data-parsley-error-message="Kata sandi tidak cocok.">
                        <div class="form-control-icon">
                            <i class="bi bi-shield-lock"></i>
                        </div>
                        @error('password_confirm')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    

                    <button type="submit" class="btn btn-primary btn-block shadow-lg mt-3">Daftar</button>
                    <hr>
                </form>
                <div class="text-center mt-3">
                    <p class="text-gray-600">Sudah memiliki akun? <a href="/login" class="font-bold">Masuk</a>.</p>
                </div>
            </div>
        </div>
    </div>
@endsection
