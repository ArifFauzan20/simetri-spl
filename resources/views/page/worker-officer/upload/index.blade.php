@extends('layouts.dashboard')
@section('content')
    <x-page-title>
        <h3 class="text-capitalize">Upload Tanda Tangan</h3>
        <x-breadcrumb>
            <li class="breadcrumb-item"><a href="/admin-worker-officer">Admin Wokrer Officer</a></li>
            <li class="breadcrumb-item active" aria-current="page">Upload Tanda Tangan</li>
        </x-breadcrumb>
    </x-page-title>
    <main class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">List Tanda Tangan</h5>
                    <button class="btn btn-add" data-bs-target="#uploadSignature" data-bs-toggle="modal">
                        <i class="bi bi-plus"></i>
                        Upload Tanda Tangan
                    </button>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-striped" id="table1">
                                <thead>
                                    <tr class="text-dark">
                                        <th>No</th>
                                        <th>NIK</th>
                                        <th>Nama Karyawan</th>
                                        <th>File Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($uploads as $upload)
                                        <tr class="text-dark">
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $upload->karyawan->nik_karyawan }}</td>
                                            <td>{{ $upload->karyawan->nama_karyawan }}</td>
                                            <td>{{ $upload->file_name }}</td>
                                            <td class="d-flex gap-2">
                                                <div>
                                                    <Button class="btn btn-info py-2 px-3" data-bs-toggle="modal"
                                                        data-bs-target="#seeSignature{{ $upload->id }}">
                                                        <i class="bi bi-eye-fill"></i>
                                                    </Button>
                                                    <div class="modal fade" id="seeSignature{{ $upload->id }}"
                                                        tabindex="-1" aria-labelledby="seeSignature" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header bg-info">
                                                                    <h5 class="modal-title text-white" id="seeSignature">
                                                                        Tanda Tangan
                                                                    </h5>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="card-body">
                                                                    <h4 class="text-dark">
                                                                        {{ $upload->karyawan->nama_karyawan }}
                                                                    </h4>
                                                                    <img src="/signatures/{{ $upload->file_name }}"
                                                                        alt="{{ $upload->file_name }}">
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">Close</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div>
                                                    <Button class="btn btn-delete py-2 px-3"
                                                        data-bs-target="#deleteSignature{{ $upload->id }}"
                                                        data-bs-toggle="modal">
                                                        <i class="bi bi-trash-fill"></i>
                                                    </Button>
                                                    <div class="modal fade" id="deleteSignature{{ $upload->id }}"
                                                        tabindex="-1" aria-labelledby="deleteSignature" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header bg-delete">
                                                                    <h5 class="modal-title text-white" id="deleteSignature">
                                                                        Hapus Tanda Tangan
                                                                    </h5>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="card-body">
                                                                    <p>Apakah anda yakin ingin menghapus tanda tangan
                                                                        <strong>{{ $upload->karyawan->nama_karyawan }}?</strong>
                                                                    </p>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">Close</button>
                                                                    <a href="/admin-worker-officer/delete-signature/{{ $upload->id }}"
                                                                        class="btn btn-delete">Delete</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            @include('sweetalert::alert')
        </div>
    </main>
    {{-- modal upload --}}
    <div class="modal fade" id="uploadSignature" tabindex="-1" aria-labelledby="uploadSignature" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-add">
                    <h5 class="modal-title text-white" id="uploadSignature">Upload Tanda Tangan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('adminwo.upload-signature.uploadSignature') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nik_karyawan" class="form-label">NIK Karyawan</label>
                            <select class="choices form-select" name="nama_karyawan" id="nama_karyawan">
                                <option value="" selected disabled>Pilih NIK Karyawan</option>
                                @foreach ($employes as $employee)
                                    <option value="{{ $employee->nama_karyawan }}">{{ $employee->nik_karyawan }} -
                                        {{ $employee->nama_karyawan }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="text" name="karyawan_id" id="karyawan_id" hidden>
                        </div>
                        <div class="form-group">
                            <label for="nama_karyawan" class="form-label">Nama Karyawan</label>
                            <input type="text" class="form-control" name="nama_karyawan_create"
                                id="nama_karyawan_create" readonly>
                        </div>
                        <div class="form-group">
                            <label for="image" class="form-label">Upload File</label>
                            <input type="file" class="form-control" name="image" id="image"
                                accept="image/png,image/jpeg,image/jpg" />
                            <small class="text-muted">
                                File yang diupload harus berformat .png, .jpg, .jpeg max size 1MB
                            </small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-add">Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- end modal upload --}}
    <script src="/assets/vendors/simple-datatables/simple-datatables.js"></script>
    <script src="/assets/js/vendors.js"></script>
    <script src="/assets/vendors/choices.js/choices.min.js"></script>
    <script src="/assets/js/superadmin/edituser.js"></script>
    <script>
        $('select[id="nama_karyawan"]').change(function() {
            let nama_karyawan = $(this).val();
            $.ajax({
                url: '/admin-worker-officer/get-employee',
                type: 'GET',
                data: {
                    nama_karyawan: nama_karyawan
                },
                success: function(data) {
                    $('#karyawan_id').val(data.id)
                    $('#nama_karyawan_create').val(data.nama_karyawan)
                }
            })
        })
    </script>
@endsection
