@extends('layouts.dashboard')
@section('content')
    <x-page-title>
        <h3 class="text-capitalize">Data Labour</h3>
        <x-breadcrumb>
            <li class="breadcrumb-item"><a href="#">Admin Work Office</a></li>
            <li class="breadcrumb-item active" aria-current="page">Data Labour</li>
        </x-breadcrumb>
    </x-page-title>
    <div class="card">
        <div class="card-body">
            <div class="card-title">
                <a href="/admin-worker-officer/create-labour" class="btn btn-add"><i class="bi bi-plus-circle"></i> Tambah
                    Data Labour</a>
            </div>
            <table class='table table-striped' id="table1">
                <thead>
                    <tr>
                        <th class="text-dark">No</th>
                        <th class="text-dark">NIK</th>
                        <th class="text-dark">Nama Karyawan</th>
                        <th class="text-dark">Bagian</th>
                        <th class="text-dark">Tarif Lembur</th>
                        <th class="text-dark">Status Karyawan</th>
                        <th class="text-dark">Updated by</th>
                        <th class="text-dark">Created at</th>
                        <th class="text-dark">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($labours as $labour)
                        <tr class="text-dark">
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $labour->nik_karyawan }}</td>
                            <td>{{ $labour->nama_karyawan }}</td>
                            <td>
                                @empty($labour->bagian->nama_bagian)
                                    -
                                @else
                                    {{ $labour->bagian->nama_bagian }}
                                @endempty
                            </td>
                            <td>@currency($labour->tarif_lembur)</td>
                            <td>{{ $labour->status_kontrak }}</td>
                            <td>{{ $labour->update_by }}</td>
                            <td>{{ \Carbon\Carbon::parse($labour->created_at)->format('l d-m-Y') }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-1">
                                    <a href="/admin-worker-officer/edit-labour/{{ $labour->id }}" class="btn btn-edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <a href="#" class="btn btn-delete" data-bs-target="#modalDelete"
                                        data-bs-toggle="modal" data-id={{ $labour->id }}>
                                        <i class="bi bi-trash-fill"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="modal fade" id="modalDelete" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-delete">
                        <h5 class="modal-title text-white">Delete Labour</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="/admin-worker-officer/delete-labour" method="POST">
                        @csrf
                        <div class="modal-body">
                            <input type="text" name="id" id="id" hidden>
                            <p>Apakah anda yakin ingin menghapus data ini?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
                            <button type="submit" class="btn btn-delete">Hapus</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        @include('sweetalert::alert')
    </div>
    <script src="/assets/vendors/simple-datatables/simple-datatables.js"></script>
    <script src="/assets/js/vendors.js"></script>
    <script src="/assets/vendors/choices.js/choices.min.js"></script>
    <script src="/assets/js/superadmin/edituser.js"></script>
    <script>
        $(document).ready(function() {
            $('#modalDelete').on('show.bs.modal', function(e) {
                var id = $(e.relatedTarget).data('id')
                var modal = $(this)

                modal.find('#id').val(id)
            })
        })
    </script>
@endsection
