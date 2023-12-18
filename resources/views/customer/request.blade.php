@php
    function rupiah($angka)
    {
        $hasil_rupiah = 'Rp' . number_format($angka, 0, ',', '.');
        return $hasil_rupiah;
    }
@endphp

@extends('base.user')

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
                                <h5 class="card-title fw-semibold mb-4">Permintaan Penyedotan Septic Tank</h5>
                            </div>
                            <div class="col">
                                <button class="btn btn-primary float-end" data-bs-toggle="modal"
                                    data-bs-target="#modalPengajuan">Ajukan</button>
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
                                                    <span class="fw-normal">Melalui Admin</span>
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
                                            <td class="border-bottom-0">
                                                <button class="btn btn-info" data-bs-toggle="modal"
                                                    data-bs-target="#detailModal{{ $order->order_id }}">Detail</button>
                                                @if ($order->order_status_payment == 'ordered')
                                                    @if ($order->order_payment_method == 'non_tunai' && $order->channel_id == null)
                                                        <button class="btn btn-primary" data-bs-toggle="modal"
                                                            data-bs-target="#paymentModal{{ $order->order_id }}"
                                                            onclick="updatePrice({{ $order->order_price }})">Bayar</button>
                                                    @elseif($order->channel_id != null)
                                                        <a href="{{ $order->payment_url }}"
                                                            class="btn btn-primary">Bayar</a>
                                                    @endif
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

        <div class="modal fade" id="modalPengajuan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Konfirmasi</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="/permintaan" method="POST">
                        @csrf
                        <div class="modal-body">
                            <p>
                                <b>Metode Pembayaran</b>
                            </p>
                            <select name="order_payment_method" id="" class="form-control" required>
                                <option value="">-- PILIH METODE PEMBAYARAN --</option>
                                <option value="tunai">TUNAI</option>
                                <option value="non_tunai">NON TUNAI</option>
                            </select>
                            <hr class="mt-3 mb-3">
                            <p>
                                <b>Pilih Septic Tank</b>
                            <div class="dropdown">
                                <button class="btn btn-primary dropdown-toggle" type="button" id="multiSelectDropdown"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    Septic Tank Saya
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="multiSelectDropdown">
                                    @foreach ($sepithanks as $sepithank)
                                        <li class="text-center">
                                            <label>
                                                <input class="form-check-input" type="checkbox" name="sepithank[]"
                                                    required value="{{ $sepithank->sepithank_id }}"
                                                    label="{{ $sepithank->sepithank_vol }} {{ $sepithank->sepithank_unit }}">
                                                {{ $sepithank->sepithank_vol }} {{ $sepithank->sepithank_unit }}
                                            </label>
                                        </li>
                                    @endforeach
                                </ul>
                                <div id="msg" class="form-text text-danger"></div>
                                <p class="text-center fw-bolder" id="price">Biaya yang harus anda bayar: Rp. 0.00</p>
                            </div>
                            </p>
                            <hr class="mt-3 mb-3">
                            <p>
                                <b>Apakah data anda telah benar?</b>
                            </p>
                            <p>
                                Alamat <br> <b>{{ $customer->customer_address }}, KELURAHAN
                                    {{ $customer->customer_subdistrict }}, KECAMATAN
                                    {{ $customer->customer_urban_village }}</b>
                            </p>
                            <p>Lokasi Anda</p>
                            <div id="map" style="height: 300px;">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary" onclick="cekSepitank()">Ajukan</button>
                        </div>
                    </form>
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
                            <table class="table table-striped">
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
                            </table>
    
    
                            @if ($order->order_proof_photo != null)
                            <hr class="mt-2 mb-2">
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
                            <b><p>Proses Pengerjaan</p></b>
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
                                        @if($order->date_payed == null)
                                        <td class="text-center">-</td>
                                        @else
                                        <td class="text-center">{{ date_format(date_create($order->date_payed), 'd M Y, H:i') }}</td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <td>Dalam Antrian</td>
                                        @if($order->date_queue == null)
                                        <td class="text-center">-</td>
                                        @else
                                        <td class="text-center">{{ date_format(date_create($order->date_queue), 'd M Y, H:i') }}</td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <td>Dalam Perjalanan</td>
                                        @if($order->date_on_the_way == null)
                                        <td class="text-center">-</td>
                                        @else
                                        <td class="text-center">{{ date_format(date_create($order->date_on_the_way), 'd M Y, H:i') }}</td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <td>Dalam Pengerjaan</td>
                                        @if($order->date_process == null)
                                        <td class="text-center">-</td>
                                        @else
                                        <td class="text-center">{{ date_format(date_create($order->date_process), 'd M Y, H:i') }}</td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <td>Selesai</td>
                                        @if($order->date_done == null)
                                        <td class="text-center">-</td>
                                        @else
                                        <td class="text-center">{{ date_format(date_create($order->date_done), 'd M Y, H:i') }}</td>
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
            @if ($order->order_payment_method == 'non_tunai' && $order->channel_id == null)
                <div class="modal fade" id="paymentModal{{ $order->order_id }}" tabindex="-1"
                    aria-labelledby="paymentModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="paymentModalLabel">Pilih Pembayaran</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form action="/select-payment-virtual" method="POST">
                                <div class="modal-body">
                                    <div class="accordion" id="accordionPayment">
                                        @csrf
                                        <input type="hidden" name="order" value="{{ $order->order_id }}" required>
                                        <input type="hidden" name="channel" id="channel" required>
                                        @foreach ($paymentGroups as $paymentGroup)
                                            <div class="accordion-item">
                                                <h2 class="accordion-header"
                                                    id="heading-{{ strtolower(str_replace(' ', '_', $paymentGroup->channel_group)) }}">
                                                    <button class="accordion-button collapsed" type="button"
                                                        data-bs-toggle="collapse"
                                                        data-bs-target="#collapse-{{ strtolower(str_replace(' ', '_', $paymentGroup->channel_group)) }}"
                                                        aria-expanded="false"
                                                        aria-controls="collapse-{{ strtolower(str_replace(' ', '_', $paymentGroup->channel_group)) }}"
                                                        style="color: #415094; border:none;">
                                                        {{ $paymentGroup->channel_group }}
                                                    </button>
                                                </h2>
                                                <div id="collapse-{{ strtolower(str_replace(' ', '_', $paymentGroup->channel_group)) }}"
                                                    class="accordion-collapse collapse"
                                                    aria-labelledby="heading{{ strtolower(str_replace(' ', '_', $paymentGroup->channel_group)) }}"
                                                    data-bs-parent="#accordionPayment">
                                                    <div class="accordion-body">
                                                        @foreach ($paymentChannels as $paymentChannel)
                                                            @if ($paymentChannel->channel_group == $paymentGroup->channel_group)
                                                                <div id="card-payment-{{ $paymentChannel->channel_id }}"
                                                                    class="card mb-3 card-payment"
                                                                    onclick="setPaymentActive('{{ $paymentChannel->channel_id }}', '{{ $paymentChannel->channel_name }}')">

                                                                    <div class="card-body">
                                                                        <div class="row">
                                                                            <div class="col">
                                                                                <img src="{{ $paymentChannel->channel_icon_url }}"
                                                                                    width="50"
                                                                                    alt="{{ $paymentChannel->channel_name }}"
                                                                                    class="float-start">
                                                                                <span
                                                                                    id="text-payment-{{ $paymentChannel->channel_id }}"
                                                                                    class="float-end text-payment"
                                                                                    flat='{{ $paymentChannel->fee_customer_flat }}'
                                                                                    percent='{{ $paymentChannel->fee_customer_percent }}'
                                                                                    minimum='{{ $paymentChannel->minimum_fee }}'
                                                                                    maximum='{{ $paymentChannel->maximum_fee }}'
                                                                                    group='{{ $paymentChannel->channel_group }}'></span>
                                                                            </div>
                                                                        </div>
                                                                        <hr class="mt-1 mb-1">
                                                                        {{ $paymentChannel->channel_name }}
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Tutup</button>
                                    <button type="submit" class="btn btn-primary">Bayar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
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
                            <a href="/selesaikan-permintaan/{{ $order->order_id }}" class="btn btn-success">Selesai</a>
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
        function formatRupiah(angka, prefix) {
            var number_string = angka.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
        }

        function cekSepitank() {
            let q = document.querySelectorAll('.dropdown-menu input[type="checkbox"]:checked').length;
            if (q == 0) {
                document.getElementById('msg').innerHTML = 'Silakan pilih Sepitank terlebih dahulu!';
            }
        }

        const chBoxes =
            document.querySelectorAll('.dropdown-menu input[type="checkbox"]');
        const dpBtn =
            document.getElementById('multiSelectDropdown');
        let mySelectedListItems = [];

        function handleCB() {
            let q = document.querySelectorAll('.dropdown-menu input[type="checkbox"]:checked').length;

            document.getElementById('price').innerHTML = 'Biaya yang harus anda bayar: Rp. ' + formatRupiah(Math.round(
                300000 * q).toString()) + ",00";

            mySelectedListItems = [];
            let mySelectedListItemsText = '';

            chBoxes.forEach((check) => {
                check.setAttribute('required', 'required');
            })
            chBoxes.forEach((checkbox) => {
                if (checkbox.checked) {
                    mySelectedListItems.push(checkbox.value);
                    mySelectedListItemsText += checkbox.getAttribute('label') + ', ';
                    document.getElementById('msg').innerHTML = '';
                } else {
                    const checked =
                        document.querySelectorAll('.dropdown-menu input[type="checkbox"]:checked').length;
                    if (checked != 0) {
                        checkbox.removeAttribute('required');
                    }

                }
            });

            dpBtn.innerText =
                mySelectedListItems.length > 0 ?
                mySelectedListItemsText.slice(0, -2) : 'Septic Tank Saya';


        }

        chBoxes.forEach((checkbox) => {
            checkbox.addEventListener('change', handleCB);
        });
    </script>

    <script>
        new DataTable('#table', {
            responsive: true
        });
    </script>
    <script>
        var map = L.map('map').setView([{{ $customer->customer_lat }}, {{ $customer->customer_long }}], 13);
        $(document).ready(function() {

            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            L.marker([{{ $customer->customer_lat }}, {{ $customer->customer_long }}]).addTo(map);
        });

        $('#modalPengajuan').on('shown.bs.modal', function() {
            setTimeout(function() {
                map.invalidateSize();
            }, 1);
        });
    </script>

    <script>
        let priceSelected = 300000;

        function updatePrice(price) {
            priceSelected = price;
            getPayment();
        }

        function getPayment() {
            let channels = document.getElementsByClassName('text-payment')
            for (let i = 0; i < channels.length; i++) {
                let actualPrice = priceSelected;
                let percent = channels[i].getAttribute('percent');
                let flat = channels[i].getAttribute('flat');
                let minimum = channels[i].getAttribute('minimum');
                let maximum = channels[i].getAttribute('maximum');
                let group = channels[i].getAttribute('group');

                if (percent != 0) {
                    let tax = (((percent / 100).toFixed(3) * priceSelected) + parseInt(flat));
                    if (minimum != '') {
                        if (tax < parseInt(minimum)) {
                            tax = parseInt(minimum);
                        }
                    }

                    if (maximum != '') {
                        if (tax > parseInt(maximum)) {
                            tax = parseInt(maximum);
                        }
                    }

                    actualPrice = parseInt(priceSelected) + tax;
                } else {
                    actualPrice = parseInt(priceSelected) + parseInt(flat);
                }

                channels[i].innerHTML = "Rp. " + formatRupiah(Math.round(actualPrice).toString()) + ",00";

                if (group == 'Virtual Account' || group == 'Convenience Store') {
                    if (priceSelected < 10000) {
                        channels[i].innerHTML = "<i>Sedang tidak tersedia</i>";
                    }
                }
            }
        }

        function setPaymentActive(card, name) {
            switch (document.getElementById("text-payment-" + card).innerHTML) {
                case '':
                    alert("Silahkan memilih jasa terlebih dahulu");
                    return false;
                case '<i>Sedang tidak tersedia</i>':
                    alert("Metode pembayaran ini sedang tidak dapat digunakan");
                    return false;
                default:
                    let payments = document.getElementsByClassName('card-payment');
                    for (i = 0; i < payments.length; i++) {
                        payments[i].classList.remove('border');
                        payments[i].classList.remove('border-primary');
                    }

                    document.getElementById("card-payment-" + card).classList.add("border");
                    document.getElementById("card-payment-" + card).classList.add("border-primary");
                    document.getElementById('channel').value = card;

                    location.href = "#section-2";
            }

        }

        function formatRupiah(angka, prefix) {
            var number_string = angka.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
        }
    </script>
@endsection
