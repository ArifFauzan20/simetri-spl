@extends('layouts.dashboard')
@section('content')
    <x-page-title>
        <h3 class="text-capitalize">Pengajuan Lembur</h3>
        <x-breadcrumb>
            <li class="breadcrumb-item"><a href="#">Koordinator</a></li>
            <li class="breadcrumb-item active" aria-current="page">Data Pengajuan Lembur</li>
        </x-breadcrumb>
    </x-page-title>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">
                        <a href="/koordinator/data-pengajuan/buat-pengajuan-lembur" class="btn btn-add">
                            <i class="bi bi-person-plus"></i>
                            Pengajuan Lembur
                        </a>
                    </h4>
                    <table class='table table-striped' id="table1">
                        <thead class="text-dark">
                            <tr>
                                <th>ID SPL</th>
                                <th>Kode Proyek</th>
                                <th>Nama Proyek</th>
                                <th>Jenis Hari</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Tanggal Pengajuan</th>
                                <th>Status Pengajuan</th>
                                <th>Keterangan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($spls as $spl)
                                <tr class="text-dark">
                                    <td>{{ $spl->id_spl }}</td>
                                    <td>{{ $spl->kode_proyek }}</td>
                                    <td>{{ $spl->nama_proyek }}</td>
                                    <td class="text-capitalize">{{ $spl->id_jenis_hari == 1 ? 'Hari Kerja' : 'Hari Libur' }}
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($spl->tgl_lembur)->format('d/m/y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($spl->end_date)->format('d/m/y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($spl->tgl_pengajuan)->format('d/m/y') }}</td>
                                    @empty($spl->approval->status)
                                        <td>
                                            <span class="badge bg-notsend">
                                                Pengajuan belum dikirimkan
                                            </span>
                                        </td>
                                    @else
                                        @switch($spl->approval->status)
                                            @case(2)
                                                <td>
                                                    <span class="badge bg-approved">Approved</span>
                                                </td>
                                            @break

                                            @case(3)
                                                <td>
                                                    <span class="badge bg-rejected">Rejected by SPV</span>
                                                </td>
                                            @break

                                            @case(4)
                                                <td>
                                                    <span class="badge bg-rejected">Reject By Manager</span>
                                                </td>
                                            @break

                                            @case(5)
                                                <td>
                                                    <span class="badge bg-waiting">Waiting Approval SPV</span>
                                                </td>
                                            @break

                                            @case(6)
                                                <td>
                                                    <span class="badge bg-waiting">Waiting Approval Head</span>
                                                </td>
                                            @break

                                            @default
                                        @endswitch
                                    @endempty
                                    <td>
                                        @empty($spl->approval->keterangan)
                                            -
                                        @else
                                            {{ $spl->approval->keterangan }}
                                        @endempty
                                    </td>
                                    <td>
                                        @empty($spl->approval->status)
                                            <div class="d-flex gap-2">
                                                <a href="/koordinator/data-pengajuan/detail-pengajuan/{{ $spl->id }}"
                                                    class="btn btn-info">Detail</a>
                                                <a href="/koordinator/data-pengajuan/edit-pengajuan/{{ $spl->id }}"
                                                    class="btn btn-edit">Edit</a>
                                                <a href="/koordinator/konfirmasi-pengajuan/{{ $spl->id }}"
                                                    class="btn btn-kirim">Kirim</a>
                                            </div>
                                        @else
                                            @if ($spl->approval->status == 3)
                                                <div class="d-flex gap-2">
                                                    <a href="/koordinator/data-pengajuan/detail-pengajuan/{{ $spl->id }}"
                                                        class="btn btn-info">Detail</a>
                                                    <a href="/koordinator/data-pengajuan/edit-pengajuan/{{ $spl->id }}"
                                                        class="btn btn-edit">Edit</a>
                                                    <a href="/koordinator/konfirmasi-pengajuan/{{ $spl->id }}"
                                                        class="btn btn-kirim">Kirim</a>
                                                </div>
                                            @elseif ($spl->approval->status == 4)
                                                <div class="d-flex gap-2">
                                                    <a href="/koordinator/data-pengajuan/detail-pengajuan/{{ $spl->id }}"
                                                        class="btn btn-info">Detail</a>
                                                    <a href="/koordinator/data-pengajuan/edit-pengajuan/{{ $spl->id }}"
                                                        class="btn btn-edit">Edit</a>
                                                    <a href="/koordinator/konfirmasi-pengajuan/{{ $spl->id }}"
                                                        class="btn btn-kirim">Kirim</a>
                                                </div>
                                            @else
                                                <div class="d-flex gap-2">
                                                    <button class="btn btn-sent" disabled>Terkirim</button>
                                                    <a href="/koordinator/export/pdf/{{ $spl->id }}" class="btn btn-dark">
                                                        <i class="bi bi-printer fs-5"></i>
                                                    </a>
                                                </div>
                                            @endif
                                        @endempty
                                    </td>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Export Data Perorangan Excel</h5>
                    <form action="/koordinator/data-pengajuan/exportKoordinator" method="GET">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                {{-- <div class="form-group">
                                    <label for="" class="form-label">NIK Karyawan</label>
                                    <select class="choices form-select" id="nama_karyawan">
                                        <option value="" selected disabled>Pilih NIK Karyawan</option>
                                        @foreach ($employees as $karyawan)
                                            <option value="{{ $karyawan->nama_karyawan }}">{{ $karyawan->nik_karyawan }} -
                                                {{ $karyawan->nama_karyawan }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div> --}}
                                <div class="form-group">
                                    <label for="" class="mb-2">{{ Auth()->user()->karyawan->nama_karyawan }}</label>
                                    <input type="text" class="form-control" name="updated_by" id="updated_by" >
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="sdate">Start date</label>
                                    <input type="date" class="form-control" name="sdate" id="sdate">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="edate">End date</label>
                                    <input type="date" class="form-control" name="edate" id="edate">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-danger">Download</button>
                            </div>
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
    {{-- <script>
        $('select[id="nama_karyawan"]').change(function() {
            let nama_karyawan = $(this).val();
            $.ajax({
                url: '/koordinator/data-pengajuan/get-employee',
                type: 'GET',
                data: {
                    nama_karyawan: nama_karyawan
                },
                success: function(data) {
                    $('#nik').val(data.nik_karyawan)
                }
            })
        })
    </script> --}}
@endsection
