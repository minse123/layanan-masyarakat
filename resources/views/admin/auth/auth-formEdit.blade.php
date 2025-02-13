@extends('admin.app')

@section('content')
    <div class="container">
        <h2>Edit Akun</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('admin.auth.update', $user->id) }}">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Nama</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}"
                    required>
            </div>

            <div class="mb-3">
                <label for="telepon" class="form-label">Telepon</label>
                <input type="text" class="form-control" id="telepon" name="telepon" value="{{ $user->telepon }}"
                    required>
            </div>

            <div class="mb-3">
                <label for="role" class="form-label">Role</label>
                <select class="form-control" id="role" name="role" required>
                    <option value="user" {{ $user->role == 'psm' ? 'selected' : '' }}>PSM</option>
                    <option value="kasubag" {{ $user->role == 'kasubag' ? 'selected' : '' }}>Kasubag</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password (Opsional)</label>
                <input type="password" class="form-control" id="password" name="password">
                <small class="text-muted">Isi hanya jika ingin mengubah password.</small>
            </div>

            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </form>
    </div>
@endsection
