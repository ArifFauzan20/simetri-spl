@extends('layouts.dashboard')
@section('content')
    <x-page-title>
        <h3 class="text-capitalize">Pengguna</h3>
        <x-breadcrumb>
            <li class="breadcrumb-item"><a href="#">Pengguna</a></li>
            <li class="breadcrumb-item active" aria-current="page">Data Pengguna</li>
        </x-breadcrumb>
    </x-page-title>
    {{-- @error('nik_karyawan')
        <div class="alert alert-danger">
            {{ $message }}
        </div>
    @enderror --}}
    <div class="card">
        <div class="card-body">
            <h4 class="card-title ">
                <button type="button" class="btn icon btn-success" data-bs-toggle="modal" data-bs-target="#create"
                    id="adduser">
                    <i class="bi bi-person-plus"></i>
                    Tambah Pengguna
                </button>
            </h4>
            <!--create theme Modal -->
            <div class="modal fade text-left" id="create" tabindex="-1" role="dialog" aria-labelledby="myModalLabel160"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-success">
                            <h5 class="modal-title white" id="myModalLabel160">Tambah Pengguna</h5>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <i data-feather="x"></i>
                            </button>
                        </div>
                        <form action="/superadmin/user/create" method="POST">
                            @csrf
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="nik_karyawan" class="form-label fs-6">NIK</label>
                                        <div class="form-group">
                                            <select name="nik_karyawan" id="nik_karyawan" class="choices form-select">
                                                <option value="">Pilih Karyawan</option>
                                                @foreach ($employees as $employee)
                                                    <option value="{{ $employee->nama_karyawan }}">
                                                        {{ $employee->nik_karyawan }} -
                                                        {{ $employee->nama_karyawan }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <input type="text" id="karyawan_id" name="karyawan_id" hidden>
                                <input type="text" id="nik_karyawan_create" name="nama_karyawan_create" hidden>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="nama_karyawan_create" class="form-label fs-6">Nama
                                            Karyawan</label>
                                        <div class="form-group has-icon-left">
                                            <div class="position-relative">
                                                <input type="text" class="form-control" id="nama_karyawan_create"
                                                    name="nama_karyawan_create" readonly>
                                                <div class="form-control-icon">
                                                    <i data-feather="user"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="password" class="form-label fs-6">Password</label>
                                        <div class="form-group has-icon-left">
                                            <div class="position-relative">
                                                <input type="password" class="form-control" id="password_create"
                                                    name="password">
                                                <div class="form-control-icon">
                                                    <i data-feather="lock"></i>
                                                </div>
                                            </div>
                                            <span class="fs-6 text-danger" id="invalid-password"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="status_user" class="form-label fs-6">Status</label>
                                        <div class="form-group">
                                            <select name="status_user" id="status_user_create" class="form-select">
                                                <option selected disabled class="text-muted">Pilih
                                                    Status</option>
                                                <option value="1">
                                                    Aktif
                                                </option>
                                                <option value="0">
                                                    Tidak Aktif
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="role_user" class="form-label fs-6">Role</label>
                                        <div class="form-group">
                                            <select name="role_id" id="role_user_create" class="choices form-select">
                                                <option value="">Pilih Role</option>
                                                @foreach ($roles as $role)
                                                    @switch($role->role_user)
                                                        @case(1)
                                                            <option value="{{ $role->role_user }}">
                                                                Super Admin
                                                            </option>
                                                        @break

                                                        @case(2)
                                                            <option value="{{ $role->role_user }}">
                                                                Supervisor
                                                            </option>
                                                        @break

                                                        @case(3)
                                                            <option value="{{ $role->role_user }}">
                                                                Head Production / Manager
                                                            </option>
                                                        @break

                                                        @case(4)
                                                            <option value="{{ $role->role_user }}">
                                                                Finance
                                                            </option>
                                                        @break

                                                        @case(5)
                                                            <option value="{{ $role->role_user }}">
                                                                Admin WO
                                                            </option>
                                                        @break

                                                        @case(6)
                                                            <option value="{{ $role->role_user }}">
                                                                Koordinator
                                                            </option>
                                                        @break

                                                        @case(7)
                                                            <option value="{{ $role->role_user }}">
                                                                Labour
                                                            </option>
                                                        @break

                                                        @default
                                                            <option value="{{ $role->role_user }}">
                                                                Role Tidak Ditemukan
                                                            </option>
                                                    @endswitch
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                                    <i class="bx bx-x d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">Kembali</span>
                                </button>
                                <button type="submit" class="btn btn-primary ml-1" data-bs-dismiss="modal">
                                    <i class="bx bx-check d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">Simpan</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            </h4>
            <table class='table table-striped' id="table1">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIK Karyawan</th>
                        <th>Nama Karyawan</th>
                        <th>Status</th>
                        <th>Role</th>
                        <th>Terakhir Login</th>
                        <th>Dibuat Oleh</th>
                        <th>Tanggal Pembuatan</th>
                        <th>Tanggal Update</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $user->karyawan->nik_karyawan }}</td>
                            <td>{{ $user->karyawan->nama_karyawan }}</td>
                            <td>
                                @if ($user->status_user == 1)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Tidak Aktif</span>
                                @endif
                            </td>
                            <td>
                                @switch($user->role->role_user)
                                    @case(1)
                                        <span>Super Admin</span>
                                    @break

                                    @case(2)
                                        <span>Supervisor</span>
                                    @break

                                    @case(3)
                                        <span>Head Production / Manager</span>
                                    @break

                                    @case(4)
                                        <span>Finance</span>
                                    @break

                                    @case(5)
                                        <span>Admin WO</span>
                                    @break

                                    @case(6)
                                        <span>Koordinator</span>
                                    @break

                                    @case(7)
                                        <span>Labour</span>
                                    @break

                                    @default
                                        <span>Role belum ditentukan</span>
                                @endswitch
                            </td>
                            <td>{{ $user->last_login }}</td>
                            <td>{{ $user->update_by }}</td>
                            <td>{{ $user->created_at }}</td>
                            <td>{{ $user->updated_at }}</td>
                            <td>
                                <div class="d-flex gap-2">
                                    <button type="button" class="btn icon btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#edituser{{ $user->id }}">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    <!--edit theme Modal -->
                                    <div class="modal fade text-left" id="edituser{{ $user->id }}" tabindex="-1"
                                        role="dialog" aria-labelledby="myModalLabel160" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header bg-primary">
                                                    <h5 class="modal-title white" id="myModalLabel160">Edit Pengguna</h5>
                                                    <button type="button" class="close" data-bs-dismiss="modal"
                                                        aria-label="Close">
                                                        <i data-feather="x"></i>
                                                    </button>
                                                </div>
                                                <form action="/superadmin/user/update" method="POST">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <input type="text" id="id" name="id"
                                                            value="{{ $user->id }}" hidden>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <label for="nik_karyawan" class="form-label">NIK</label>
                                                                <div class="form-group has-icon-left">
                                                                    <div class="position-relative">
                                                                        <input type="text" class="form-control"
                                                                            name="nik_karyawan" id="nik_karyawan"
                                                                            value="{{ $user->karyawan->nik_karyawan }}"
                                                                            readonly>
                                                                        <div class="form-control-icon">
                                                                            <i data-feather="credit-card"></i>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <label for="nama_karyawan" class="form-label">Nama
                                                                    Karyawan</label>
                                                                <div class="form-group has-icon-left">
                                                                    <div class="position-relative">
                                                                        <input type="text" class="form-control"
                                                                            id="nama_karyawan" name="nama_karyawan"
                                                                            value="{{ $user->karyawan->nama_karyawan }}"
                                                                            readonly>
                                                                        <div class="form-control-icon">
                                                                            <i data-feather="user"></i>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <label for="nama_karyawan"
                                                                    class="form-label">Password</label>
                                                                <div class="form-group has-icon-left">
                                                                    <div class="position-relative">
                                                                        <input type="password" class="form-control"
                                                                            id="password" name="password"
                                                                            value="{{ $user->password }}">
                                                                        <div class="form-control-icon">
                                                                            <i data-feather="lock"></i>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <label for="status_user" class="form-label">Status</label>
                                                                <div class="form-group ">
                                                                    <select name="status_user" id="status_user"
                                                                        class="form-select">
                                                                        <option selected disabled class="text-muted">Pilih
                                                                            Status</option>
                                                                        <option value="1"
                                                                            {{ $user->status_user == 1 ? 'selected' : '' }}>
                                                                            Aktif
                                                                        </option>
                                                                        <option value="0"
                                                                            {{ $user->status_user == 0 ? 'selected' : '' }}>
                                                                            Tidak Aktif
                                                                        </option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <label for="role_user" class="form-label">Role</label>
                                                                <div class="form-group">
                                                                    <select name="role_user" id="role_user"
                                                                        class="choices form-select">
                                                                        <option value="1"
                                                                            {{ $user->role->role_user == 1 ? 'selected' : '' }}>
                                                                            Super Admin</option>
                                                                        <option value="2"
                                                                            {{ $user->role->role_user == 2 ? 'selected' : '' }}>
                                                                            Supervisor</option>
                                                                        <option value="3"
                                                                            {{ $user->role->role_user == 3 ? 'selected' : '' }}>
                                                                            Head Production / Manager
                                                                        </option>
                                                                        <option value="4"
                                                                            {{ $user->role->role_user == 4 ? 'selected' : '' }}>
                                                                            Finance</option>
                                                                        <option value="5"
                                                                            {{ $user->role->role_user == 5 ? 'selected' : '' }}>
                                                                            Admin WO</option>
                                                                        <option value="6"
                                                                            {{ $user->role->role_user == 6 ? 'selected' : '' }}>
                                                                            Koordinator</option>
                                                                        <option value="7"
                                                                            {{ $user->role->role_user == 7 ? 'selected' : '' }}>
                                                                            Labour</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-light-secondary"
                                                            data-bs-dismiss="modal">
                                                            <i class="bx bx-x d-block d-sm-none"></i>
                                                            <span class="d-none d-sm-block">Kembali</span>
                                                        </button>
                                                        <button type="submit" class="btn btn-primary ml-1"
                                                            data-bs-dismiss="modal">
                                                            <i class="bx bx-check d-block d-sm-none"></i>
                                                            <span class="d-none d-sm-block">Simpan</span>
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!--/edit theme Modal -->
                                    <button type="button" class="btn icon btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#delete{{ $user->id }}">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                    <!--Delete theme Modal -->
                                    <div class="modal fade text-left" id="delete{{ $user->id }}" tabindex="-1"
                                        role="dialog" aria-labelledby="myModalLabel160" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
                                            role="document">
                                            <div class="modal-content">
                                                <div class="modal-header bg-danger">
                                                    <h5 class="modal-title white" id="myModalLabel160">Hapus Pengguna</h5>
                                                    <button type="button" class="close" data-bs-dismiss="modal"
                                                        aria-label="Close">
                                                        <i data-feather="x"></i>
                                                    </button>
                                                </div>
                                                <form action="/superadmin/user/delete" method="post">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <p>Apakah anda yakin ingin menghapus
                                                            <strong>
                                                                {{ $user->karyawan->nama_karyawan }}
                                                            </strong>
                                                            ?
                                                        </p>
                                                        <input type="hidden" name="id" id="id"
                                                            value="{{ $user->id }}">
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-light-secondary"
                                                            data-bs-dismiss="modal">
                                                            <i class="bx bx-x d-block d-sm-none"></i>
                                                            <span class="d-none d-sm-block">Kembali</span>
                                                        </button>
                                                        <button type="submit" class="btn btn-danger ml-1"
                                                            data-bs-dismiss="modal">
                                                            <i class="bx bx-check d-block d-sm-none"></i>
                                                            <span class="d-none d-sm-block">Delete</span>
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!--/delete theme Modal -->
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @include('sweetalert::alert')
    </div>
    <script src="/assets/vendors/simple-datatables/simple-datatables.js"></script>
    <script src="/assets/js/vendors.js"></script>
    <script src="/assets/vendors/choices.js/choices.min.js"></script>
    <script src="/assets/js/superadmin/edituser.js"></script>
    <script>
        $("select[id='nik_karyawan']").change(function() {
            let nama_karyawan = $(this).val();
            $.ajax({
                url: '/superadmin/employee/getemployee',
                type: 'GET',
                data: {
                    nama_karyawan: nama_karyawan

                },
                success: function(data) {
                    $('#nama_karyawan_create').val(data.employee.nama_karyawan).prop('readonly',
                        true);
                    $('#nik_karyawan_create').val(data.employee.nik_karyawan);
                    $('#karyawan_id').val(data.employee.id);
                }
            })
        });
    </script>

    <script>
        $('input[id="password_create"]').keyup(function() {
            let password_length = $(this).val();
            if (password_length.length <= 8) {
                $('#invalid-password').html('Password kurang dari 8 karakter');
            } else {
                $('#invalid-password').html('');
            }
        });
    </script>
@endsection
