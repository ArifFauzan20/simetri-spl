@extends('layouts.dashboard')
@section('content')
    <x-page-title>
        <h3 class="text-capitalize">Data Pengajuan Lembur</h3>
        <x-breadcrumb>
            <li class="breadcrumb-item"><a href="#">Data Pengajuan Lembur</a></li>
            <li class="breadcrumb-item active" aria-current="page">Approval</li>
        </x-breadcrumb>
    </x-page-title>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Data Pengajuan</h5>
                    <table class="table table-striped" id="table1">
                        <thead class="text-dark">
                            <tr>
                                <th>No</th>
                                <th>ID SPL</th>
                                <th>Kode Proyek</th>
                                <th>Nama Proyek</th>
                                <th>Tanggal Pengajuan</th>
                                <th>Tanggal Lembur</th>
                                <th>Bagian</th>
                                <th>Status Pengajuan</th>
                                <th>Keterangan</th>
                                <th>Updated By</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-dark">
                            @foreach ($data_approval as $data)
                                <tr class="text-dark">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $data->id_spl }}</td>
                                    <td>{{ $data->kode_proyek }}</td>
                                    <td>{{ $data->nama_proyek }}</td>
                                    <td>{{ Carbon\Carbon::parse($data->tgl_pengajuan)->format('d/m/Y') }}</td>
                                    <td>{{ Carbon\Carbon::parse($data->tgl_lembur)->format('d/m/Y') }}</td>
                                    @foreach ($bagian as $item)
                                        @if ($data->updated_by_bagian == $item->id)
                                            <td>{{ $item->nama_bagian }}</td>
                                        @endif
                                    @endforeach
                                    <td>

                                        @switch($data->status)
                                            @case(2)
                                                <span class="badge bg-approved">Approved</span>
                                            @break

                                            @case(3)
                                                <span class="badge bg-rejected">Rejected by SPV</span>
                                            @break

                                            @case(4)
                                                <span class="badge bg-rejected">Rejected by Manager</span>
                                            @break

                                            @case(5)
                                                <span class="badge bg-waiting">Waiting Approval SPV</span>
                                            @break

                                            @case(6)
                                                <span class="badge bg-waiting">Waiting Approval Head</span>
                                            @break

                                            @default
                                        @endswitch
                                    </td>
                                    <td>{{ $data->keterangan }}</td>
                                    <td>{{ $data->updated_by }}</td>
                                    <td>
                                        @empty($data->tgl_approval_spv)
                                            @if ($data->status == 5)
                                                <a href="/supervisor/detail-data/{{ $data->id }}"
                                                    class="btn btn-add">Detail</a>
                                            @elseif($data->satatus = 2)
                                                <button class="btn btn-success" disabled>Disetujui</button>
                                            @else
                                                <a href="/supervisor/detail-data/{{ $data->id }}"
                                                    class="btn btn-delete disabled">Rejected</a>
                                            @endif
                                        @else
                                            <a href="/supervisor/detail-data/{{ $data->id }}"
                                                class="btn btn-success disabled">Disetujui</a>
                                        @endempty
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="modal fade" id="showData" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-add">
                        <h5 class="modal-title text-white">Detail Approval</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="text" id="id_proyek" name="id_proyek">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Kembali</button>
                        <button type="button" class="btn btn-add" data-bs-toggle="modal"
                            data-bs-target="#approved">Approve</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="approved" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-edit">
                        <h5 class="modal-title text-dark">Approved Confirmation</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Modal body text goes here.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Kembali</button>
                        <button type="button" class="btn btn-edit">Approve</button>
                    </div>
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
            $('#detail').on('click', function() {
                let id = $(this).data('id');
                // let url = '/supervisor/detail-data/' + id;
                // $.ajax({
                //     url: url,
                //     type: 'GET',
                //     dataType: 'json',
                //     success: function(data) {
                //         $('#showData').modal('show');
                //         $('#id_proyek').val(data.detail[0].id);
                //     }
                // });
            });
        });
    </script>
@endsection
