@extends('layouts.dashboard')
@section('content')
    <x-page-title>
        <h3 class="text-capitalize">Data Bagian</h3>
        <x-breadcrumb>
            <li class="breadcrumb-item"><a href="/">Admin Work Office</a></li>
            <li class="breadcrumb-item active" aria-current="page">Data Bagian</li>
        </x-breadcrumb>
    </x-page-title>
    <div class="card">
        <div class="card-body">
            <section class="create-bagian">
                <button class="btn btn-add" data-bs-toggle="modal" data-bs-target="#addBagian">
                    <i class="bi bi-plus-circle"></i> Tambah Data Bagian
                </button>
                <div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="addBagian" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header bg-add">
                                <h5 class="modal-title text-white">Tambah Data bagian</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form action="{{ route('adminwo.data-bagian.create') }}" method="POST">
                                @csrf
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="nama_bagian" class="form-label">Nama Bagian</label>
                                        <input type="text" class="form-control" name="nama_bagian" id="nama_bagian">
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
                        <tr>
                            <th>No</th>
                            <th>Nama Bagian</th>
                            <th>Updated by</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bagian as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->nama_bagian }}</td>
                                <td>{{ $item->update_by }}</td>
                                <td class="d-flex gap-2">
                                    <section class="edit-bagian">
                                        <button class="btn btn-edit" data-bs-target="#editBagian{{ $item->id }}"
                                            data-bs-toggle="modal">Edit</button>
                                        <div class="modal fade" id="editBagian{{ $item->id }}" data-bs-backdrop="static"
                                            data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel"
                                            aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-edit">
                                                        <h5 class="modal-title text-dark" id="exampleModalLabel">Edit
                                                            Bagian</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <form action="{{ route('adminwo.data-bagian.edit') }}" method="POST">
                                                        @csrf
                                                        <div class="modal-body">
                                                            <input type="text" name="id" id="id"
                                                                value="{{ $item->id }}" hidden>
                                                            <div class="form-group">
                                                                <label for="nama_bagian" class="form-label">Nama
                                                                    Bagian</label>
                                                                <input type="text" class="form-control"
                                                                    name="nama_bagian" id="nama_bagian"
                                                                    value="{{ $item->nama_bagian }}">
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Kembali</button>
                                                            <button type="submit" class="btn btn-edit">Simpan</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                    <section class="delete-bagian">
                                        <button class="btn btn-delete" data-bs-target="#deleteBagian{{ $item->id }}"
                                            data-bs-toggle="modal">Delete</button>
                                        <div class="modal fade" id="deleteBagian{{ $item->id }}" tabindex="-1"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-delete">
                                                        <h5 class="modal-title text-white" id="exampleModalLabel">Delete
                                                            Bagian
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <form action="{{ route('adminwo.data-bagian.delete') }}"
                                                        method="POST">
                                                        @csrf
                                                        <div class="modal-body">
                                                            <input type="text" name="id" id="id"
                                                                value="{{ $item->id }}" hidden>
                                                            <p class="text-dark">Apakah anda yakin ingin menghapus data
                                                                bagian
                                                                <strong>{{ $item->nama_bagian }}</strong> ini?
                                                            </p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-delete">Delete</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </section>
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
        $('#addBagian').on('shown.bs.modal', function() {
            $('#nama_bagian').trigger('focus')
        })
    </script>
    <script>
        $('#addBagian').on('hidden.bs.modal', function() {
            $('#nama_bagian').val('')
        })
    </script>
@endsection
