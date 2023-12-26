@php
    function rupiah($angka)
    {
        $hasil_rupiah = 'Rp' . number_format($angka, 0, ',', '.');
        return $hasil_rupiah;
    }
@endphp

@extends('base.administrator')
@section('content')
    <div class="container-fluid">

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif


        <div class="card w-100">
            <div class="card-body">
                <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
                    <div class="mb-3 mb-sm-0">
                        <h5 class="card-title fw-semibold">Jumlah Permintaan</h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="card bg-success text-white">
                            <div class="card-body">
                                <div class="text-center">
                                    <p class="mb-0">PERMINTAAN</p>
                                    <p class="fw-bolder fs-6">{{ $orderOrdered }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card bg-warning text-white">
                            <div class="card-body">
                                <div class="text-center">
                                    <p class="mb-0">PROSES</p>
                                    <p class="fw-bolder fs-6">{{ $orderProcess }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card bg-danger text-white">
                            <div class="card-body">
                                <div class="text-center">
                                    <p class="mb-0">DITOLAK</p>
                                    <p class="fw-bolder fs-6">{{ $orderFailed }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card bg-primary text-white">
                            <div class="card-body">
                                <div class="text-center">
                                    <p class="mb-0">SELESAI</p>
                                    <p class="fw-bolder fs-6">{{ $orderDone }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card w-100">
            <div class="card-body">
                <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
                    <div class="mb-3 mb-sm-0">
                        <h5 class="card-title fw-semibold">Jumlah Bangunan</h5>
                    </div>
                </div>
                <div class="row">
                    @php
                        $color = ['primary', 'secondary', 'info', 'warning', 'danger', 'dark'];
                    @endphp
                    @foreach ($buildings as $building)
                        <div class="col">
                            <div class="card bg-{{$color[rand(0,5)]}} text-white">
                                <div class="card-body">
                                    <div class="text-center">
                                        <p class="mb-0">{{ $building->customer_nomenklatur }}</p>
                                        <p class="fw-bolder fs-6">{{ $building->total }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-7 col-12">
                <div class="card w-100">
                    <div class="card-body">
                        <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
                            <div class="mb-3 mb-sm-0">
                                <h5 class="card-title fw-semibold">Grafik Arus Permintaan</h5>
                            </div>
                        </div>
                        <div id="chart"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 col-12">
                <div class="card w-100">
                    <div class="card-body p-4">
                        <h5 class="card-title fw-semibold mb-4">Transaksi Terakhir</h5>
                        <div class="table-responsive">
                            <table id="table" class="table text-nowrap mb-0 align-middle">
                                <thead class="text-dark fs-4">
                                    <tr>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Invoice</h6>
                                        </th>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Metode Pembayaran</h6>
                                        </th>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Harga</h6>
                                        </th>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Status Pembayaran</h6>
                                        </th>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Status Pengerjaan</h6>
                                        </th>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Tanggal</h6>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $order)
                                        <tr>
                                            <td class="border-bottom-0">
                                                <h6 class="fw-semibold mb-0">#{{ $order->order_invoice }}</h6>
                                            </td>
                                            <td class="border-bottom-0">
                                                @if ($order->order_payment_method == 'tunai')
                                                    <h6 class="fw-semibold mb-1">Tunai</h6>
                                                    <span class="fw-normal">Melalui Driver</span>
                                                @else
                                                    <h6 class="fw-semibold mb-1">Non Tunai</h6>
                                                    @if ($order->channel_id == null)
                                                        <span class="fw-normal">-</span>
                                                    @else
                                                        <span
                                                            class="fw-normal">{{ $order->tripay_channel->channel_name }}</span>
                                                    @endif
                                                @endif
                                            </td>
                                            <td class="border-bottom-0">
                                                @if ($order->order_price == 0)
                                                    <p class="mb-0 fw-normal text-center">-</p>
                                                @else
                                                    <p class="mb-0 fw-normal">{{ rupiah($order->order_price) }}</p>
                                                @endif
                                            </td>
                                            <td class="border-bottom-0 text-center">
                                                <div class="">
                                                    @if ($order->order_status_payment == 'ordered')
                                                        <span class="badge bg-primary rounded-3 fw-semibold">Dipesan</span>
                                                    @elseif($order->order_status_payment == 'fail_pay')
                                                        <span class="badge bg-danger rounded-3 fw-semibold">Gagal
                                                            Dibayar</span>
                                                    @elseif($order->order_status_payment == 'payed')
                                                        <span class="badge bg-info rounded-3 fw-semibold">Dibayar</span>
                                                    @elseif($order->order_status_payment == 'refunded')
                                                        <span class="badge bg-danger rounded-3 fw-semibold">Gagal
                                                            Diproses</span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="border-bottom-0 text-center">
                                                <div class="">
                                                    @if ($order->order_status_job == 'not_start')
                                                        <span class="badge bg-dark rounded-3 fw-semibold">Belum
                                                            Dimulai</span>
                                                    @elseif($order->order_status_job == 'on_queue')
                                                        <span class="badge bg-info rounded-3 fw-semibold">Dalam
                                                            Antrian</span>
                                                    @elseif($order->order_status_job == 'on_the_way')
                                                        <span class="badge bg-info rounded-3 fw-semibold">Sedang
                                                            Dijalan</span>
                                                    @elseif($order->order_status_job == 'on_process')
                                                        <span class="badge bg-info rounded-3 fw-semibold">Sedang
                                                            Dikerjakan</span>
                                                    @elseif($order->order_status_job == 'done')
                                                        <span class="badge bg-success rounded-3 fw-semibold">Selesai</span>
                                                    @elseif($order->order_status_job == 'rejected')
                                                        <span class="badge bg-danger rounded-3 fw-semibold">Ditolak</span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="border-bottom-0">
                                                <h6 class="fw-semibold mb-0 fs-4">
                                                    {{ date_format(date_create($order->order_date), 'd M Y') }}</h6>
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
    </div>
@endsection

@section('js')
    <script>
        $(function() {
            var chart = {
                series: [{
                    name: "Permintaan Hari Ini",
                    data: [
                        <?php
                        foreach ($dailyOrders as $dailyOrder) {
                            echo $dailyOrder->count . ',';
                        }
                        ?>
                    ]
                }, ],

                chart: {
                    type: "area",
                    height: 345,
                    offsetX: -15,
                    toolbar: {
                        show: true
                    },
                    foreColor: "#adb0bb",
                    fontFamily: 'inherit',
                    sparkline: {
                        enabled: false
                    },
                },


                colors: ["#5D87FF", "#49BEFF"],


                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: "35%",
                        borderRadius: [6],
                        borderRadiusApplication: 'end',
                        borderRadiusWhenStacked: 'all'
                    },
                },
                markers: {
                    size: 0
                },

                dataLabels: {
                    enabled: false,
                },


                legend: {
                    show: false,
                },


                grid: {
                    borderColor: "rgba(0,0,0,0.1)",
                    strokeDashArray: 3,
                    xaxis: {
                        lines: {
                            show: false,
                        },
                    },
                },

                xaxis: {
                    type: "category",
                    categories: [

                        <?php
                        foreach ($dailyOrders as $dailyOrder) {
                            echo '"' . $dailyOrder->day . '",';
                        }
                        ?>
                    ],
                    labels: {
                        style: {
                            cssClass: "grey--text lighten-2--text fill-color"
                        },
                    },
                },


                yaxis: {
                    show: true,
                    min: 0,
                    tickAmount: 4,
                    labels: {
                        style: {
                            cssClass: "grey--text lighten-2--text fill-color",
                        },
                        formatter: function(val) {
                            return val.toFixed(0) + " Permintaan";
                        }
                    },
                },
                stroke: {
                    show: true,
                    width: 3,
                    lineCap: "butt",
                    colors: ["transparent"],
                },


                tooltip: {
                    theme: "light"
                },

                responsive: [{
                    breakpoint: 600,
                    options: {
                        plotOptions: {
                            bar: {
                                borderRadius: 3,
                            }
                        },
                    }
                }]


            };

            var chart = new ApexCharts(document.querySelector("#chart"), chart);
            chart.render();
        })
    </script>
@endsection
