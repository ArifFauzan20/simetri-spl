@extends('layouts.dashboard')
@section('content')
    <x-page-title>
        <h3 class="text-capitalize">Tambah Data Labour</h3>
        <x-breadcrumb>
            <li class="breadcrumb-item"><a href="/admin-worker-officer/data-labour">Admin Work Office</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tambah Data Labour</li>
        </x-breadcrumb>
    </x-page-title>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card py-4 px-3">
                <div class="card-body container">
                    <form action="/admin-worker-officer/create-labour-action" method="POST">
                        @csrf
                        <h5 class="card-title text-primary fs-2 mb-4">Form Tambah Labour</h5>
                        <div class="row mb-2">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="bagian_id">NIK</label>
                                    <select class="choices form-select @error('nik_karyawan_select') is-invalid @enderror"
                                        name="nik_karyawan_select" id="nik_karyawan_select">
                                        <option value="" selected disabled>Pilih Bagian Karyawan</option>
                                        @foreach ($labours as $labour)
                                            <option value="{{ $labour['Nama'] }}"> {{ $labour['NIK'] }} -
                                                {{ $labour['Nama'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('nik_karyawan_select')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <input type="text" name="nik_karyawan" id="nik_karyawan" hidden>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nama_karyawan" class="form-label">Nama Karyawan</label>
                                    <input type="text" class="form-control @error('nama_karyawan') is-invalid @enderror"
                                        name="nama_karyawan" id="nama_karyawan" placeholder="Nama Karyawan"
                                        value="{{ old('nama_karyawan') }}" required readonly>
                                    @error('nama_karyawan')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="bagian_id">Department / Bagian</label>
                                    <select class="choices form-select @error('bagian_id') is-invalid @enderror"
                                        name="bagian_id" id="bagian_id">
                                        <option value="" selected disabled>Pilih Bagian Karyawan</option>
                                        @foreach ($departments as $department)
                                            <option value="{{ $department->id }}">{{ $department->nama_bagian }}</option>
                                        @endforeach
                                    </select>
                                    @error('bagian_id')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row mb-5">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status_kontrak" class="form-group">Status Kontrak</label>
                                    <select name="status_kontrak" id="status_kontrak"
                                        class="form-select @error('status_kontrak') is-invalid @enderror">
                                        <option selected disabled>Pilih status kontrak</option>
                                        <option value="harian">Harian</option>
                                        <option value="kontrak">Kontrak</option>
                                        <option value="tetap">Tetap</option>
                                    </select>
                                    @error('status_kontrak')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tarif_lembur" class="form-group">Tarif Lembur</label>
                                    <input type="text" class="form-control @error('tarif_lembur') is-invalid @enderror "
                                        name="tarif_lembur" id="tarif_lembur" placeholder="Tarif Lembur">
                                    @error('tarif_lembur')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row
                                        float-end">
                            <div class="col-md-12">
                                <a href="/admin-worker-officer/data-labour" class="btn btn-light">
                                    Kembali
                                </a>
                                <button type="submit" class="btn btn-info">
                                    Simpan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    </div>
    <script src="/assets/vendors/choices.js/choices.min.js"></script>
    <script src="/assets/js/superadmin/edituser.js"></script>
    <script>
        $(document).ready(function() {
            $("select[id='nik_karyawan_select']").change(function() {
                let nama_karyawan = $(this).val();
                let nik_karyawan = $(this).children("option:selected").text();
                nik_karyawan = nik_karyawan.split(" ")
                nik_karyawan = nik_karyawan[1]
                $.ajax({
                    url: '/admin-worker-officer/get-labour/' + nama_karyawan + '/' + nik_karyawan,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        // console.log(data);
                        $("#nik_karyawan").val(data[0].NIK);
                        $("#nama_karyawan").val(data[0].Nama);
                    }
                })
            })

        });
    </script>
@endsection
