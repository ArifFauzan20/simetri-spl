@extends('layouts.dashboard')
@section('content')
    <x-page-title>
        <h3 class="text-capitalize">Edit Detail Pengajuan Lembur</h3>
        <x-breadcrumb>
            <li class="breadcrumb-item"><a href="/koordinator/data-pengajuan">Pengajuan Lembur</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Detail Pengajuan Lembur</li>
        </x-breadcrumb>
    </x-page-title>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body py-5">
                    <h5 class="card-title px-md-4 px-xl-5 mb-4">Form edit detail pengajuan</h5>
                    <form action="{{ route('koordinator.update-list-employee') }}" method="POST">
                        @csrf
                        <div class="row px-md-4 px-xl-5">
                            <input type="text" id="id" name="id" value="{{ $spl->id }}" hidden>
                            <input type="text" id="id_detail" name="id_detail" value="{{ $detail->id }}" hidden>
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
                                            <label for="id_jenis_hari" class="form-label">Jenis Hari</label>
                                            <input type="text" name="id_jenis_hari" id="id_jenis_hari"
                                                class="form-control"
                                                value="{{ $spl->id_jenis_hari == 1 ? 'Hari Kerja' : 'Hari Libur' }}"
                                                readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="tgl_lembur" class="form-label">Tanggal Lembur</label>
                                            <input type="date" name="tgl_lembur" id="tgl_lembur" class="form-control"
                                                value="{{ $spl->tgl_lembur }}" readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="start_jam" class="form-label">jam mulai</label>
                                            <input type="time" class="form-control" name="start_jam" id="start_jam"
                                                value="{{ $spl->start_jam }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="end_jam" class="form-label">jam selesai</label>
                                            <input type="time" name="end_jam" id="end_jam" class="form-control"
                                                value="{{ $spl->end_jam }}" readonly>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <section class="col-md-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="nik_karyawan" class="form-label mb-3">NIK Karyawan</label>
                                            <input type="text" class="form-control" name="nik_karyawan" id="nik_karyawan"
                                                value="{{ $detail->karyawan->nik_karyawan }}" readonly>
                                            @error('nik_karyawan')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <input type="text" name="karyawan_id" id="karyawan_id"
                                    value="{{ $detail->karyawan_id }}" hidden>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="nama_karyawan" class="form-label">Nama Karyawan</label>
                                            <input type="text" name="nama_karyawan" id="nama_karyawan"
                                                class="form-control @error('nama_karyawan') is-invalid @enderror" readonly
                                                value="{{ $detail->karyawan->nama_karyawan }}">
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
                                                placeholder="Uang Makan" value="{{ $detail->uang_makan }}">
                                            @error('uang_makan')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
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
                                <button type="submit" class="btn btn-add">Simpan</button>
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
                                        <div class="d-flex gap-2">
                                            <a href="/koordinator/data-pengajuan/detail-pengajuan/{{ $spl->id }}/edit-list/{{ $detail->id }}"
                                                class="btn btn-edit px-3 py-2">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <button class="btn btn-delete px-3 py-2" data-bs-target="#deleteDetail"
                                                data-bs-toggle="modal" data-id="{{ $detail->id }}"
                                                data-idspl={{ $spl->id }}>
                                                <i class="bi bi-trash-fill"></i>
                                            </button>
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
    </div>
    <script src="/assets/vendors/simple-datatables/simple-datatables.js"></script>
    <script src="/assets/js/vendors.js"></script>
    <script src="/assets/vendors/choices.js/choices.min.js"></script>
    <script src="/assets/js/superadmin/edituser.js"></script>
@endsection
