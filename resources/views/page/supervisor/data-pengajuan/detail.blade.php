@extends('layouts.dashboard')
@section('content')
    <x-page-title>
        <h3 class="text-capitalize">Detail Pengajuan</h3>
        <x-breadcrumb>
            <li class="breadcrumb-item"><a href="#">Detail Pengajuan</a></li>
            <li class="breadcrumb-item active" aria-current="page">Approval</li>
        </x-breadcrumb>
    </x-page-title>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Approval Pengajuan Lembur</h5>
                    <table class="table table-striped">
                        <thead>
                            <tr class="text-dark">
                                <th>No</th>
                                <th>NIK</th>
                                <th>Nama Karyawan</th>
                                <th>Jam Mulai</th>
                                <th>Jam Selesai</th>
                                <th>Lama Lembur</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Tanggal Pengajuan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($details as $data)
                                <tr class="text-dark">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $data->karyawan->nik_karyawan }}</td>
                                    <td>{{ $data->karyawan->nama_karyawan }}</td>
                                    <td>{{ \Carbon\Carbon::parse($data->spl->start_jam)->format('H:i') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($data->spl->end_jam)->format('H:i') }}</td>
                                    <td>{{ $data->lama_lembur }} jam</td>
                                    <td>{{ \Carbon\Carbon::parse($data->spl->tgl_lembur)->format('d/m/Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($data->spl->end_date)->format('d/m/Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($data->spl->tgl_pengajuan)->format('d/m/Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex gap-2 justify-content-end">
                        <a href="{{ route('supervisor.data-pengajuan') }}" class="btn btn-light">Kembali</a>
                        <button class="btn btn-delete" data-bs-target="#rejection" data-bs-toggle="modal"
                            data-id={{ $detail->spl->approval->id }}>Reject</button>
                        <button class="btn btn-add" data-bs-target="#approve" data-bs-toggle="modal"
                            data-id={{ $detail->spl->approval->id }}>Approve</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="approve" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-add">
                    <h5 class="modal-title text-white">Confirmation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('supervisor.approve') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <p>Apakah anda ingin melakukan approval?</p>
                        <input type="hidden" name="id" id="id">
                        <input type="hidden" name="approve" id="approve">
                        <input type="hidden" name="keterangan" id="keterangan">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-add" id="btn_approve">Approve</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="rejection" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-delete">
                    <h5 class="modal-title text-white">Confirmation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('supervisor.reject') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <p>Apakah anda ingin melakukan rejection?</p>
                        <input type="hidden" id="id" name="id">
                        <input type="hidden" id="rejection" name="rejection">
                        <textarea name="keterangan" id="keterangan" cols="30" rows="4" class="form-control"
                            placeholder="Masukan keterangan rejection" required></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-delete">Reject</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#approve').on('show.bs.modal', function(event) {
                let button = $(event.relatedTarget)
                let id = button.data('id')
                let modal = $(this)

                modal.find('#id').val(id)
                modal.find('#approve').val('approve')
                modal.find('#keterangan').val('approve by supervisor')
            })
            $('#rejection').on('show.bs.modal', function(event) {
                let button = $(event.relatedTarget)
                let id = button.data('id')
                let modal = $(this)

                modal.find('#id').val(id)
                modal.find('#rejection').val('rejection by supervisor')
            })
        })
    </script>
@endsection
