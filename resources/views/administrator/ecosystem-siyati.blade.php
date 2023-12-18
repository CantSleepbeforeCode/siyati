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
                        <div class="row mb-4">
                            <div class="col">
                                <h5 class="card-title fw-semibold mb-4">Member Siyati</h5>
                            </div>
                            <div class="col-3">
                                <select id="filter-member" onchange="refreshTable();" class="form-control">
                                    <option value="all">Semua</option>
                                    @foreach ($nomenclatures as $nomenclature)
                                        <option value="{{ $nomenclature->nomenclature_name }}">
                                            {{ $nomenclature->nomenclature_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table id="table" class="table text-nowrap mb-0 align-middle">
                                <thead class="text-dark fs-4">
                                    <tr>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Nama</h6>
                                        </th>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">NIK</h6>
                                        </th>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Nomor Telpon</h6>
                                        </th>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Alamat</h6>
                                        </th>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Kelurahan</h6>
                                        </th>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Kecamatan</h6>
                                        </th>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Jenis Bangunan</h6>
                                        </th>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Lokasi</h6>
                                        </th>
                                    </tr>
                                </thead>

                                <tbody id="tbody">
                                    @foreach ($customers as $customer)
                                        <tr>
                                            <td class="border-bottom-0">
                                                <h6 class="fw-semibold mb-0">{{ $customer->customer_name }}</h6>
                                            </td>
                                            <td class="border-bottom-0">
                                                <h6 class="mb-0">{{ $customer->user->nik }}</h6>
                                            </td>
                                            <td class="border-bottom-0">
                                                <h6 class="mb-0">{{ $customer->customer_phone }}</h6>
                                            </td>
                                            <td class="border-bottom-0">
                                                <h6 class="mb-0">{{ $customer->customer_address }}</h6>
                                            </td>
                                            <td class="border-bottom-0">
                                                <h6 class="mb-0">{{ $customer->customer_subdistrict }}</h6>
                                            </td>
                                            <td class="border-bottom-0">
                                                <h6 class="mb-0">{{ $customer->customer_urban_village }}</h6>
                                            </td>
                                            <td class="border-bottom-0">
                                                <h6 class="mb-0">{{ $customer->customer_nomenklatur }}</h6>
                                            </td>
                                            <td class="border-bottom-0">
                                                <h6 class="mb-0"><a
                                                        href="https://maps.google.com/?q={{ $customer->customer_lat }},{{ $customer->customer_long }}"
                                                        target="__blank">{{ $customer->customer_lat }},
                                                        {{ $customer->customer_long }}</a></h6>
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

        <div class="row">
            <div class="col">
                <div class="card w-100">
                    <div class="card-body p-4">
                        <div class="row mb-4">
                            <div class="col">
                                <h5 class="card-title fw-semibold mb-4">Lokasi Member Siyati</h5>
                            </div>
                        </div>
                        <div id="map" style="height: 500px; width: 100%;">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

    <script>
        let table = $('#table').DataTable({
            responsive: true
        });

        function refreshTable() {
            let tables = document.getElementById('tbody');
            table.destroy();
            let value = document.getElementById('filter-member').value;

            var datas = {
                _token: "{{ csrf_token() }}",
                nomenclature: value
            };
            tables.innerHTML = '';

            $.ajax({
                type: 'POST',
                url: '/administrator/ecosystem-filter-member',
                data: datas,
                success: function(response) {
                    for (let i = 0; i < response.datas.length; i++) {
                        tables.innerHTML += `
                                        <tr>
                                            <td class="border-bottom-0">
                                                <h6 class="fw-semibold mb-0">${response.datas[i].customer_name}</h6>
                                            </td>
                                            <td class="border-bottom-0">
                                                <h6 class="mb-0">${response.datas[i].user.nik}</h6>
                                            </td>
                                            <td class="border-bottom-0">
                                                <h6 class="mb-0">${response.datas[i].customer_phone}</h6>
                                            </td>
                                            <td class="border-bottom-0">
                                                <h6 class="mb-0">${response.datas[i].customer_address}</h6>
                                            </td>
                                            <td class="border-bottom-0">
                                                <h6 class="mb-0">${response.datas[i].customer_subdistrict}</h6>
                                            </td>
                                            <td class="border-bottom-0">
                                                <h6 class="mb-0">${response.datas[i].customer_urban_village}</h6>
                                            </td>
                                            <td class="border-bottom-0">
                                                <h6 class="mb-0">${response.datas[i].customer_nomenklatur}</h6>
                                            </td>
                                            <td class="border-bottom-0">
                                                <h6 class="mb-0"><a
                                                        href="https://maps.google.com/?q=${response.datas[i].customer_lat},${response.datas[i].customer_long}"
                                                        target="__blank">${response.datas[i].customer_lat},
                                                        ${response.datas[i].customer_long}</a></h6>
                                            </td>
                                        </tr>
                        `;
                    }

                    table = $('#table').DataTable({
                        responsive: true
                    });
                }
            });
        }
    </script>

    <script>
        $(document).ready(function() {
            var map = L.map('map').setView([-0.8966087186868172, 119.87462560295528], 11);

            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            @foreach ($customers as $customer)
                L.marker([{{ $customer->customer_lat }}, {{ $customer->customer_long }}]).addTo(map).bindPopup("<center>{{ $customer->customer_name }} <br> <b>{{ $customer->customer_nomenklatur }}</b></center>");
            @endforeach
        });
    </script>
@endsection
