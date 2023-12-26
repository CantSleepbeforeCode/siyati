@php
    function rupiah($angka)
    {
        $hasil_rupiah = 'Rp' . number_format($angka, 0, ',', '.');
        return $hasil_rupiah;
    }
@endphp

@extends('base.administrator')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
@endsection

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

        <div class="row">
            <div class="col">
                <div class="card w-100">
                    <div class="card-body p-4">
                        <div class="row">
                            <div class="col">
                                <h5 class="card-title fw-semibold mb-4">My Transaksi</h5>
                            </div>
                        </div>
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
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Lokasi</h6>
                                        </th>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Aksi</h6>
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
                                                @elseif ($order->order_payment_method == 'non_tunai')
                                                    <h6 class="fw-semibold mb-1">Non Tunai</h6>
                                                    @if ($order->channel_id == null)
                                                        <span class="fw-normal">-</span>
                                                    @else
                                                        <span
                                                            class="fw-normal">{{ $order->tripay_channel->channel_name }}</span>
                                                    @endif
                                                @else
                                                <span class="fw-normal">-</span>
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
                                                    {{ date_format(date_create($order->order_date), 'd M Y, H:i') }}</h6>
                                            </td>
                                            <td class="border-bottom-0">
                                                <a href="https://maps.google.com/?q={{ $order->customer->customer_lat }},{{ $order->customer->customer_long }}"
                                                    target="__blank">{{ $order->customer->customer_lat }},
                                                    {{ $order->customer->customer_long }}</a>
                                            </td>
                                            <td class="border-bottom-0">
                                                <button class="btn btn-info" data-bs-toggle="modal"
                                                    data-bs-target="#detailModal{{ $order->order_id }}">Detail</button>

                                                @if (
                                                    $order->order_status_payment == 'ordered' &&
                                                        $order->order_payment_method == 'non_tunai' &&
                                                        $order->channel_id != null)
                                                    <a href="/administrator/cek-pembayaran/{{ $order->order_invoice }}"
                                                        class="btn btn-success">Cek Pembayaran</a>
                                                @endif

                                                @if ($order->order_status_payment == 'ordered' && $order->order_status_job == 'not_start')
                                                <button class="btn btn-primary" data-bs-toggle="modal"
                                                    data-bs-target="#driverModal{{ $order->order_id }}">Pilih
                                                    Driver</button>
                                                    {{-- @if ($order->order_payment_method == 'tunai')
                                                    @endif
                                                @elseif(
                                                    $order->order_status_payment == 'done' &&
                                                        $order->order_payment_method == 'non_tunai' &&
                                                        $order->order_status_job == 'not_start')
                                                    <button class="btn btn-primary" data-bs-toggle="modal"
                                                        data-bs-target="#driverModal{{ $order->order_id }}">Pilih
                                                        Driver</button>
                                                @endif --}}
                                                @endif
                                                @if (
                                                    $order->order_status_job == 'not_start' ||
                                                        $order->order_status_job == 'on_queue' ||
                                                        $order->order_status_job == 'on_the_way' ||
                                                        $order->order_status_job == 'on_process')
                                                    <button class="btn btn-danger" data-bs-toggle="modal"
                                                        data-bs-target="#rejectModal{{ $order->order_id }}">Tolak</button>
                                                @endif
                                                @if ($order->order_status_job == 'on_process')
                                                    <button class="btn btn-success" data-bs-toggle="modal"
                                                        data-bs-target="#doneModal{{ $order->order_id }}">Selesai</button>
                                                @endif
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

        @foreach ($orders as $order)
            <div class="modal fade" id="detailModal{{ $order->order_id }}" tabindex="-1"
                aria-labelledby="detailModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="detailModalLabel">Detail Pesanan</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            {{-- <table class="table table-striped">
                                <tr>
                                    <td>Volume</td>
                                    <td>Unit</td>
                                    <td>Harga</td>
                                </tr>
                                @foreach ($order->detailOrderSepithank as $detail)
                                    <tr>
                                        <td>{{ $detail->sepithank->sepithank_vol }}</td>
                                        <td>{{ $detail->sepithank->sepithank_unit }}</td>
                                        <td>{{ rupiah($detail->price) }}</td>
                                    </tr>
                                @endforeach
                            </table> --}}


                            @if ($order->order_proof_photo != null)
                                <hr class="mt-4 mb-2">
                                <p>Bukti Pengerjaan</p>
                                <div class="text-center">
                                    <img src="{{ $order->order_proof_photo }}" width="400">
                                </div>
                            @endif

                            @if ($order->customer != null)
                                <hr class="mt-4 mb-2">
                                <p>Data Customer</p>
                                <div class="row">
                                    <div class="col-2">
                                        Nama
                                    </div>
                                    <div class="col-1">
                                        :
                                    </div>
                                    <div class="col">
                                        {{ $order->customer->customer_name }}
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-2">
                                        HP
                                    </div>
                                    <div class="col-1">
                                        :
                                    </div>
                                    <div class="col">
                                        {{ $order->customer->customer_phone }}
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-2">
                                        Alamat
                                    </div>
                                    <div class="col-1">
                                        :
                                    </div>
                                    <div class="col">
                                        {{ $order->customer->customer_address }} Kelurahan
                                        {{ $order->customer->customer_subdistrict }} Kecamatan
                                        {{ $order->customer->customer_urban_village }}
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-2">
                                        Jenis Bangunan
                                    </div>
                                    <div class="col-1">
                                        :
                                    </div>
                                    <div class="col">
                                        {{ $order->customer->customer_nomenklatur }}
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-2">
                                        Foto Bangunan
                                    </div>
                                    <div class="col-1">
                                        :
                                    </div>
                                    <div class="col">
                                        <img src="{{ $order->customer->customer_photo }}" class="img-fluid">
                                    </div>
                                </div>
                            @endif

                            @if ($order->armada != null)
                                <hr class="mt-4 mb-2">
                                <p>Data Armada</p>
                                <div class="row">
                                    <div class="col-2">
                                        Nama
                                    </div>
                                    <div class="col-1">
                                        :
                                    </div>
                                    <div class="col">
                                        {{ $order->armada->armada_driver }}
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-2">
                                        Nomor Polisi
                                    </div>
                                    <div class="col-1">
                                        :
                                    </div>
                                    <div class="col">
                                        {{ $order->armada->armada_plat }}
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-2">
                                        ID GPS
                                    </div>
                                    <div class="col-1">
                                        :
                                    </div>
                                    <div class="col">
                                        {{ $order->armada->armada_id_gps }}
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-2">
                                        Wilayah
                                    </div>
                                    <div class="col-1">
                                        :
                                    </div>
                                    <div class="col">
                                        {{ $order->armada->kecamatan->nama }}
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-2">
                                        Foto Driver
                                    </div>
                                    <div class="col-1">
                                        :
                                    </div>
                                    <div class="col">
                                        <img src="{{ $order->armada->armada_driver_photo }}" class="img-fluid">
                                    </div>
                                </div>
                            @endif

                            <hr class="mt-4 mb-2">
                            <b>
                                <p>Proses Pengerjaan</p>
                            </b>
                            <table class="table">
                                <thead class="thead-primary">
                                    <tr>
                                        <th>Tahap</th>
                                        <th class="text-center">Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Dibayar</td>
                                        @if ($order->date_payed == null)
                                            <td class="text-center">-</td>
                                        @else
                                            <td class="text-center">
                                                {{ date_format(date_create($order->date_payed), 'd M Y, H:i') }}</td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <td>Dalam Antrian</td>
                                        @if ($order->date_queue == null)
                                            <td class="text-center">-</td>
                                        @else
                                            <td class="text-center">
                                                {{ date_format(date_create($order->date_queue), 'd M Y, H:i') }}</td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <td>Dalam Perjalanan</td>
                                        @if ($order->date_on_the_way == null)
                                            <td class="text-center">-</td>
                                        @else
                                            <td class="text-center">
                                                {{ date_format(date_create($order->date_on_the_way), 'd M Y, H:i') }}</td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <td>Dalam Pengerjaan</td>
                                        @if ($order->date_process == null)
                                            <td class="text-center">-</td>
                                        @else
                                            <td class="text-center">
                                                {{ date_format(date_create($order->date_process), 'd M Y, H:i') }}</td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <td>Selesai</td>
                                        @if ($order->date_done == null)
                                            <td class="text-center">-</td>
                                        @else
                                            <td class="text-center">
                                                {{ date_format(date_create($order->date_done), 'd M Y, H:i') }}</td>
                                        @endif
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="driverModal{{ $order->order_id }}" tabindex="-1"
                aria-labelledby="driverModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="driverModalLabel">Pilih Driver</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <form action="/administrator/pilih-driver" method="POST">
                            @csrf
                            <input type="hidden" name="order" value="{{ $order->order_id }}">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-12">
                                        <label for="" class="form-label">Driver</label>
                                        <select id="select_armada_{{$order->order_id}}" name="armada_id" class="form-control" required onchange="changeDriver('select_armada_{{$order->order_id}}', 'driverTable{{$order->order_id}}')">
                                            <option value="">--- Pilih Armada ---</option>
                                            @foreach ($armadas as $armada)
                                            <option value="{{ $armada->armada_id }}">{{ $armada->armada_id }} -
                                                {{ $armada->armada_driver }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <hr class="mt-2 mb-2">

                                <table id="table-driver-{{ $order->order_id }}" class="table text-nowrap" style="width: 100%;">
                                    <thead >
                                        <tr>
                                            <th>Armada</th>
                                            <th>Invoice</th>
                                            <th>Tahap Pengerjaan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($armadaAssigns as $armadaAssign)
                                            <tr>
                                                <td>{{$armadaAssign->armada->armada_id}} - {{ $armadaAssign->armada->armada_driver }}</td>
                                                <td>{{ $armadaAssign->order_invoice }}</td>
                                                <td>
                                                    @if ($armadaAssign->order_status_job == 'not_start')
                                                        <span class="badge bg-dark rounded-3 fw-semibold">Belum
                                                            Dimulai</span>
                                                    @elseif($armadaAssign->order_status_job == 'on_queue')
                                                        <span class="badge bg-info rounded-3 fw-semibold">Dalam
                                                            Antrian</span>
                                                    @elseif($armadaAssign->order_status_job == 'on_the_way')
                                                        <span class="badge bg-info rounded-3 fw-semibold">Sedang
                                                            Dijalan</span>
                                                    @elseif($armadaAssign->order_status_job == 'on_process')
                                                        <span class="badge bg-info rounded-3 fw-semibold">Sedang
                                                            Dikerjakan</span>
                                                    @elseif($armadaAssign->order_status_job == 'done')
                                                        <span
                                                            class="badge bg-success rounded-3 fw-semibold">Selesai</span>
                                                    @elseif($armadaAssign->order_status_job == 'rejected')
                                                        <span
                                                            class="badge bg-danger rounded-3 fw-semibold">Ditolak</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn btn-primary">Pilih</button>
                            </div>
                    </div>
                    </form>
                </div>
            </div>
            <div class="modal fade" id="rejectModal{{ $order->order_id }}" tabindex="-1"
                aria-labelledby="rejectModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="rejectModalLabel">Tolak Pesanan</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Anda yakin ingin menolak permintaan invoice #{{ $order->order_invoice }}?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <a href="/administrator/tolak-permintaan/{{ $order->order_id }}"
                                class="btn btn-danger">Tolak</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="doneModal{{ $order->order_id }}" tabindex="-1"
                aria-labelledby="doneModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="doneModalLabel">Selesaikan Pesanan</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Anda yakin ingin menyelesaikan permintaan invoice #{{ $order->order_invoice }}?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <a href="/administrator/selesaikan-permintaan/{{ $order->order_id }}"
                                class="btn btn-success">Selesai</a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection

@section('js')
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

    <script>
        new DataTable('#table', {
            responsive: true,
            ordering: false
        });

        @foreach ($orders as $order)
            var driverTable{{$order->order_id}} = new DataTable('#table-driver-{{ $order->order_id }}', {
                responsive: true,
                ordering: false
            });
        @endforeach

        function changeDriver(name, table) {
            let key = document.getElementById(name).value;

            window[table].search(key).draw();
        }
    </script>
@endsection
