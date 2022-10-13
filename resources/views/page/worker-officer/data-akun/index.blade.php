@extends('layouts.dashboard')
@section('content')
    <x-page-title>
        <h3 class="text-capitalize">Data Akun</h3>
        <x-breadcrumb>
            <li class="breadcrumb-item"><a href="/">Admin Work Office</a></li>
            <li class="breadcrumb-item active" aria-current="page">Data Akun</li>
        </x-breadcrumb>
    </x-page-title>
    <div class="card">
        <div class="card-body">
            <section class="add-user">
                <button class="btn btn-add" data-bs-toggle="modal" data-bs-target="#addUser">
                    <i class="bi bi-plus-circle"></i> Tambah Data Akun
                </button>
                <div class="modal fade" id="addUser" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                    aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header bg-add">
                                <h5 class="modal-title text-white" id="staticBackdropLabel">Tambah User</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form action="{{ route('adminwo.data-akun.create') }}" method="POST">
                                @csrf
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="bagian_id" class="form-label">Pilih Karyawan</label>
                                        <select
                                            class="choices form-select @error('nik_karyawan_select') is-invalid @enderror"
                                            name="nik_karyawan_select" id="nik_karyawan_select">
                                            <option value="" selected disabled>Nama Karyawan</option>
                                            @foreach ($employees as $employee)
                                                <option value="{{ $employee->nama_karyawan }}">
                                                    {{ $employee->nik_karyawan }} - {{ $employee->nama_karyawan }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <input type="text" id="karyawan_id" name="karyawan_id" hidden>
                                    <div class="form-group">
                                        <label for="nik_karyawan" class="form-label">NIK Karyawan</label>
                                        <input type="text" id="nik_karyawan" name="nik_karyawan" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="nama_karyawan" class="form-label">Nama Karyawan</label>
                                        <input type="text" name="nama_karyawan" id="nama_karyawan" class="form-control"
                                            readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="password" name="password" id="password" class="form-control">
                                        <small class="muted text-danger">*password harus lebih dari 8 karakter</small>
                                    </div>
                                    <div class="form-group">
                                        <label for="role_id" class="form-label">Role</label>
                                        <select class="choices form-select @error('role_id') is-invalid @enderror"
                                            name="role_id" id="role_id">
                                            <option value="" selected disabled>Pilih Role</option>
                                            @foreach ($roles as $role)
                                                <option value="{{ $role->role_user }}">
                                                    @switch($role->role_user)
                                                        @case(2)
                                                            Supervisor
                                                        @break

                                                        @case(3)
                                                            Head
                                                        @break

                                                        @case(4)
                                                            Finance
                                                        @break

                                                        @case(5)
                                                            Admin WO
                                                        @break

                                                        @case(6)
                                                            Koordinator
                                                        @break

                                                        @default
                                                            Labour
                                                    @endswitch
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="status_user" class="form-label">Status</label>
                                        <select name="status_user" id="status_user" class="form-select">
                                            <option value="" selected disabled>Pilih Status</option>
                                            <option value="1">Aktif</option>
                                            <option value="0">Tidak Aktif</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Kembali</button>
                                    <button type="submit" class="btn btn-add">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
            <section>
                <table class="table" id="table1">
                    <thead>
                        <tr class="text-dark">
                            <th>No</th>
                            <th>NIK</th>
                            <th>Nama Karyawan</th>
                            <th>Role</th>
                            <th>Bagian</th>
                            <th>Status</th>
                            <th>Update By</th>
                            <th>Last Login</th>
                            <th>Actions </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr class="text-dark">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $user->nik_karyawan }}</td>
                                <td>{{ $user->karyawan->nama_karyawan }}</td>
                                <td>
                                    @switch($user->role->role_user)
                                        @case(2)
                                            <span>Supervisor</span>
                                        @break

                                        @case(3)
                                            <span>Head </span>
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

                                        @default
                                            <span>Labour</span>
                                    @endswitch
                                </td>
                                <td>{{ $user->karyawan->bagian->nama_bagian }}</td>
                                <td>
                                    @if ($user->status_user == 1)
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-danger">Tidak Aktif</span>
                                    @endif
                                </td>
                                <td>{{ $user->update_by }}</td>
                                <td>{{ \Carbon\Carbon::parse($user->last_login)->format('Y-m-d H:i') }}</td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <section>
                                            <button class="btn btn-edit px-3 py-2"
                                                data-bs-target="#editUser-{{ $user->id }}" data-bs-toggle="modal">
                                                <i class="bi bi-pen"></i>
                                            </button>
                                            <div class="modal fade" id="editUser-{{ $user->id }}"
                                                data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                                aria-labelledby="editUser" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-edit">
                                                            <h5 class="modal-title text-dark" id="editUser">Edit
                                                                User
                                                            </h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <form action="{{ route('adminwo.data-akun.edit') }}"
                                                            method="POST">
                                                            @csrf
                                                            <div class="modal-body">
                                                                <input type="text" name="id_edit" id="id_edit"
                                                                    value="{{ $user->id }}" hidden>
                                                                <div class="form-group">
                                                                    <label for="nik_karyawan_select_edit"
                                                                        class="form-label">Pilih
                                                                        Karyawan</label>
                                                                    <select class="choices form-select"
                                                                        name="nik_karyawan_select_edit"
                                                                        id="nik_karyawan_select_edit">
                                                                        @foreach ($employees as $item)
                                                                            <option value="{{ $item->nama_karyawan }}"
                                                                                {{ $user->karyawan->id == $item->id ? 'selected' : '' }}>
                                                                                {{ $item->nik_karyawan }} -
                                                                                {{ $item->nama_karyawan }} </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <input type="text" id="karyawan_id_edit"
                                                                    name="karyawan_id_edit"
                                                                    value="{{ $user->karyawan_id }}" hidden>
                                                                <div class="form-group">
                                                                    <label for="nik_karyawan_edit" class="form-label">Nik
                                                                        Karyawan</label>
                                                                    <input type="text" class="form-control"
                                                                        value="{{ $user->nik_karyawan }}"
                                                                        name="nik_karyawan_edit" id="nik_karyawan_edit">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="nama_karyawan" class="form-label">Nama
                                                                        Karyawan</label>
                                                                    <input type="text" class="form-control"
                                                                        value="{{ $user->karyawan->nama_karyawan }}"
                                                                        name="nama_karyawan_edit" id="nama_karyawan_edit">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="role_id_edit"
                                                                        class="form-label">Role</label>
                                                                    <select
                                                                        class="choices form-select @error('role_id') is-invalid @enderror"
                                                                        name="role_id_edit" id="role_id_edit">
                                                                        <option value="" disabled>Pilih Role
                                                                        </option>
                                                                        @foreach ($roles as $role)
                                                                            <option value="{{ $role->role_user }}"
                                                                                {{ $user->role_id == $role->role_user ? 'selected' : '' }}>
                                                                                @switch($role->role_user)
                                                                                    @case(2)
                                                                                        Supervisor
                                                                                    @break

                                                                                    @case(3)
                                                                                        Head Production / Manager
                                                                                    @break

                                                                                    @case(4)
                                                                                        Finance
                                                                                    @break

                                                                                    @case(5)
                                                                                        Admin WO
                                                                                    @break

                                                                                    @case(6)
                                                                                        Koordinator
                                                                                    @break

                                                                                    @case(7)
                                                                                        Labour
                                                                                    @break

                                                                                    @default
                                                                                @endswitch
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="status_user_edit"
                                                                        class="form-label">Status</label>
                                                                    <select name="status_user_edit" id="status_user_edit"
                                                                        class="form-select">
                                                                        <option value="" disabled>Pilih Status
                                                                        </option>
                                                                        <option value="1"
                                                                            {{ $user->status_user == '1' ? 'selected' : '' }}>
                                                                            Aktif
                                                                        </option>
                                                                        <option value="0"
                                                                            {{ $user->status_user == '0' ? 'selected' : '' }}>
                                                                            Tidak
                                                                            Aktif</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Kembali</button>
                                                                <button type="submit" class="btn btn-edit">Edit</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </section>
                                        <section>
                                            <button type="button" class="btn btn-secondary px-3 py-2"
                                                data-bs-toggle="modal"
                                                data-bs-target="#resetPassword{{ $user->id }}">
                                                <i class="bi bi-arrow-clockwise"></i>
                                            </button>

                                            <!-- Modal -->
                                            <div class="modal fade" id="resetPassword{{ $user->id }}" tabindex="-1"
                                                aria-labelledby="resetPasswordLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-secondary">
                                                            <h5 class="modal-title text-white" id="resetPasswordLabel">
                                                                Reset password
                                                            </h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <form action="{{ route('adminwo.data-akun.resetpassword') }}"
                                                            method="POST">
                                                            @csrf
                                                            <div class="modal-body">
                                                                <input type="text" id="id_reset" name="id_reset"
                                                                    value="{{ $user->id }}" hidden>
                                                                <div class="form-group">
                                                                    <label for="newPassword" class="form-label">New
                                                                        password</label>
                                                                    <input type="password" class="form-control"
                                                                        id="newPassword" name="newPassword">
                                                                    <small class="muted text-danger">*password harus lebih
                                                                        dari 8 karakter</small>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-primary">Save
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </section>
                                        <section>
                                            <button type="button" class="btn btn-delete  px-3 py-2"
                                                data-bs-toggle="modal" data-bs-target="#deleteUser{{ $user->id }}">
                                                <i class="bi bi-trash3"></i>
                                            </button>

                                            <!-- Modal -->
                                            <div class="modal fade" id="deleteUser{{ $user->id }}" tabindex="-1"
                                                aria-labelledby="deleteUserLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-delete">
                                                            <h5 class="modal-title text-white" id="deleteUserLabel">Delete
                                                                User
                                                            </h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <form action="{{ route('adminwo.data-akun.delete') }}"
                                                            method="POST">
                                                            @csrf
                                                            <div class="modal-body">
                                                                <input type="text" id="id_delete" name="id_delete"
                                                                    value="{{ $user->id }}" hidden>
                                                                <p>Apakah anda yakin ingin menghapus user
                                                                    <strong> {{ $user->nik_karyawan }}
                                                                        ({{ $user->karyawan->nama_karyawan }})
                                                                    </strong>
                                                                    ini?
                                                                </p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Close</button>
                                                                <button type="submit"
                                                                    class="btn btn-delete">Delete</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </section>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </section>
        </div>
        @include('sweetalert::alert')
    </div>
    <script src="/assets/vendors/simple-datatables/simple-datatables.js"></script>
    <script src="/assets/js/vendors.js"></script>
    <script src="/assets/vendors/choices.js/choices.min.js"></script>
    <script src="/assets/js/superadmin/edituser.js"></script>
    <script>
        $('#addUser').on('hidden.bs.modal', function() {
            $('#addUser').find('form')[0].reset();
        })
    </script>
    <script>
        $(document).ready(function() {
            $("select[id='nik_karyawan_select']").change(function() {
                let nama_karyawan = $(this).val();
                let nik_karyawan = $(this).children("option:selected").text();
                nik_karyawan = nik_karyawan.split(" ");
                nik_karyawan = nik_karyawan[52];
                $.ajax({
                    url: '/admin-worker-officer/data-akun/find/' + nama_karyawan + '/' +
                        nik_karyawan,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#karyawan_id').val(data[0].id);
                        $("#nik_karyawan").val(data[0].nik_karyawan);
                        $("#nama_karyawan").val(data[0].nama_karyawan);
                    }
                })
            })

        });
    </script>
    <script>
        $(document).ready(function() {
            $("select[id='nik_karyawan_select_edit']").change(function() {
                let nama_karyawan = $(this).val();
                $.ajax({
                    url: '/admin-worker-officer/data-akun/find/' + nama_karyawan,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#karyawan_id_edit').val(data[0].id);
                        $("#nik_karyawan_edit").val(data[0].nik_karyawan);
                        $("#nama_karyawan_edit").val(data[0].nama_karyawan);
                    }
                })
            })

        });
    </script>
@endsection
