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
                            <h5 class="card-title fw-semibold mb-4">Kecamatan</h5>
                        </div>
                        <div class="col">
                            <button class="btn btn-primary float-end" data-bs-toggle="modal"
                                data-bs-target="#addKecamatanModal">Tambah</button>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="table" class="table text-nowrap mb-0 align-middle">
                            <thead class="text-dark fs-4">
                                <tr>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Kode</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Nama</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Aksi</h6>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($kecamatans as $kecamatan)
                                    <tr>
                                        <td class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">{{ $kecamatan->kecamatan_id }}</h6>
                                        </td>
                                        <td class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">{{ $kecamatan->nama }}</h6>
                                        </td>
                                        <td class="border-bottom-0">
                                            <button class="btn btn-warning" data-bs-toggle="modal"
                                                data-bs-target="#editKecamatanModal{{ $kecamatan->kecamatan_id }}">Ubah</button>
                                            <button class="btn btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#deleteKecamatanModal{{ $kecamatan->kecamatan_id }}">Hapus</button>
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
                            <h5 class="card-title fw-semibold mb-4">Kelurahan</h5>
                        </div>
                        <div class="col">
                            <button class="btn btn-primary float-end" data-bs-toggle="modal"
                                data-bs-target="#addKelurahanModal">Tambah</button>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="table1" class="table text-nowrap mb-0 align-middle">
                            <thead class="text-dark fs-4">
                                <tr>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Kode</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Kecamatan</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Nama</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Aksi</h6>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($kelurahans as $kelurahan)
                                    <tr>
                                        <td class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">{{ $kelurahan->kelurahan_id }}</h6>
                                        </td>
                                        <td class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">{{ $kelurahan->kecamatan->nama }}</h6>
                                        </td>
                                        <td class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">{{ $kelurahan->nama }}</h6>
                                        </td>
                                        <td class="border-bottom-0">
                                            <button class="btn btn-warning" data-bs-toggle="modal"
                                                data-bs-target="#editKelurahanModal{{ $kelurahan->kelurahan_id }}">Ubah</button>
                                            <button class="btn btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#deleteKelurahanModal{{ $kelurahan->kelurahan_id }}">Hapus</button>
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
                            <h5 class="card-title fw-semibold mb-4">Tipe Bangunan</h5>
                        </div>
                        <div class="col">
                            <button class="btn btn-primary float-end" data-bs-toggle="modal"
                                data-bs-target="#addNomenclatureModal">Tambah</button>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="table2" class="table text-nowrap mb-0 align-middle">
                            <thead class="text-dark fs-4">
                                <tr>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Nama</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Aksi</h6>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($nomenclatures as $nomenclature)
                                    <tr>
                                        <td class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">{{ $nomenclature->nomenclature_name }}</h6>
                                        </td>
                                        <td class="border-bottom-0">
                                            <button class="btn btn-warning" data-bs-toggle="modal"
                                                data-bs-target="#editNomenclatureModal{{ $nomenclature->nomenclature_id }}">Ubah</button>
                                            <button class="btn btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#deleteNomenclatureModal{{ $nomenclature->nomenclature_id }}">Hapus</button>
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

    <div class="modal fade" id="addKecamatanModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Kecamatan</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="/administrator/tambah-kecamatan" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row mb-3">
                            <div class="col-12 mb-3">
                                <label for="" class="form-label">Kode</label>
                                <input type="number" class="form-control" id="" required name="kecamatan_id">
                            </div>
                            <div class="col-12">
                                <label for="" class="form-label">Nama</label>
                                <input type="text" class="form-control" id="" required name="nama">
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

    <div class="modal fade" id="addKelurahanModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Kelurahan</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="/administrator/tambah-kelurahan" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row mb-3">
                            <div class="col-12 mb-3">
                                <label for="" class="form-label">Kode</label>
                                <input type="number" class="form-control" id="" required name="kelurahan_id">
                            </div>
                            <div class="col-12 mb-3">
                                <label for="" class="form-label">Kecamatan</label>
                                <select name="kecamatan_id" class="form-control">
                                    @foreach ($kecamatans as $kecamatan)
                                        <option value="{{ $kecamatan->kecamatan_id }}">{{ $kecamatan->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12">
                                <label for="" class="form-label">Nama</label>
                                <input type="text" class="form-control" id="" required name="nama">
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

    <div class="modal fade" id="addNomenclatureModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Kecamatan</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="/administrator/tambah-nomenklatur" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row mb-3">
                            <div class="col-12">
                                <label for="" class="form-label">Nama</label>
                                <input type="text" class="form-control" id="" required name="nomenclature_name">
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

    @foreach ($nomenclatures as $nomenclature)
    <div class="modal fade" id="editNomenclatureModal{{ $nomenclature->nomenclature_id }}" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Ubah Tipe Bangunan</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="/administrator/ubah-nomenklatur" method="POST">
                    @csrf
                    <input type="hidden" name="nomenclature" value="{{ $nomenclature->nomenclature_id }}">
                    <div class="modal-body">
                        <div class="row mb-3">
                            <div class="col-12">
                                <label for="" class="form-label">Nama</label>
                                <input type="text" class="form-control" value="{{ $nomenclature->nomenclature_name }}"
                                    id="" required name="nomenclature_name">
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

    <div class="modal fade" id="deleteNomenclatureModal{{ $nomenclature->nomenclature_id }}" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Hapus Tipe Bangunan</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Anda yakin ingin menghapus Tipe Bangunan <b>{{ $nomenclature->nomenclature_name }}</b>?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <a href="/administrator/hapus-nomenklatur/{{ $nomenclature->nomenclature_id }}"
                        class="btn btn-danger">Hapus</a>
                </div>
            </div>
        </div>
    </div>
    @endforeach

    @foreach ($kecamatans as $kecamatan)
        <div class="modal fade" id="editKecamatanModal{{ $kecamatan->kecamatan_id }}" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Ubah Kecamatan</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="/administrator/ubah-kecamatan" method="POST">
                        @csrf
                        <input type="hidden" name="kecamatan" value="{{ $kecamatan->kecamatan_id }}">
                        <div class="modal-body">
                            <div class="row mb-3">
                                <div class="col-12 mb-3">
                                    <label for="" class="form-label">Kode</label>
                                    <input type="number" class="form-control" value="{{ $kecamatan->kecamatan_id }}"
                                        id="" required name="kecamatan_id">
                                </div>
                                <div class="col-12">
                                    <label for="" class="form-label">Nama</label>
                                    <input type="text" class="form-control" value="{{ $kecamatan->nama }}"
                                        id="" required name="nama">
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

        <div class="modal fade" id="deleteKecamatanModal{{ $kecamatan->kecamatan_id }}" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Hapus Kecamatan</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Anda yakin ingin menghapus kecamatan <b>{{ $kecamatan->nama }}</b>?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <a href="/administrator/hapus-kecamatan/{{ $kecamatan->kecamatan_id }}"
                            class="btn btn-danger">Hapus</a>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    @foreach ($kelurahans as $kelurahan)
        <div class="modal fade" id="editKelurahanModal{{ $kelurahan->kelurahan_id }}" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Ubah Kelurahan</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="/administrator/ubah-kelurahan" method="POST">
                        @csrf
                        <input type="hidden" name="kelurahan" value="{{ $kelurahan->kelurahan_id }}">
                        <div class="modal-body">
                            <div class="row mb-3">
                                <div class="col-12 mb-3">
                                    <label for="" class="form-label">Kode</label>
                                    <input type="number" class="form-control" id=""
                                        value="{{ $kelurahan->kelurahan_id }}" required name="kelurahan_id">
                                </div>
                                <div class="col-12 mb-3">
                                    <label for="" class="form-label">Kecamatan</label>
                                    <select name="kecamatan_id" class="form-control">
                                        @foreach ($kecamatans as $kecamatan)
                                            @if ($kecamatan->kecamatan_id == $kelurahan->kecamatan_id)
                                                <option value="{{ $kecamatan->kecamatan_id }}" selected>
                                                    {{ $kecamatan->nama }}</option>
                                            @else
                                                <option value="{{ $kecamatan->kecamatan_id }}">{{ $kecamatan->nama }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label for="" class="form-label">Nama</label>
                                    <input type="text" class="form-control" value="{{ $kelurahan->nama }}"
                                        id="" required name="nama">
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

        <div class="modal fade" id="deleteKelurahanModal{{ $kelurahan->kelurahan_id }}" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Hapus Kelurahan</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Anda yakin ingin menghapus kelurahan <b>{{ $kelurahan->nama }}</b>?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <a href="/administrator/hapus-kelurahan/{{ $kelurahan->kelurahan_id }}"
                            class="btn btn-danger">Hapus</a>
                    </div>
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
        new DataTable('#table1', {
            responsive: true
        });
        new DataTable('#table2', {
            responsive: true
        });
    </script>
@endsection