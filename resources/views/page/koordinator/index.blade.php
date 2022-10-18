@extends('layouts.dashboard')
@section('content')
    <section>
        <div class="row">
            <div class="col-md-3 col-xl-3">
                <div class="card">
                    <div class="card-body bg-primary">
                        <h2 class="card-title text-white fs-2">
                            {{ $total }}
                            <i class="bi bi-filetype-doc fs-3"></i>
                        </h2>
                        <h5 class="card-title text-white fs-6">Total Pengajuan</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-xl-3">
                <div class="card">
                    <div class="card-body bg-success">
                        <h2 class="card-title text-white fs-2">
                            {{ $total_approval }}
                            <i class="bi bi-filetype-doc fs-3"></i>
                        </h2>
                        <h5 class="card-title text-white fs-6">Total Approval</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-xl-3">
                <div class="card">
                    <div class="card-body bg-edit">
                        <h2 class="card-title text-white fs-2">
                            {{ $waiting_spv }}
                            <i class="bi bi-filetype-doc fs-3"></i>
                        </h2>
                        <h5 class="card-title text-white fs-6">Waiting SPV</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-xl-3">
                <div class="card">
                    <div class="card-body bg-warning">
                        <h2 class="card-title text-white fs-2">
                            {{ $waiting_head }}
                            <i class="bi bi-filetype-doc fs-3"></i>
                        </h2>
                        <h5 class="card-title text-white fs-6">Waiting Head</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-xl-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class='card-heading p-1 pl-3'>Pengajuan Lembur {{ \Carbon\Carbon::now()->year }}</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <canvas id="bar"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Pengajuan Terakhir</h5>
                        <table class="table table-striped" id="table1">
                            <thead>
                                <tr>
                                    <th>ID SPL</th>
                                    <th>ID Proyek</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pengajuan_terakhir as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->kode_proyek }}</td>
                                        <td>
                                            @empty($item->approval->status)
                                                Belum dikirim
                                            @else
                                                @switch($item->approval->status)
                                                    @case(2)
                                                        Approved
                                                    @break

                                                    @case(3)
                                                        Rejected
                                                    @break

                                                    @case(4)
                                                        Waiting Approval
                                                    @break

                                                    @case(5)
                                                        Waiting Approval SPV
                                                    @break

                                                    @case(6)
                                                        Waiting Approval Head
                                                    @break

                                                    -

                                                    @default
                                                @endswitch
                                            @endempty
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="nam">{{ Auth()->user()->karyawan->nama_karyawan }}</div>
        </div>
    </section>
    <script src="/assets/vendors/simple-datatables/simple-datatables.js"></script>
    <script src="/assets/js/vendors.js"></script>
    <script src="/assets/vendors/choices.js/choices.min.js"></script>
    <script src="/assets/js/superadmin/edituser.js"></script>
    <script>
        $(document).ready(function() {
            var chartColors = {
                red: "rgb(255, 99, 132)",
                orange: "rgb(255, 159, 64)",
                yellow: "rgb(255, 205, 86)",
                green: "rgb(75, 192, 192)",
                info: "#41B1F9",
                blue: "#3245D1",
                purple: "rgb(153, 102, 255)",
                grey: "#EBEFF6",
            };
            var ctx = document.getElementById('bar').getContext('2d');
            $.ajax({
                url: "/koordinator/get-dashboard",
                method: "GET",
                success: function(data) {
                    var myChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: data.label,
                            datasets: [{
                                label: 'Total Pengajuan',
                                data: [data.month[0], data.month[1], data.month[2], data
                                    .month[3], data.month[4], data.month[5], data
                                    .month[6], data.month[7], data.month[8], data
                                    .month[9], data.month[10], data.month[11]
                                ],
                                backgroundColor: chartColors.info,
                                borderColor: chartColors.info,
                            }, ]
                        },
                        options: {
                            responsive: true,
                            barRoundness: 1,
                            title: {
                                display: false,
                                text: "Chart.js - Bar Chart with Rounded Tops (drawRoundedTopRectangle Method)",
                            },
                            legend: {
                                display: false,
                            },
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        beginAtZero: true,
                                        suggestedMax: 50,
                                        padding: 10,
                                    },
                                    gridLines: {
                                        drawBorder: false,
                                    },
                                }, ],
                                xAxes: [{
                                    gridLines: {
                                        display: false,
                                        drawBorder: false,
                                    },
                                }, ],
                            },
                        },
                    });
                }
            });
        });
    </script>
@endsection
