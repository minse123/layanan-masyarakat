@extends('admin.app')
@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span> Data Akun Pengguna </span>
            <a href={{ url('admin/auth-formTambah') }} class="btn btn-success"> Tambah Akun </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table" id="myTable">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">No.</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Email</th>
                            <th scope="col">Telepon</th>
                            <th scope="col">nik</th>
                            <th scope="col">Alamat</th>
                            {{-- <th scope="col">Password</th> --}}
                            <th scope="col">Role</th>
                            <th scope="col" style="width: 20%">Aksi</th>
                        </tr>
                    </thead>
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <tbody class="table-group-divider">
                        @foreach ($users as $key => $user)
                            <tr>
                                <th scope="row">{{ $key + 1 }}</th>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->telepon }}</td>
                                <td>{{ $user->nik }}</td>
                                <td>{{ $user->alamat }}</td>
                                {{-- <td>{{ $user->password }}</td> --}}
                                <td>{{ ucfirst($user->role) }}</td>
                                <td>
                                    <div class="d-flex">
                                        <a href="{{ url('admin/auth-formEdit', $user->id) }}"
                                            class="btn btn-warning me-2">Edit</a>
                                        <form action="{{ url('admin/auth/hapus') }}" method="POST"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun ini?');">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $user->id }}">
                                            <button type="submit" class="btn btn-danger">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        let table = new DataTable('#myTable');
    </script>
@endsection

@include('sweetalert::alert')

{{-- @if (session('success'))
    <script>
        Swal.fire('Berhasil', '{{ session('success') }}', 'success');
    </script>
@endif --}}
