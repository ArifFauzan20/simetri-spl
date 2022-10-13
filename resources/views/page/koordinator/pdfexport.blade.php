<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="{{ public_path('bootstrap.min.css') }}">
    {{-- <link rel="stylesheet" href="/assets/css/export.css"> --}}
    <title>PDF Export</title>
    <style>
        * {
            box-sizing: border-box;
            -moz-box-sizing: border-box;
            -webkit-box-sizing: border-box;
        }

        body {
            font-family: 'Times New Roman', Times, serif !important;
        }

        .header__export {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-align-items: center;
            align-items: center;
        }

        .header__export section {
            -webkit-box-flex: 1;
            -ms-flex: 1;
            -webkit-flex: 1;
            flex: 1;

        }

        .img-left {
            width: 100%;
            height: auto;
        }

        .img-right {
            width: 100%;
            height: auto;
            float: right;
        }

        .header__middle {
            text-align: center;
        }

        .header__h1 {
            text-transform: uppercase;
            text-decoration: underline;
            margin: 0;
            font-size: 20px;
            font-weight: bold;

        }

        .header__h2 {
            text-transform: uppercase;
            margin: 0;
            font-size: 18px;
            font-weight: bold;
        }

        .main__export {
            margin-top: 4rem;
        }

        .main__section {
            width: 50%;
        }

        .main__export .main__header {
            font-weight: bold;
            font-size: 14px
        }

        .main__export table tr td {
            font-weight: bold;
            font-size: 18px;
        }

        .main__export table tr td:nth-child(2) {
            padding: 0 .5rem 0 1rem;
        }

        .table-bordered>thead>tr>th {
            border: 1px solid #000;
        }

        .table-bordered>tbody>tr>td {
            border: 1px solid #000;
        }

        .main__footer-header {
            display: -webkit-box;
            display: flex;
            -webkit-align-items: center;
            align-items: center;
            -webkit-justify-content: space-between;
            justify-content: space-between;
        }

        .main__footer-header h5 {
            -webkit-box-flex: 1;
            -webkit-flex: 1;
            flex: 1;
            font-weight: bold;
        }

        .main__footer-header h5:nth-child(2) {
            text-align: right;
        }

        .main__footer-signature,
        .main__footer-signature-name {
            display: -webkit-box;
            display: flex;
            -webkit-align-items: center;
            align-items: center;
            -webkit-justify-content: space-between;
            justify-content: space-between;
        }

        .main__footer-signature h5,
        .main__footer-signature-name h5 {
            -webkit-box-flex: 1;
            -webkit-flex: 1;
            flex: 1;
        }

        .main__footer-signature h5:nth-child(4),
        .main__footer-signature-name h5:nth-child(4) {
            text-align: right;
        }

        .main__footer .table>thead>tr>th {
            border: none !important;
        }

        .main__footer .table>tbody>tr>td {
            border: none !important;
        }

        .main__footer .table {
            font-weight: normal;
        }
    </style>
</head>

<body>
    <header class="header__export">
        <table style="border: none !important">
            <tr>
                <td style="width: 20%"><img src="{{ public_path('/assets/images/exports/logo.jpg') }}" alt="logo"
                        class="img-left">
                </td>
                <td class="text-center">
                    <h1 class="header__h1">surat perintah lembur</h1>
                    <h2 class="header__h2">SMP/F/U/21 ( REV : 02/ 12 September 2022)</h2>
                </td>
                <td style="width: 20%">
                    <img src="{{ public_path('/assets/images/exports/logos.jpg') }}" alt="logo" class="img-right">
                </td>
            </tr>
        </table>
    </header>
    <main class="main__export">
        <h5 class="main__header">Diperintahkan bekerja lembur pada :</h5>
        <section class="main__section">
            <table>
                <tr>
                    <td style="font-size: 14px">Hari/Tanggal</td>
                    <td style="font-size: 14px">:</td>
                    <td style="font-size: 14px">{{ $date }}</td>
                </tr>
                <tr>
                    <td style="font-size: 14px">Jam</td>
                    <td style="font-size: 14px">:</td>
                    <td style="font-size: 14px">{{ $stime }} s/d {{ $etime }}</td>
                </tr>
                <tr>
                    <td style="font-size: 14px">Bagian</td>
                    <td style="font-size: 14px">:</td>
                    <td style="font-size: 14px">{{ $bagian }}</td>
                </tr>
                <tr>
                    <td style="font-size: 14px">Kepada</td>
                    <td style="font-size: 14px">:</td>
                    <td style="font-size: 14px">{{ $count }} Orang</td>
                </tr>
            </table>
        </section>
        <section class="main__table mt-4">
            <table class="table table-bordered border-dark d-flex">
                <thead>
                    <tr>
                        <th style="font-size: 13px">No</th>
                        <th style="font-size: 13px">Nama</th>
                        <th style="font-size: 13px">NIK</th>
                        <th style="font-size: 13px">Nama Proyek</th>
                        <th style="font-size: 13px">Uraian Tugas</th>
                        <th style="font-size: 13px">Pelaksana</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($details as $detail)
                        <tr>
                            <td style="font-size: 12px">{{ $loop->iteration }}</td>
                            <td style="font-size: 12px; padding: 12px;">{{ $detail->karyawan->nama_karyawan }}</td>
                            <td style="font-size: 12px">{{ $detail->karyawan->nik_karyawan }}</td>
                            <td style="font-size: 12px">{{ $detail->spl->nama_proyek }}</td>
                            <td style="font-size: 12px">{{ $detail->spl->keterangan }}</td>
                            <td style="font-size: 12px"> </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </section>
        <section class="main__footer mt-4">
            <h5 class="mb-4" style="font-size: 14px">Demikian perintah lembur untuk dilaksanakan dengan baik dan
                dengan penuh tanggung jawab.
            </h5>
            <div class="main__footer-header">
                <h5 style="font-size: 14px">Penanggung jawab</h5>
                <h5 style="font-size: 14px">Tangerang, {{ $date }}</h5>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th style="font-size: 14px">Pemberi Tugas:</th>
                        <th style="font-size:14px; text-align: center">Supervisor:</th>
                        <th style="font-size:14px; text-align: end">Menyetujui</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="mb-5">
                        <td></td>
                        <td class="text-center"></td>
                        <td class="text-center"></td>
                        <td></td>
                    </tr>
                    <tr class="mb-5">
                        <td></td>
                        <td class="text-center"></td>
                        <td class="text-center"></td>
                        <td></td>
                    </tr>
                    <tr class="mb-5">
                        <td></td>
                        <td class="text-center"></td>
                        <td class="text-center"></td>
                        <td></td>
                    </tr>
                    <tr class="mb-5">
                        <td></td>
                        <td class="text-center"></td>
                        <td class="text-center"></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td style="font-size: 14px">( {{ auth()->user()->karyawan->nama_karyawan }} )</td>
                        <td class="text-center" style="font-size: 14px">
                            @foreach ($supervisor as $item)
                                ({{ $item->nama_karyawan }})
                            @endforeach
                        </td>
                        <td style="text-align: end; font-size: 14px">
                            @empty($manager)
                                @foreach ($manager as $item)
                                    ({{ $item->nama_karyawan }})
                                @endforeach
                            @else
                                ( Manager )
                            @endempty
                        </td>
                    </tr>
                </tbody>
            </table>
        </section>
    </main>
</body>

</html>
