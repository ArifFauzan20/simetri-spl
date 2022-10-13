@extends('layouts.dashboard')
@section('content')
    <x-page-title>
        <h3 class="text-capitalize">Data Pengajuan</h3>
        <x-breadcrumb>
            <li class="breadcrumb-item"><a href="/koordinator/data-pengajuan">Finance</a></li>
            <li class="breadcrumb-item active" aria-current="page">Data pengajuan</li>
        </x-breadcrumb>
    </x-page-title>
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Export Data Perorangan</h5>
                    <form action="/finance/export-one" method="GET">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="" class="form-label">NIK Karyawan</label>
                                    <select class="choices form-select" id="nama_karyawan">
                                        <option value="" selected disabled>Pilih NIK Karyawan</option>
                                        @foreach ($employees as $karyawan)
                                            <option value="{{ $karyawan->nama_karyawan }}">{{ $karyawan->nik_karyawan }} -
                                                {{ $karyawan->nama_karyawan }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="nik" id="nik">
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
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Export to Excel</h5>
                    <form action="{{ route('finance.export-excel') }}" method="get">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="sdate">Start date</label>
                                    <input type="date" class="form-control" name="sdate" id="sdate">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="edate">End date</label>
                                    <input type="date" class="form-control" name="edate" id="edate">
                                </div>
                            </div>
                            <div class="col-md-4 d-flex align-items-center mt-2">
                                <button type="submit" class="btn btn-danger">Download</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Pengajuan Lembur</h5>
                    <table class="table table-striped" id="table1">
                        <thead class="text-dark">
                            <th>No</th>
                            <th>ID SPL</th>
                            <th>Kode Proyek</th>
                            <th>NIK</th>
                            <th>Nama Karyawan</th>
                            <th>Bagian</th>
                            <th>Tanggal Pengajuan</th>
                            <th>Keterangan</th>
                        </thead>
                        <tbody>
                            @foreach ($details as $detail)
                                <tr class="text-dark">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $detail->id_spl }}</td>
                                    <td>{{ $detail->kode_proyek }}</td>
                                    <td>{{ $detail->nik_karyawan }}</td>
                                    <td>{{ $detail->nama_karyawan }}</td>
                                    <td>{{ $detail->nama_bagian }}</td>
                                    <td>{{ \Carbon\Carbon::parse($detail->tgl_pengajuan)->format('d-M-Y') }}</td>
                                    <td>{{ $detail->keterangan }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
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
        $('select[id="nama_karyawan"]').change(function() {
            let nama_karyawan = $(this).val();
            $.ajax({
                url: '/finance/get-employee',
                type: 'GET',
                data: {
                    nama_karyawan: nama_karyawan
                },
                success: function(data) {
                    $('#nik').val(data.nik_karyawan)
                }
            })
        })
    </script>
@endsection
