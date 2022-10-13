@extends('layouts.dashboard')
@section('content')
    <x-page-title>
        <h3 class="text-capitalize">Divisi</h3>
        <x-breadcrumb>
            <li class="breadcrumb-item"><a href="#">Divisi</a></li>
            <li class="breadcrumb-item active" aria-current="page">Data Divisi</li>
        </x-breadcrumb>
    </x-page-title>
    <div>
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    <button type="button" class="btn icon btn-success" data-bs-toggle="modal" data-bs-target="#create"
                        id="adduser">
                        <i class="bi bi-plus-circle"></i>
                        Tambah Pengguna
                    </button>
                    <!--create theme Modal -->
                    <div class="modal fade text-left" id="create" tabindex="-1" role="dialog"
                        aria-labelledby="myModalLabel160" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header bg-success">
                                    <h5 class="modal-title white" id="myModalLabel160">Tambah Divisi</h5>
                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                        <i data-feather="x"></i>
                                    </button>
                                </div>
                                <form action="/superadmin/division/create" method="POST">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label for="nama_bagian" class="form-label">Nama Divisi</label>
                                                <div class="form-group has-icon-left">
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control" name="nama_bagian"
                                                            id="nama_bagian">
                                                        <div class="form-control-icon">
                                                            <i data-feather="users"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                                            <i class="bx bx-x d-block d-sm-none"></i>
                                            <span class="d-none d-sm-block">Kembali</span>
                                        </button>
                                        <button type="submit" class="btn btn-success ml-1" data-bs-dismiss="modal">
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
                            <th>Nama Divisi</th>
                            <th>Dibuat oleh</th>
                            <th>Tanggal Pembuatan</th>
                            <th>Tanggal Update</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($divisions as $division)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $division->nama_bagian }}</td>
                                <td>{{ $division->update_by }}</td>
                                <td>{{ $division->created_at }}</td>
                                <td>{{ $division->updated_at }}</td>
                                <td>
                                    <button type="button" class="btn icon btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#editdivisi{{ $division->id }}" id="adduser">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    <!--edit Modal -->
                                    <div class="modal fade text-left" id="editdivisi{{ $division->id }}" tabindex="-1"
                                        role="dialog" aria-labelledby="myModalLabel160" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header bg-primary">
                                                    <h5 class="modal-title white" id="myModalLabel160">Edit Divisi</h5>
                                                    <button type="button" class="close" data-bs-dismiss="modal"
                                                        aria-label="Close">
                                                        <i data-feather="x"></i>
                                                    </button>
                                                </div>
                                                <form action="/superadmin/division/update" method="POST">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <input type="hidden" value="{{ $division->id }}"
                                                                name="id" id="id">
                                                            <div class="col-md-12">
                                                                <label for="nik_karyawan" class="form-label">Nama
                                                                    Divisi</label>
                                                                <div class="form-group has-icon-left">
                                                                    <div class="position-relative">
                                                                        <input type="text" class="form-control"
                                                                            name="nama_bagian" id="nama_bagian"
                                                                            value="{{ $division->nama_bagian }}">
                                                                        <div class="form-control-icon">
                                                                            <i data-feather="users"></i>
                                                                        </div>
                                                                    </div>
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
                                    {{-- edit modal --}}
                                    <button type="button" class="btn icon btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#deletedivisi{{ $division->id }}" id="adduser">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                    <!--delete Modal -->
                                    <div class="modal fade text-left" id="deletedivisi{{ $division->id }}"
                                        tabindex="-1" role="dialog" aria-labelledby="myModalLabel160"
                                        aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header bg-danger">
                                                    <h5 class="modal-title white" id="myModalLabel160">Hapus Divisi</h5>
                                                    <button type="button" class="close" data-bs-dismiss="modal"
                                                        aria-label="Close">
                                                        <i data-feather="x"></i>
                                                    </button>
                                                </div>
                                                <form action="/superadmin/division/delete" method="POST">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <p>Apakah anda yakin ingin menghapus divisi
                                                            <strong>
                                                                {{ $division->nama_bagian }}
                                                            </strong>
                                                            ?
                                                        </p>
                                                        <input type="hidden" name="id" id="id"
                                                            value="{{ $division->id }}">
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
                                                            <span class="d-none d-sm-block">Hapus</span>
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- delete modal --}}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @include('sweetalert::alert')
    </div>
    <script src="/assets/vendors/simple-datatables/simple-datatables.js"></script>
    <script src="/assets/js/vendors.js"></script>
    <script src="/assets/vendors/choices.js/choices.min.js"></script>
    <script src="/assets/js/superadmin/edituser.js"></script>
@endsection
