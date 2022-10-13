@extends('layouts.dashboard')
@section('content')
    <x-page-title>
        <h3 class="text-capitalize">Pengajuan Lembur</h3>
        <x-breadcrumb>
            <li class="breadcrumb-item"><a href="/koordinator/data-pengajuan">Pengajuan Lembur</a></li>
            <li class="breadcrumb-item active" aria-current="page">Form Pengajuan Lembur</li>
        </x-breadcrumb>
    </x-page-title>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body py-5">
                    <h5 class="card-title px-md-4 px-xl-5 mb-4">Edit Form Pengajuan Lembur</h5>
                    <form action="{{ route('koordinator.update-pengajuan') }}" method="POST">
                        @csrf
                        <div class="row px-md-4 px-xl-5">
                            <div class="col-md-6">
                                <input type="hidden" value="{{ $spl->id }}" name="id" id="id">
                                <section class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="kode_proyek" class="form-label">Pilih Proyek</label>
                                            <select class="choices form-select" id="kode_proyek" name="kode_proyek">
                                                <option value="">Pilih Kode Proyek</option>
                                                <option value="{{ $spl->kode_proyek }}" selected>
                                                    {{ $spl->kode_proyek }} - {{ $spl->nama_proyek }}</option>
                                                @foreach ($projects as $project)
                                                    <option value="{{ $project['PrjName'] }}">{{ $project['PrjCode'] }} -
                                                        {{ $project['PrjName'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </section>
                                <section class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="kode_proyek_input" class="form-label">Kode Proyek</label>
                                            <input type="text"
                                                class="form-control  @error('kode_proyek_input') is-invalid @enderror"
                                                name="kode_proyek_input" id="kode_proyek_input" placeholder="Kode Proyek"
                                                value="{{ $spl->kode_proyek }}" readonly>

                                            @error('kode_proyek_input')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </section>
                                <section class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="nama_proyek_input" class="form-label">Nama Proyek</label>
                                            <input type="text"
                                                class="form-control  @error('nama_proyek_input') is-invalid @enderror"
                                                name="nama_proyek_input" id="nama_proyek_input" placeholder="Nama Proyek"
                                                value="{{ $spl->nama_proyek }}" readonly>

                                            @error('nama_proyek_input')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </section>
                            </div>
                            <section class="col-md-6">
                                <section class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="tgl_lembur" class="form-label mb-3">Start Date</label>
                                            <input type="datetime-local" class="form-control"
                                                @error('tgl_lembur') is-invalid @enderror" name="tgl_lembur" id="tgl_lembur"
                                                value="{{ $spl->tgl_lembur }}">
                                            @error('tgl_lembur')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="end_date" class="form-label mb-3">End Date</label>
                                            <input type="datetime-local" class="form-control"
                                                @error('end_date') is-invalid @enderror" name="end_date" id="end_date"
                                                value="{{ $spl->end_date }}">
                                            @error('end_date')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </section>
                                <section class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="id_jenis_hari" class="form-label">Jenis Hari</label>
                                            <select name="id_jenis_hari" id="id_jenis_hari"
                                                class="form-select @error('id_jenis_hari') is-invalid @enderror">
                                                <option value="" disabled>Pilih Jenis Hari</option>
                                                <option value="0" {{ $spl->id_jenis_hari == 0 ? 'selected' : '' }}>
                                                    Hari Libur</option>
                                                <option value="1" {{ $spl->id_jenis_hari == 1 ? 'selected' : '' }}>
                                                    Hari Kerja</option>
                                            </select>

                                            @error('id_jenis_hari')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </section>
                            </section>
                        </div>
                        <div class="row px-md-4 px-xl-5 mb-4">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="keterangan" class="form-label">Keterangan</label>
                                    <textarea name="keterangan" id="keterangan" cols="30" rows="5" class="form-control">{{ $spl->keterangan }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row px-md-4 px-xl-5">
                            <div class="col-md-12 d-flex justify-content-end ">
                                <div class="form-group">
                                    <a href="/koordinator/data-pengajuan" class="btn btn-light">Kembali</a>
                                    <button type="submit" class="btn btn-add">Simpan</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title my-4">
                        <span class="text-capitalize">Data Pengajuan Lembur</span>
                    </h5>
                    <table class='table table-striped' id="table1">
                        <thead class="text-dark">
                            <tr>
                                <th>No</th>
                                <th>Kode Proyek</th>
                                <th>Jenis Hari</th>
                                <th>Tanggal Lembur</th>
                                <th>Jam Mulai</th>
                                <th>Jam Selesai</th>
                                <th>Istirahat</th>
                                <th>Tanggal Pengajuan</th>
                                <th>Keterangan</th>
                                <th>Updated By</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($spls as $spl)
                                <tr class="text-dark">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $spl->kode_proyek }}</td>
                                    <td class="text-capitalize">
                                        {{ $spl->id_jenis_hari == 1 ? 'Hari Kerja' : 'Hari Libur' }}
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($spl->tgl_lembur)->format('d-m-Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($spl->start_jam)->format('H:i') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($spl->end_jam)->format('H:i') }}</td>
                                    <td>
                                        @if ($spl->istirahat == '1.0')
                                            1 jam
                                        @else
                                            30 menit
                                        @endif
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($spl->tgl_pengajuan)->format('d-m-Y') }}</td>
                                    <td>{{ $spl->keterangan }}</td>
                                    <td>{{ $spl->updated_by }}</td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="/koordinator/data-pengajuan/edit-pengajuan/{{ $spl->id }}"
                                                class="btn btn-edit px-3 py-2">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <button class="btn btn-delete px-3 py-2" data-bs-target="#deletePengajuan"
                                                data-bs-toggle="modal" data-id="{{ $spl->id }}">
                                                <i class="bi bi-trash-fill"></i>
                                            </button>
                                        </div>
                                    </td>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @include('sweetalert::alert')
    </div>
    <div class="modal" id="deletePengajuan" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-delete">
                    <h5 class="modal-title text-white">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="/koordinator/data-pengajuan/delete-pengajuan" method="POST">
                    @csrf
                    <div class="modal-body">
                        <p class="text-dark">Apakah anda yakin ingin menghapus data ini?</p>
                        <input type="text" name="id" id="id" hidden>
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
        $(document).ready(function() {
            $('#deletePengajuan').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget)
                var id = button.data('id')
                var modal = $(this)
                modal.find('#id').val(id)
            })
        })
    </script>
    <script>
        $(document).ready(function() {
            $("select[id='kode_proyek']").change(function() {
                let kode_proyek = $(this).val();
                $.ajax({
                    url: '/koodrinator/find-project/' + kode_proyek,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $("#nama_proyek").val(data[0].PrjName);
                        $("#kode_proyek_input").val(data[0].PrjCode);
                        $("#nama_proyek_input").val(data[0].PrjName);
                    }
                })
            })

        });
    </script>
@endsection
