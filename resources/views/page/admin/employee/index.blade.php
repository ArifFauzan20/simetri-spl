@extends('layouts.dashboard')
@section('content')
    <x-page-title>
        <h3 class="text-capitalize">Karyawan</h3>
        <x-breadcrumb>
            <li class="breadcrumb-item"><a href="#">Karyawan</a></li>
            <li class="breadcrumb-item active" aria-current="page">Data Karyawan</li>
        </x-breadcrumb>
    </x-page-title>
    <div class="card">
        <div class="card-body">
            <div class="card-title">
                <button type="button" class="btn icon btn-add" data-bs-toggle="modal" data-bs-target="#create-employee">
                    <i class="bi bi-plus-circle"></i>
                    Tambah Karyawan
                </button>
                <!--Create Modal -->
                <div class="modal fade text-left" id="create-employee" tabindex="-1" role="dialog"
                    aria-labelledby="myModalLabel160" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header bg-success">
                                <h5 class="modal-title white" id="myModalLabel160">Tambah Karyawan</h5>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                    <i data-feather="x"></i>
                                </button>
                            </div>
                            <form action="/superadmin/employee/create" method="POST" id="form-create">
                                @csrf
                                <div class="modal-body">
                                    <section class="row">
                                        <label for="nik_karyawan" class="fs-6">NIK Karyawan</label>
                                        <div class="col-md-12">
                                            <div class="form-group has-icon-left">
                                                <div class="position-relative">
                                                    <input type="number" class="form-control" name="nik_karyawan"
                                                        id="nik_karyawan" placeholder="NIK" autofocus oninput="checkNik()"
                                                        required>
                                                    <div class="form-control-icon">
                                                        <i data-feather="credit-card"></i>
                                                    </div>
                                                </div>
                                                <span style="font-size: 10px" id="invalid-message-nik" class="text-danger">
                                                    NIK sudah terdaftar
                                                </span>
                                                <span style="font-size: 10px" id="valid-message-nik" class="text-success">
                                                    NIK dapat didaftarkan
                                                </span>
                                            </div>
                                        </div>
                                    </section>
                                    <section class="row">
                                        <label for="nama_karyawan" class="fs-6">Nama Karyawan</label>
                                        <div class="col-md-12">
                                            <div class="form-group has-icon-left">
                                                <div class="position-relative">
                                                    <input type="text" class="form-control" name="nama_karyawan"
                                                        id="nama_karyawan" placeholder="Nama Karyawan" oninput="checkNama()"
                                                        required>
                                                    <div class="form-control-icon">
                                                        <i data-feather="user"></i>
                                                    </div>
                                                </div>
                                                <span style="font-size: 10px" id="invalid-message-name"
                                                    class="text-danger p-0">
                                                    Nama sudah terdaftar
                                                </span>
                                                <span style="font-size: 10px" id="valid-message-name"
                                                    class="text-success p-0">
                                                    Nama dapat didaftarkan
                                                </span>
                                            </div>
                                        </div>
                                    </section>
                                    <section class="row">
                                        <div class="col-md-12">
                                            <label for="bagian_id" class="fs-6">Pilih Divisi</label>
                                            <div class="form-group">
                                                <div class="position-relative">
                                                    <select name="bagian_name" id="bagian_name" class="choices form-select"
                                                        required>
                                                        <option value="" selected>Pilih Divisi</option>
                                                        @foreach ($divisions as $division)
                                                            <option value="{{ $division->nama_bagian }}">
                                                                {{ $division->nama_bagian }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                    <input type="text" id="bagian_id" name="bagian_id" hidden>
                                    <section class="row">
                                        <label for="tarif_lembur" class="fs-6">Tarif Lembur</label>
                                        <div class="col-md-12">
                                            <div class="form-group has-icon-left">
                                                <div class="position-relative">
                                                    <input type="number" class="form-control" name="tarif_lembur"
                                                        id="tarif_lembur" placeholder="Tarif Lembur" required>
                                                    <div class="form-control-icon">
                                                        <i class="bi bi-cash"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                    <section class="row">
                                        <label for="status_kontrak" class="fs-6">Status Kontrak</label>
                                        <div class="col-md-12">
                                            <select name="status_kontrak" id="status_kontrak" class="form-control"
                                                required>
                                                <option selected disabled>Pilih Status Kontrak</option>
                                                <option value="harian">Harian</option>
                                                <option value="kontrak">Kontrak</option>
                                                <option value="tetap">Tetap</option>
                                            </select>
                                        </div>
                                    </section>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light-secondary" id="resetModal"
                                        data-bs-dismiss="modal">
                                        <i class="bx bx-x d-block d-sm-none"></i>
                                        <span class="d-none d-sm-block">Kembali</span>
                                    </button>
                                    <button type="submit" class="btn btn-success ml-1">
                                        <i class="bx bx-check d-block d-sm-none"></i>
                                        <span class="d-none d-sm-block">Simpan</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <table class='table table-striped' id="table1">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIK</th>
                        <th>Nama Karyawan</th>
                        <th>Divisi</th>
                        <th>Tarif Lembur</th>
                        <th>Status Kontrak</th>
                        <th>Dibuat Oleh</th>
                        <th>Tanggal Pembuatan</th>
                        <th>Tanggal Update</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($employees as $employee)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $employee->nik_karyawan }}</td>
                            <td>{{ $employee->nama_karyawan }}</td>
                            <td>{{ $employee->bagian->nama_bagian }}</td>
                            <td>@currency($employee->tarif_lembur)</td>
                            <td>{{ $employee->status_kontrak }}</td>
                            <td>{{ $employee->update_by }}</td>
                            <td>{{ Carbon\Carbon::parse($employee->created_at)->format('l d-m-Y') }}</td>
                            <td>{{ Carbon\Carbon::parse($employee->updated_at)->format('l d-m-Y') }}</td>
                            <td>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-edit edit" data-bs-target="#modalEdit{{ $employee->id }}"
                                        data-bs-toggle="modal">Edit</button>
                                    <div class="modal fade" id="modalEdit{{ $employee->id }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header bg-primary">
                                                    <h5 class="modal-title text-white">Edit Karyawan</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <form action="/superadmin/employee/update" method="POST">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <input type="text" id="id" name="id" hidden>
                                                        <section class="row">
                                                            <label for="nik_karyawan" class="fs-6">NIK Karyawan</label>
                                                            <div class="col-md-12">
                                                                <div class="form-group has-icon-left">
                                                                    <div class="position-relative">
                                                                        <input type="number" class="form-control"
                                                                            name="nik_karyawan" id="nik_karyawan"
                                                                            placeholder="NIK" autofocus
                                                                            oninput="checkNik()"
                                                                            value="{{ $employee->nik_karyawan }}">
                                                                        <div class="form-control-icon">
                                                                            <i data-feather="credit-card"></i>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </section>
                                                        <section class="row">
                                                            <label for="nama_karyawan" class="fs-6">Nama
                                                                Karyawan</label>
                                                            <div class="col-md-12">
                                                                <div class="form-group has-icon-left">
                                                                    <div class="position-relative">
                                                                        <input type="text" class="form-control"
                                                                            name="nama_karyawan" id="nama_karyawan"
                                                                            placeholder="Nama Karyawan"
                                                                            oninput="checkNama()"
                                                                            value="{{ $employee->nama_karyawan }}">
                                                                        <div class="form-control-icon">
                                                                            <i data-feather="user"></i>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </section>
                                                        <section class="row">
                                                            <div class="col-md-12">
                                                                <label for="bagian_id" class="fs-6">Pilih Divisi</label>
                                                                <div class="form-group">
                                                                    <div class="position-relative">
                                                                        <select name="bagian_name" id="bagian_name"
                                                                            class="choices form-select">
                                                                            <option value="">Pilih Divisi</option>
                                                                            @foreach ($divisions as $division)
                                                                                <option
                                                                                    value="{{ $division->nama_bagian }}"
                                                                                    {{ $division->nama_bagian == $employee->bagian->nama_bagian ? 'selected' : '' }}>
                                                                                    {{ $division->nama_bagian }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </section>
                                                        <input type="text" name="bagian_id_edit" id="bagian_id_edit"
                                                            value="{{ $employee->bagian_id }}" hidden>
                                                        <section class="row">
                                                            <label for="tarif_lembur" class="fs-6">Tarif Lembur</label>
                                                            <div class="col-md-12">
                                                                <div class="form-group has-icon-left">
                                                                    <div class="position-relative">
                                                                        <input type="text" class="form-control"
                                                                            name="tarif_lembur" id="tarif_lembur"
                                                                            placeholder="Tarif Lembur"
                                                                            value="{{ $employee->tarif_lembur }}">
                                                                        <div class="form-control-icon">
                                                                            <i class="bi bi-cash"></i>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </section>
                                                        <section class="row">
                                                            <label for="status_kontrak" class="fs-6">Status
                                                                Kontrak</label>
                                                            <div class="col-md-12">
                                                                <select name="status_kontrak" id="status_kontrak"
                                                                    class="form-control">
                                                                    <option selected disabled>Pilih Status Kontrak</option>
                                                                    <option value="{{ $employee->status_kontrak }}">
                                                                        Harian</option>
                                                                    <option value="kontrak">
                                                                        Kontrak</option>
                                                                    <option value="tetap">
                                                                        Tetap</option>
                                                                </select>
                                                            </div>
                                                            {{ $employee->status_kontrak }}
                                                        </section>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-light"
                                                            data-bs-dismiss="modal">Kembali</button>
                                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="#" data-bs-target="#deleteModal" data-bs-toggle="modal"
                                        data-id={{ $employee->id }} class="btn btn-delete delete">Delete</a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @include('sweetalert::alert')
    </div>

    <div class="modal" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title text-white">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="/superadmin/employee/delete" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="text" id="id" name="id" hidden>
                        <p>Apakah anda yakin ingin menghapus data ini?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Kembali</button>
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="/assets/vendors/simple-datatables/simple-datatables.js"></script>
    <script src="/assets/js/vendors.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script src="/assets/vendors/choices.js/choices.min.js"></script>
    <script src="/assets/js/superadmin/edituser.js"></script>
    <script>
        $('#invalid-message-nik').hide();
        $('#valid-message-nik').hide();
        $('#invalid-message-name').hide();
        $('#valid-message-name').hide();

        $('#invalid-message-nik-edit').hide();
        $('#valid-message-nik-edit').hide();
        $('#invalid-message-name-edit').hide();
        $('#valid-message-name-edit').hide();

        function checkNik() {
            $.ajax({
                url: '/superadmin/employee/check',
                type: 'GET',
                data: {
                    nik_karyawan: $('#nik_karyawan').val(),
                },
                success: function(data) {

                    if (data.status == 'success') {
                        $('#nik_karyawan').removeClass('is-invalid');
                        $('#nik_karyawan').addClass('is-valid');
                        $('#invalid-message-nik').hide();
                        $('#valid-message-nik').show();
                    } else {
                        $('#nik_karyawan').removeClass('is-valid');
                        $('#nik_karyawan').addClass('is-invalid');
                        $('#invalid-message-nik').show();
                        $('#valid-message-nik').hide();
                    }
                }
            })
        }

        function checkNama() {
            $.ajax({
                url: '/superadmin/employee/check',
                type: 'GET',
                data: {
                    nama_karyawan: $('#nama_karyawan').val(),
                },
                success: function(data) {

                    if (data.status == 'success') {
                        $('#nama_karyawan').removeClass('is-invalid');
                        $('#nama_karyawan').addClass('is-valid');
                        $('#invalid-message-name').hide();
                        $('#valid-message-name').show();
                    } else {
                        $('#nama_karyawan').removeClass('is-valid');
                        $('#nama_karyawan').addClass('is-invalid');
                        $('#invalid-message-name').show();
                        $('#valid-message-name').hide();
                    }
                }
            })
        }

        function checkEditNik() {
            $.ajax({
                url: '/superadmin/employee/check',
                type: 'GET',
                data: {
                    nik_karyawan: $('#edit_nik_karyawan      ').val(),
                },
                success: function(data) {

                    if (data.status == 'success') {
                        $('#edit_nik_karyawan').removeClass('is-invalid');
                        $('#edit_nik_karyawan').addClass('is-valid');
                        $('#invalid-message-nik-edit').hide();
                        $('#valid-message-nik-edit').show();
                    } else {
                        $('#edit_nik_karyawan').removeClass('is-valid');
                        $('#edit_nik_karyawan').addClass('is-invalid');
                        $('#invalid-message-nik-edit').show();
                        $('#valid-message-nik-edit').hide();
                    }
                }
            })
        }

        function checkEditNama() {
            $.ajax({
                url: '/superadmin/employee/check',
                type: 'GET',
                data: {
                    nama_karyawan: $('#edit_nama_karyawan').val(),
                },
                success: function(data) {

                    if (data.status == 'success') {
                        $('#edit_nama_karyawan').removeClass('is-invalid');
                        $('#edit_nama_karyawan').addClass('is-valid');
                        $('#invalid-message-name-edit').hide();
                        $('#valid-message-name-edit').show();
                    } else {
                        $('#edit_nama_karyawan').removeClass('is-valid');
                        $('#edit_nama_karyawan').addClass('is-invalid');
                        $('#invalid-message-name-edit').show();
                        $('#valid-message-name-edit').hide();
                    }
                }
            })
        }
    </script>
    <script>
        $('#create-employee').on('hidden.bs.modal', function(e) {
            $('#invalid-message-nik').hide();
            $('#valid-message-nik').hide();
            $('#invalid-message-name').hide();
            $('#valid-message-name').hide();
            $('#nik_karyawan').removeClass('is-invalid');
            $('#nik_karyawan').removeClass('is-valid');
            $('#nama_karyawan').removeClass('is-valid');
            $('#nama_karyawan').removeClass('is-invalid');
            $(this).find('#form-create')[0].reset();
        })
    </script>
    <script>
        $("select[id='bagian_name']").change(function() {
            let nama_bagian = $(this).val();
            $.ajax({
                url: '/superadmin/employee/get-division',
                type: 'GET',
                data: {
                    nama_bagian: nama_bagian
                },
                success: function(data) {
                    $('#bagian_id').val(data.division.id)
                    $('#bagian_id_edit').val(data.division.id)
                }
            })
        })
    </script>
@endsection
