@extends('layouts.dashboard')
@section('content')
    <x-page-title>
        <h3 class="text-capitalize">Uang Makan</h3>
        <x-breadcrumb>
            <li class="breadcrumb-item"><a href="#">Admin Work Office</a></li>
            <li class="breadcrumb-item active" aria-current="page">Uang Makan</li>
        </x-breadcrumb>
    </x-page-title>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <button class="btn btn-add d-flex gap-2" data-bs-target="#addUangMakan" data-bs-toggle="modal"><i
                            class="bi bi-cash"></i>Tambah Uang Makan
                    </button>
                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr class="text-dark">
                                <th>No</th>
                                <th>Status</th>
                                <th>Uang Makan</th>
                                <th>Updated By</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($uang_makan as $item)
                                <tr class="text-dark">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        @switch($item->status)
                                            @case(1)
                                                Karyawan Tetap
                                            @break

                                            @case(2)
                                                Karyawan Kontrak
                                            @break

                                            @case(3)
                                                Karyawan Harian
                                            @break

                                            @default
                                                Status tidak diketahui
                                        @endswitch
                                    </td>
                                    <td>@currency($item->uang_makan)</td>
                                    <td>
                                        @switch($item->updated_by)
                                            @case(1)
                                                Superadmin
                                            @break

                                            @case(2)
                                                Supervisor
                                            @break

                                            @case(3)
                                                Head Production
                                            @break

                                            @case(4)
                                                Finance
                                            @break

                                            @case(5)
                                                Admin Workshop
                                            @break

                                            {{ $item->updated_by }}

                                            @default
                                        @endswitch
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d-M-Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->updated_at)->format('d-M-Y') }}</td>
                                    <td>
                                        <button class="btn btn-edit" data-bs-target="#editUangMakan" data-bs-toggle="modal"
                                            data-id="1" data-uang="{{ $item->uang_makan }}"
                                            data-status="{{ $item->status }}">Edit</button>
                                        <button class="btn btn-delete" data-bs-target="#deleteUangMakan"
                                            data-bs-toggle="modal" data-id="{{ $item->id }}">Delete</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @include('sweetalert::alert')
    </div>
    <div class="modal fade" id="addUangMakan" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-add">
                    <h5 class="modal-title text-white">Tambah Uang Makan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('adminwo.uang-makan.create') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="status_kontrak" class="form-label">Status Kontrak</label>
                                    <select name="status_kontrak" id="status_kontrak" class="form-select">
                                        <option value="" selected disabled>Pilih Status Kontrak</option>
                                        <option value="1">Karyawan Tetap</option>
                                        <option value="2">Karyawan Kontrak</option>
                                        <option value="3">Karyawan Harian</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="uang_makan" class="form-label">Uang Makan</label>
                                    <input type="number" class="form-control" name="uang_makan" id="uang_makan"
                                        placeholder="Uang Makan">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editUangMakan" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-edit">
                    <h5 class="modal-title text-dark">Edit Uang Makan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('adminwo.uang-makan.edit') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="id" id="id">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="status_kontrak" class="form-label">Status Kontrak</label>
                                    <select name="status_kontrak" id="status_kontrak" class="form-select">
                                        <option value="" selected disabled>Pilih Status Kontrak</option>
                                        <option value="1">Karyawan Tetap</option>
                                        <option value="2">Karyawan Kontrak</option>
                                        <option value="3">Karyawan Harian</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="uang_makan" class="form-label">Uang Makan</label>
                                    <input type="number" class="form-control" name="uang_makan" id="uang_makan"
                                        placeholder="Uang Makan">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
                        <button type="submit" class="btn btn-edit">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="deleteUangMakan" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-delete">
                    <h5 class="modal-title text-white">Delete Uang Makan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('adminwo.uang-makan.delete') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="id" id="id">
                        <p class="text-dark">Apakah anda yakin ingin menghapus data ini?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
                        <button type="submit" class="btn btn-delete">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="/assets/vendors/simple-datatables/simple-datatables.js"></script>
    <script src="/assets/js/vendors.js"></script>
    <script src="/assets/vendors/choices.js/choices.min.js"></script>
    <script src="/assets/js/superadmin/edituser.js"></script>
    <script>
        $('#editUangMakan').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var modal = $(this)
            modal.find('#id').val(button.data('id'))
            modal.find('#status_kontrak').val(button.data('status'))
            modal.find('#uang_makan').val(button.data('uang'))
        })
    </script>
    <script>
        $('#deleteUangMakan').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var modal = $(this)
            modal.find('#id').val(button.data('id'))
        })
    </script>
@endsection
