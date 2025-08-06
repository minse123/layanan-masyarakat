@extends('auth.auth')
@section('content')
    <div class="row justify-content-center h-100">
        <div class="col-lg-9 col-12">
            <div id="auth-left">
                <div class="text-center mb-4">
                    <a href="/"><img src="/frontend/images/logo-kementerian.png" alt="Logo" style="width: 100px;"></a>
                </div>
                <h4 class="auth-title">Login Pegawai</h4>
                <p class="auth-subtitle mb-3">Masukan Akun Anda</p>

                {{-- Form Login --}}
                <form method="POST" action="/login-pegawai" data-parsley-validate>
                    @csrf
                    <div class="form-group position-relative has-icon-left mb-3">
                        <input type="email" name="email" class="form-control" placeholder="Email"
                            value="{{ old('email') }}" required data-parsley-required="true"
                            data-parsley-error-message="Masukkan Email Anda">
                        <div class="form-control-icon">
                            <i class="bi bi-person"></i>
                        </div>
                        @error('email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group position-relative has-icon-left mb-3">
                        <input type="password" name="password" class="form-control" placeholder="Password" required
                            data-parsley-minlength="8" data-parsley-error-message="Kata sandi harus minimal 8 karakter.">
                        <div class="form-control-icon">
                            <i class="bi bi-shield-lock"></i>
                        </div>
                        @error('password')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary btn-block shadow-lg mt-3">Masuk</button>
                    <hr>
                </form>
                @include('sweetalert::alert')

            </div>
        </div>
    </div>
@endsection
