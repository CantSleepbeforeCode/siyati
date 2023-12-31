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
    </div>

    <div class="row me-3 ms-3">
        <div class="col">
            <div class="card w-100">
                <div class="card-body p-4">
                    <div class="row">
                        <div class="col">
                            <h5 class="card-title fw-semibold mb-4">Armada</h5>
                        </div>
                        <div class="col">
                            <button class="btn btn-primary float-end" data-bs-toggle="modal"
                                data-bs-target="#addArmadaModal">Tambah</button>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="table" class="table text-nowrap mb-0 align-middle">
                            <thead class="text-dark fs-4">
                                <tr>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Nomor Armada</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Nama Driver</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Nomor Polisi</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">ID GPS</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Wilayah</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Aksi</h6>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($armadas as $armada)
                                    <tr>
                                        <td class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">{{ $armada->armada_id }}</h6>
                                        </td>
                                        <td class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">{{ $armada->armada_driver }}</h6>
                                        </td>
                                        <td class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">{{ $armada->armada_plat }}</h6>
                                        </td>
                                        <td class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">{{ $armada->armada_id_gps }}</h6>
                                        </td>
                                        <td class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">{{ $armada->kecamatan->nama }}</h6>
                                        </td>
                                        <td class="border-bottom-0">
                                            <button class="btn btn-info" data-bs-toggle="modal"
                                                data-bs-target="#detailArmadaModal{{ $armada->armada_id }}">Lihat
                                                Driver</button>
                                            <button class="btn btn-warning" data-bs-toggle="modal"
                                                data-bs-target="#editArmadaModal{{ $armada->armada_id }}">Ubah</button>
                                            <button class="btn btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#deleteArmadaModal{{ $armada->armada_id }}">Hapus</button>
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

    <div class="row me-3 ms-3">
        <div class="col">
            <div class="card w-100">
                <div class="card-body p-4">
                    <div class="row">
                        <div class="col">
                            <h5 class="card-title fw-semibold mb-4">Pendapatan Armada</h5>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col">
                            <select name="time" id="time" class="form-control" onchange="refreshTable()">
                                <option value="harian">Harian</option>
                                <option value="bulanan">Bulanan</option>
                            </select>
                        </div>
                        <div class="col">
                            <select name="status_job" id="status_job" class="form-control" onchange="refreshTable()">
                                <option value="all">Semua Status</option>
                                <option value="on_queue">Dalam Antrian</option>
                                <option value="on_the_way">Dalam Perjalanan</option>
                                <option value="on_process">Dalam Pengerjaan</option>
                                <option value="done">Selesai</option>
                            </select>
                        </div>
                        <div class="col">
                            <select name="driver" id="driver" class="form-control" onchange="refreshTable()">
                                <option value="all">Semua Driver</option>
                                @foreach ($armadas as $armada)
                                    <option value="{{ $armada->armada_id }}">{{ $armada->armada_id }} -
                                        {{ $armada->armada_driver }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="table-revenue" class="table text-nowrap" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>Armada</th>
                                    <th>Invoice</th>
                                    <th>Tahap Pengerjaan</th>
                                    <th>Pendapatan</th>
                                </tr>
                            </thead>
                            <tbody id="tbody">
                                @php
                                    $sum = 0;
                                @endphp
                                @foreach ($armadaAssigns as $armadaAssign)
                                    @php
                                        $sum += $armadaAssign->order_price;
                                    @endphp
                                    <tr>
                                        <td>{{ $armadaAssign->armada->armada_id }} -
                                            {{ $armadaAssign->armada->armada_driver }}</td>
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
                                                <span class="badge bg-success rounded-3 fw-semibold">Selesai</span>
                                            @elseif($armadaAssign->order_status_job == 'rejected')
                                                <span class="badge bg-danger rounded-3 fw-semibold">Ditolak</span>
                                            @endif
                                        </td>
                                        <td>{{ rupiah($armadaAssign->order_price) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td>Total Pendapatan</td>
                                    <td style="display: none;"></td>
                                    <td style="display: none;"></td>
                                    <td><b id="total-sum">{{ rupiah($sum) }}</b></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addArmadaModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Armada</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="/administrator/tambah-armada" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row mb-3">
                            <div class="col-12 mb-3">
                                <label for="" class="form-label">Nomor Armada</label>
                                <input type="text" value="{{ $newIdArmada }}" class="form-control" id=""
                                    required readonly name="armada_id">
                            </div>
                            <div class="col-12 mb-3">
                                <label for="" class="form-label">Username</label>
                                <input type="text" class="form-control" id="" required name="username">
                            </div>
                            <div class="col-12 mb-3">
                                <label for="" class="form-label">Password</label>
                                <input type="text" class="form-control" id="" required name="password">
                            </div>
                            <div class="col-12 mb-3">
                                <label for="" class="form-label">Nama Driver</label>
                                <input type="text" class="form-control" id="" required name="armada_driver">
                            </div>
                            <div class="col-12 mb-3">
                                <label for="" class="form-label">Nomor Polisi</label>
                                <input type="text" class="form-control" id="" required name="armada_plat">
                            </div>
                            <div class="col-12 mb-3">
                                <label for="" class="form-label">ID GPS</label>
                                <input type="text" class="form-control" id="" required name="armada_id_gps">
                            </div>
                            <div class="col-12 mb-3">
                                <label for="" class="form-label">Nomor Telpon</label>
                                <input type="text" class="form-control" id="" required name="armada_phone">
                            </div>
                            <div class="col-12 mb-3">
                                <label for="" class="form-label">Wilayah</label>
                                <select name="armada_subdistinct" id="" class="form-control">
                                    @foreach ($kecamatans as $kecamatan)
                                        <option value="{{ $kecamatan->kecamatan_id }}">{{ $kecamatan->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 mb-3">
                                <label for="" class="form-label">Foto Driver</label>
                                <input type="file" class="form-control" id="" required
                                    name="armada_driver_photo" accept="image/png, image/jpg, image/jpeg">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @foreach ($armadas as $armada)
        <div class="modal fade" id="detailArmadaModal{{ $armada->armada_id }}" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Detail Armada</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <img src="{{ $armada->armada_driver_photo }}" width=200>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="deleteArmadaModal{{ $armada->armada_id }}" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Hapus Armada</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        anda yakin ingin menghapus armada <b>{{ $armada->armada_id }}</b>?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <a href="/administrator/hapus-armada/{{ $armada->armada_id }}" class="btn btn-danger">Hapus</a>
                    </div>0
                </div>
            </div>
        </div>

        <div class="modal fade" id="editArmadaModal{{ $armada->armada_id }}" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Ubah Armada</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="/administrator/ubah-armada" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="row mb-3">
                                <div class="col-12 mb-3">
                                    <label for="" class="form-label">Nomor Armada</label>
                                    <input type="text" value="{{ $armada->armada_id }}" class="form-control"
                                        id="" required readonly name="armada_id">
                                </div>
                                <div class="col-12 mb-3">
                                    <label for="" class="form-label">Username</label>
                                    <input type="text" value="{{ $armada->user->nik }}" class="form-control"
                                        id="" required name="username">
                                </div>
                                <div class="col-12 mb-3">
                                    <label for="" class="form-label">Password</label>
                                    <input type="text" class="form-control" id="" name="password">
                                    <div class="form-text">Silakan isi jika ingin merubah password.</div>
                                </div>
                                <div class="col-12 mb-3">
                                    <label for="" class="form-label">Nama Driver</label>
                                    <input type="text" value="{{ $armada->armada_driver }}" class="form-control"
                                        id="" required name="armada_driver">
                                </div>
                                <div class="col-12 mb-3">
                                    <label for="" class="form-label">Nomor Polisi</label>
                                    <input type="text" value="{{ $armada->armada_plat }}" class="form-control"
                                        id="" required name="armada_plat">
                                </div>
                                <div class="col-12 mb-3">
                                    <label for="" class="form-label">ID GPS</label>
                                    <input type="text" value="{{ $armada->armada_id_gps }}" class="form-control"
                                        id="" required name="armada_id_gps">
                                </div>
                                <div class="col-12 mb-3">
                                    <label for="" class="form-label">Nomor Telpon</label>
                                    <input type="text" value="{{ $armada->armada_phone }}" class="form-control"
                                        id="" required name="armada_phone">
                                </div>
                                <div class="col-12 mb-3">
                                    <label for="" class="form-label">Wilayah</label>
                                    <select name="armada_subdistinct" id="" class="form-control">
                                        @foreach ($kecamatans as $kecamatan)
                                            @if ($kecamatan->kecamatan_id == $armada->armada_subdistinct)
                                                <option value="{{ $kecamatan->kecamatan_id }}" selected>
                                                    {{ $kecamatan->nama }}</option>
                                            @else
                                                <option value="{{ $kecamatan->kecamatan_id }}">{{ $kecamatan->nama }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12 mb-3">
                                    <label for="" class="form-label">Foto Driver</label>
                                    <input type="file" class="form-control" id="" name="armada_driver_photo"
                                        accept="image/png, image/jpg, image/jpeg">
                                    <div class="form-text">Silakan isi jika ingin merubah foto driver.</div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Ubah</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
@endsection


@section('js')
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

    <script>
        new DataTable('#table', {
            responsive: true
        });
        let table = new DataTable('#table-revenue', {
            responsive: true
        });

        function refreshTable() {
            let tables = document.getElementById('tbody');
            table.destroy();
            let time = document.getElementById('time').value;
            let status = document.getElementById('status_job').value;
            let driver = document.getElementById('driver').value;

            var datas = {
                _token: "{{ csrf_token() }}",
                time: time,
                status: status,
                driver: driver,
            };
            tables.innerHTML = '';

            $.ajax({
                type: 'POST',
                url: '/administrator/sum-revenue-driver',
                data: datas,
                success: function(response) {
                    document.getElementById('total-sum').innerHTML = "Rp. " + formatRupiah(Math.round(response.sum).toString()) + ",00"
                    for (let i = 0; i < response.datas.length; i++) {
                        let statusJob = '';
                        if(response.datas[i].order_status_job == 'on_queue') {
                            statusJob = `<span class="badge bg-info rounded-3 fw-semibold">Dalam
                                                    Antrian</span>`;
                        } else if(response.datas[i].order_status_job == 'on_the_way') {
                            statusJob = `<span class="badge bg-info rounded-3 fw-semibold">Sedang
                                                    Dijalan</span>`;
                        } else if(response.datas[i].order_status_job == 'on_process') {
                            statusJob = `<span class="badge bg-info rounded-3 fw-semibold">Sedang
                                                    Dikerjakan</span>`;
                        } else if(response.datas[i].order_status_job == 'done') {
                            statusJob = `<span class="badge bg-success rounded-3 fw-semibold">Selesai</span>`;
                        }
                        tables.innerHTML += `
                        <tr>
                            <td>${response.datas[i].armada.armada_id} - ${response.datas[i].armada.armada_driver}</td>
                            <td>${response.datas[i].order_invoice}</td>
                            <td>${statusJob}</td>
                            <td>Rp.${formatRupiah(Math.round(response.datas[i].order_price).toString())},00</td>
                        </tr>
                        `;
                    }

                    table = $('#table-revenue').DataTable({
                        responsive: true
                    });
                }
            });
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
