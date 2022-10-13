@extends('layouts.dashboard')
@section('content')
    <x-page-title>
        <h3 class="text-capitalize">Detail Pengajuan Lembur</h3>
        <x-breadcrumb>
            <li class="breadcrumb-item"><a href="/koordinator/data-pengajuan">Pengajuan Lembur</a></li>
            <li class="breadcrumb-item active" aria-current="page">Detail Pengajuan Lembur</li>
        </x-breadcrumb>
    </x-page-title>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body py-5">
                    <h5 class="card-title px-md-4 px-xl-5 mb-4">Form detail pengajuan</h5>
                    <form action="/koordinator/data-pengajuan/detail-pengajuan/add-list-employee" method="POST">
                        @csrf
                        <div class="row px-md-4 px-xl-5">
                            <input type="text" id="id" name="id" value="{{ $spl->id }}" hidden>
                            <section class="col-md-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="kode_proyek" class="form-label mb-3">Id SPL</label>
                                            <input type="text" name="kode_proyek" id="kode_proyek" class="form-control"
                                                value="{{ $spl->id_spl }}" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="id_jenis_hari" class="form-label">Jenis Hari</label>
                                            <input type="text" name="id_jenis_hari" id="id_jenis_hari"
                                                class="form-control"
                                                value="{{ $spl->id_jenis_hari == 1 ? 'Hari Kerja' : 'Hari Libur' }}"
                                                readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="tgl_lembur" class="form-label">Start Date</label>
                                            <input type="datetime-local" name="tgl_lembur" id="tgl_lembur"
                                                class="form-control" value="{{ $spl->tgl_lembur }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="end_date" class="form-label">End Date</label>
                                            <input type="datetime-local" name="end_date" id="end_date" class="form-control"
                                                value="{{ $spl->end_date }}" readonly>
                                        </div>
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="start_jam" class="form-label">jam mulai</label>
                                            <input type="text" class="form-control" name="start_jam" id="start_jam"
                                                value="{{ Carbon\Carbon::parse($spl->start_jam)->format('H:i') }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="end_jam" class="form-label">jam selesai</label>
                                            <input type="text" name="end_jam" id="end_jam" class="form-control"
                                                value="{{ Carbon\Carbon::parse($spl->end_jam)->format('H:i') }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="lama_lembur" class="form-label">lama lembur</label>
                                            <div class="d-flex align-items-center gap-2">
                                                <input type="text" class="form-control" id="lama_lembur"
                                                    name="lama_lembur" value="{{ $total }}" readonly>
                                                <span>Jam</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <section class="col-md-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="kode_proyek" class="form-label mb-3">Kode Proyek</label>
                                            <input type="text" name="kode_proyek" id="kode_proyek" class="form-control"
                                                value="{{ $spl->kode_proyek }}" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="nik_karyawan" class="form-label">NIK Karyawan</label>
                                            <select class="choices form-select @error('nik_karyawan') is-invalid @enderror"
                                                name="nik_karyawan" id="nik_karyawan">
                                                <option value="" disabled selected>Pilih NIK Karyawan</option>
                                                @foreach ($employees as $employee)
                                                    <option value="{{ $employee->nama_karyawan }}">
                                                        {{ $employee->nik_karyawan }} - {{ $employee->nama_karyawan }} -
                                                        @empty($employee->bagian->nama_bagian)
                                                            -
                                                        @else
                                                            {{ $employee->bagian->nama_bagian }}
                                                        @endempty
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('nik_karyawan')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <input type="text" name="karyawan_id" id="karyawan_id" hidden>
                                <input type="text" name="nik_karyawan_input" id="nik_karyawan_input" hidden>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="nama_karyawan" class="form-label">Nama Karyawan</label>
                                            <input type="text" name="nama_karyawan" id="nama_karyawan"
                                                class="form-control @error('nama_karyawan') is-invalid @enderror" readonly>
                                            @error('nama_karyawan')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="uang_makan" class="form-label">Uang Makan</label>
                                            <input type="text" name="uang_makan" id="uang_makan"
                                                class="form-control @error('uang_makan') is-invalid @enderror"
                                                placeholder="Uang Makan" readonly>
                                            @error('uang_makan')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                            <small class="text-danger" id="note_uang_makan">*Uang makan didapatkan ketika
                                                lama lembur mencapai 4 jam atau lebih</small>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                        <div class="row px-md-4 px-xl-5 mb-4">
                            <section class="col-md-12">
                                <div class="form-group">
                                    <label for="keterangan" class="form-label">Keterangan</label>
                                    <textarea name="keterangan" id="keterangan" class="form-control" cols="30" rows="5" readonly>{{ $spl->keterangan }}</textarea>
                                </div>
                            </section>
                        </div>
                        <div class="row px-md-4 px-xl-5">
                            <div class="col-md-12 d-flex gap-2 justify-content-end">
                                <a href="/koordinator/data-pengajuan" class="btn btn-light">Kembali</a>
                                @empty($approval->status)
                                    <button type="submit" class="btn btn-add">Simpan</button>
                                @else
                                    @if ($approval->status == 3)
                                        <button type="submit" class="btn btn-add ">Simpan</button>
                                    @else
                                        <button type="submit" class="btn btn-add disabled">Simpan</button>
                                    @endif
                                @endempty
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Daftar Lembur Karyawan</h5>
                    <table class='table table-striped' id="table1">
                        <thead class="text-dark">
                            <tr>
                                <th>No</th>
                                <th>NIK</th>
                                <th>Nama Karyawan</th>
                                <th>Bagian</th>
                                <th>Tarif Lembur</th>
                                <th>Lama Lembur</th>
                                <th>Uang Makan</th>
                                <th>Total Tarif Lembur</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($details as $detail)
                                <tr class="text-dark">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $detail->karyawan->nik_karyawan }}</td>
                                    <td class="text-capitalize">{{ $detail->karyawan->nama_karyawan }}</td>
                                    <td>
                                        @empty($detail->karyawan->bagian->nama_bagian)
                                            -
                                        @else
                                            {{ $detail->karyawan->bagian->nama_bagian }}
                                        @endempty
                                    </td>
                                    <td>@currency($detail->karyawan->tarif_lembur)</td>
                                    <td>{{ $detail->lama_lembur }} jam</td>
                                    <td>@currency($detail->uang_makan)</td>
                                    <td>@currency($detail->tarif_total_lembur)</td>
                                    <td>
                                        @empty($approval->status)
                                            <div class="d-flex gap-2">
                                                <button class="btn btn-delete px-3 py-2" data-bs-target="#deleteDetail"
                                                    data-bs-toggle="modal" data-id="{{ $detail->id }}"
                                                    data-idspl={{ $spl->id }}>
                                                    <i class="bi bi-trash-fill"></i>
                                                </button>
                                            </div>
                                        @else
                                            @if ($approval->status == 3)
                                                <div class="d-flex gap-2">
                                                    <button class="btn btn-delete px-3 py-2" data-bs-target="#deleteDetail"
                                                        data-bs-toggle="modal" data-id="{{ $detail->id }}"
                                                        data-idspl={{ $spl->id }}>
                                                        <i class="bi bi-trash-fill"></i>
                                                    </button>
                                                </div>
                                            @else
                                                <div class="d-flex gap-2">
                                                    <button class="btn btn-delete px-3 py-2 disabled"
                                                        data-bs-target="#deleteDetail" data-bs-toggle="modal"
                                                        data-id="{{ $detail->id }}" data-idspl={{ $spl->id }}>
                                                        <i class="bi bi-trash-fill"></i>
                                                    </button>
                                                </div>
                                            @endif
                                        @endempty
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
    </div>
    <div class="modal fade" id="deleteDetail" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-delete">
                    <h5 class="modal-title text-white">Konfirmasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('koordinator.delete-list-employee') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <p class="text-dark">Apakah anda yakin ingin menghapus data ini?</p>
                        <input type="text" name="id_delete" id="id_delete" hidden>
                        <input type="text" name="id_spl" id="id_spl" hidden>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
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
        $('#note_uang_makan').hide();
        $("select[id='nik_karyawan']").change(function() {
            let nama_karyawan = $(this).val();
            let nik_karyawan = $(this).children("option:selected").text();
            nik_karyawan = nik_karyawan.split(' ');
            nik_karyawan = nik_karyawan[56];
            $.ajax({
                url: '/koordinator/getEmployee',
                type: 'GET',
                data: {
                    nama_karyawan: nama_karyawan,
                    nik_karyawan: nik_karyawan,
                    id_spl: {{ $spl->id }}
                },
                success: function(data) {
                    $('#nama_karyawan').val(data.employee.nama_karyawan).prop('readonly', true);
                    $('#karyawan_id').val(data.employee.id);
                    $('#uang_makan').val(data.employee.uang_makan);
                    $('#nik_karyawan_input').val(data.employee.nik_karyawan);
                    if (data.employee.uang_makan == "0") {
                        $('#note_uang_makan').show();
                    }
                }
            })
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#deleteDetail').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget)
                var id = button.data('id')
                var idSpl = button.data('idspl')
                var modal = $(this)
                modal.find('#id_delete').val(id)
                modal.find('#id_spl').val(idSpl)
            })
        })
    </script>
@endsection
