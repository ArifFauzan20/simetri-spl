@extends('layouts.dashboard')
@section('content')
    <x-page-title>
        <h3 class="text-capitalize">Konfirmasi Pengajuan Lembur</h3>
    </x-page-title>
    <form action="{{ route('koordinator.approve') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-5">
                            <h5 class="card-title mb-3">Data Pengajuan Lembur</h5>
                            <div class="col-md-6">
                                <div class="row g-2 align-items-center">
                                    <div class="col-md-3">
                                        <label for="kode_proyek" class="col-form-label text-dark">Kode Proyek</label>
                                    </div>
                                    <div class="col-md-1">:</div>
                                    <div class="col-md-8">
                                        <input type="text" class="form-input-custom" name="kode_proyek" id="kode_proyek"
                                            value="{{ $spl->kode_proyek }}" readonly>
                                    </div>
                                </div>
                                <input type="text" value="{{ $spl->id_spl }}" name="id_spl" id="id_spl" hidden>
                                <div class="row g-2 align-items-center">
                                    <div class="col-md-3">
                                        <label for="jenis_hari" class="col-form-label text-dark">Jenis Hari</label>
                                    </div>
                                    <div class="col-md-1">:</div>
                                    <div class="col-md-8">
                                        <input type="text" class="form-input-custom" name="jenis_hari" id="jenis_hari"
                                            value="{{ $spl->id_jenis_hari == 0 ? 'Hari Libur' : 'Hari Kerja' }}" readonly>
                                    </div>
                                </div>
                                <div class="row g-2 align-items-center">
                                    <div class="col-md-3">
                                        <label for="tgl_pengajuan" class="col-form-label text-dark">Tanggal
                                            Pengajuan</label>
                                    </div>
                                    <div class="col-md-1">:</div>
                                    <div class="col-md-8">
                                        <input type="text" class="form-input-custom" name="tgl_pengajuan"
                                            id="tgl_pengajuan"
                                            value="{{ \Carbon\Carbon::parse($spl->tgl_pengajuan)->format('l, d M Y') }}"
                                            readonly>
                                    </div>
                                </div>
                                <div class="row g-2 align-items-center">
                                    <div class="col-md-3">
                                        <label for="jenis_hari" class="col-form-label text-dark">Keterangan</label>
                                    </div>
                                    <div class="col-md-1">:</div>
                                    <div class="col-md-8">
                                        <input type="text" class="form-input-custom" name="keterangan" id="keterangan"
                                            value="{{ $spl->keterangan }}" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row g-2 align-items-center">
                                    <div class="col-md-3">
                                        <label for="kode_proyek" class="col-form-label text-dark">Nama Proyek</label>
                                    </div>
                                    <div class="col-md-1">:</div>
                                    <div class="col-md-8">
                                        <textarea name="nama_proyek" id="nama_proyek" class="form-input-custom" cols="70" rows="1" readonly>{{ $spl->nama_proyek }}</textarea>
                                    </div>
                                </div>
                                <div class="row g-2 align-items-center">
                                    <div class="col-md-3">
                                        <label for="tgl_lembur" class="col-form-label text-dark">Start Date </label>
                                    </div>
                                    <div class="col-md-1">:</div>
                                    <div class="col-md-8 d-flex">
                                        <input type="text" class="form-input-custom" name="tgl_lembur" id="tgl_lembur"
                                            value="{{ Carbon\Carbon::parse($spl->tgl_lembur)->isoFormat('D/M/Y') }}"
                                            readonly>
                                    </div>
                                </div>
                                <div class="row g-2 align-items-center">
                                    <div class="col-md-3">
                                        <label for="tgl_lembur" class="col-form-label text-dark">End
                                            Date</label>
                                    </div>
                                    <div class="col-md-1">:</div>
                                    <div class="col-md-8 d-flex">
                                        <input type="text" class="form-input-custom" name="tgl_lembur" id="tgl_lembur"
                                            value="{{ Carbon\Carbon::parse($spl->end_date)->isoFormat('D/M/Y') }}" readonly>
                                    </div>
                                </div>
                                <div class="row g-2 align-items-center">
                                    <div class="col-md-3">
                                        <label for="start_jam" class="col-form-label text-dark">Waktu Mulai</label>
                                    </div>
                                    <div class="col-md-1">:</div>
                                    <div class="col-md-8">
                                        <input type="text" class="form-input-custom" name="start_jam" id="start_jam"
                                            value="{{ Carbon\Carbon::parse($spl->start_jam)->format('H:i') }}" readonly>
                                    </div>
                                </div>
                                <div class="row g-2 align-items-center">
                                    <div class="col-md-3">
                                        <label for="end_jam" class="col-form-label text-dark">Waktu Selesai</label>
                                    </div>
                                    <div class="col-md-1">:</div>
                                    <div class="col-md-8">
                                        <input type="text" class="form-input-custom" name="end_jam" id="end_jam"
                                            value="{{ Carbon\Carbon::parse($spl->end_jam)->format('H:i') }}" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <h5 class="card-title mb-3">List Karyawan</h5>
                                <table class="table table-striped" id="table1">
                                    <thead class="text-dark">
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col">NIK</th>
                                            <th scope="col">Nama Karyawan</th>
                                            <th scope="col">Lama Lembur</th>
                                            <th scope="col">Uang Makan</th>
                                            <th scope="col">Tarif Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($details as $detail)
                                            <tr class="text-dark">
                                                <th scope="row">{{ $loop->iteration }}</th>
                                                <td>{{ $detail->karyawan->nik_karyawan }}</td>
                                                <td>{{ $detail->karyawan->nama_karyawan }}</td>
                                                <td>{{ $detail->lama_lembur }} jam</td>
                                                <td>@currency($detail->uang_makan)</td>
                                                <td>@currency($detail->tarif_total_lembur)</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 d-flex gap-2 justify-content-end">
                                <a href="{{ route('koordinator.data-pengajuan') }}" class="btn btn-light">Kembali</a>
                                <button type="button" class="btn btn-add" data-bs-toggle="modal"
                                    data-bs-target="#sendApproval">Kirim</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="modal fade" id="sendApproval" tabindex="-1" aria-labelledby="sendApproval" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-primary">
                            <h5 class="modal-title text-white">Konfirmasi</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Apakah anda yakin ingin mengirimkan data pengajuan lembur ini?</p>
                            <input type="hidden" name="spl_id" id="spl_id" value="{{ $detailspl->spl_id }}">
                            @empty($approval->id)
                            @else
                                <input type="hidden" name="approval_id" id="approval_id" value="{{ $approval->id }}">
                            @endempty

                            @empty($approval->status)
                            @else
                                <textarea name="keterangan" id="keterangan" cols="30" rows="3" class="form-control"
                                    placeholder="Masukan keterangan perbaruan data"></textarea>
                            @endempty
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Kembali</button>
                            <button type="submit" class="btn btn-primary">Kirim</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </form>
    <script src="/assets/vendors/simple-datatables/simple-datatables.js"></script>
    <script src="/assets/js/vendors.js"></script>
    <script src="/assets/vendors/choices.js/choices.min.js"></script>
    <script src="/assets/js/superadmin/edituser.js"></script>
@endsection
