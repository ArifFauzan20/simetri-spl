@extends('layouts.dashboard')
@section('content')
    <x-page-title>
        <h3 class="text-capitalize">Preview SPL</h3>
        <x-breadcrumb>
            <li class="breadcrumb-item"><a href="/koordinator">Koordinator</a></li>
            <li class="breadcrumb-item active" aria-current="page">Preview SPL </li>
        </x-breadcrumb>
    </x-page-title>
    <div class="row">
        <div class="col-md-12">
            <a href="/koordinator/export/get-pdf/{{ $detail->spl_id }}" class="btn btn-info mb-3" target="_blank">
                <i class="bi bi-file-earmark-pdf-fill"></i> Download
            </a>
            <div class="card">
                <div class="card-body">
                    <header class="row align-items-center mb-5">
                        <div class="col-md-2">
                            <img src="/assets/images/exports/logo.jpg" alt="logo" class="w-100">
                        </div>
                        <div class="col-md-8">
                            <h1 class="text-uppercase text-dark text-center fs-2"><u>Surat Perintah Lembur</u></h1>
                            <h2 class="text-dark text-center fs-5">SMP/F/U/21 ( REV : 02/ 12 September 2022)</h2>
                        </div>
                        <div class="col-md-2">
                            <img src="/assets/images/exports/logos.jpg" alt="logo" class="w-100">
                        </div>
                    </header>
                    <section class="px-3 mb-4">
                        <p class="text-dark fw-bold">Diperintahkan bekerja lembur pada :</p>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-3">
                                        <span class="text-dark">Hari/Tanggal</span>
                                    </div>
                                    <div class="col-md-1 p-0">
                                        <span class="text-dark">:</span>
                                    </div>
                                    <div class="col-md-8 p-0">
                                        <span
                                            class="text-dark">{{ \Carbon\Carbon::parse($detail->spl->tgl_lembur)->format('d M Y') }}</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <span class="text-dark">Jam</span>
                                    </div>
                                    <div class="col-md-1 p-0">
                                        <span class="text-dark">:</span>
                                    </div>
                                    <div class="col-md-8 p-0">
                                        <span
                                            class="text-dark">{{ \Carbon\Carbon::parse($detail->spl->start_jam)->isoFormat('HH:mm') }}
                                            s/d {{ \Carbon\Carbon::parse($detail->spl->end_jam)->isoFormat('HH:mm') }}
                                        </span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <span class="text-dark">Bagian</span>
                                    </div>
                                    <div class="col-md-1 p-0">
                                        <span class="text-dark">:</span>
                                    </div>
                                    <div class="col-md-8 p-0">
                                        <span class="text-dark">{{ $detail->karyawan->bagian->nama_bagian }}</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <span class="text-dark">Kepada</span>
                                    </div>
                                    <div class="col-md-1 p-0">
                                        <span class="text-dark">:</span>
                                    </div>
                                    <div class="col-md-8 p-0">
                                        <span class="text-dark">{{ $count }} Orang</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <section class="px-3 mb-4">
                        <table class="table">
                            <thead>
                                <tr class="text-dark ">
                                    <th class="border border-2 border-dark">No</th>
                                    <th class="border border-2 border-dark">Nama</th>
                                    <th class="border border-2 border-dark">NIK</th>
                                    <th class="border border-2 border-dark">Nama Proyek</th>
                                    <th class="border border-2 border-dark">Uraian Tugas</th>
                                    <th class="border border-2 border-dark">Pelaksana</th>
                                </tr>
                            </thead>
                            <tbody class="text-dark">
                                @foreach ($details as $item)
                                    <tr>
                                        <td class="border border-2 border-dark">{{ $loop->iteration }}</td>
                                        <td class="border border-2 border-dark">
                                            {{ $item->karyawan->nama_karyawan }}</td>
                                        <td class="border border-2 border-dark">{{ $item->karyawan->nik_karyawan }}</td>
                                        <td class="border border-2 border-dark">{{ $item->spl->nama_proyek }}</td>
                                        <td class="border border-2 border-dark">{{ $item->spl->keterangan }}</td>
                                        <td class="border border-2 border-dark"></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </section>
                    <section class="px-3">
                        <p class="text-dark">Demikian perintah lembur untuk dilaksanakan dengan baik dan dengan penuh
                            tanggung jawab.</p>
                    </section>
                    <section class="px-3">
                        <div class="row">
                            <div class="col-md-6">
                                <p class="text-dark fw-bold">Penanggung Jawab</p>
                            </div>
                            <div class="col-md-6 ">
                                <p class="text-dark fw-bold text-end">Tangerang,
                                    {{ \Carbon\Carbon::parse($detail->spl->tgl_lembur)->format('d M Y') }}</p>
                            </div>
                        </div>
                    </section>
                    <section class="px-3 mb-5">
                        <div class="row">
                            <div class="col-md-4">
                                <p class="text-dark fw-bold">Pemberi Tugas:</p>
                            </div>
                            <div class="col-md-4">
                                <p class="text-dark fw-bold text-center">Supervisor:</p>
                            </div>
                            <div class="col-md-4">
                                <p class="text-dark fw-bold text-end">Menyetujui:</p>
                            </div>
                        </div>
                    </section>
                    <section class="px-3 mb-5 pt-5">
                        <div class="row">
                            <div class="col-md-4">
                                <p class="text-dark fw-bold text-uppercase">
                                    ( {{ auth()->user()->karyawan->nama_karyawan }} )
                                </p>
                            </div>
                            <div class="col-md-4">
                                @foreach ($supervisor as $item)
                                    <p class="text-dark fw-bold text-center">( {{ $item->nama_karyawan }} )</p>
                                @endforeach
                            </div>
                            <div class="col-md-4">
                                @empty($manager)
                                    @foreach ($manager as $item)
                                        <p class="text-dark fw-bold text-end">( {{ $item->nama_karyawan }} )</p>
                                    @endforeach
                                @else
                                    <p class="text-dark fw-bold text-end">( Manager )</p>
                                @endempty
                            </div>
                        </div>
                    </section>

                </div>
            </div>
        </div>
    </div>
@endsection
