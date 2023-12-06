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
                                <h5 class="card-title fw-semibold mb-4">Septic Tank Saya</h5>
                            </div>
                            <div class="col">
                                <button class="btn btn-primary float-end" data-bs-toggle="modal"
                                    data-bs-target="#modalAddSepithank">Tambah</button>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table id="table" class="table text-nowrap mb-0 align-middle">
                                <thead class="text-dark fs-4">
                                    <tr>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Volume</h6>
                                        </th>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Unit</h6>
                                        </th>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Aksi</h6>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sepithanks as $sepithank)
                                        <tr>
                                            <td class="border-bottom-0">
                                                <h6 class="fw-semibold mb-0">{{ $sepithank->sepithank_vol }}</h6>
                                            </td>
                                            <td class="border-bottom-0">
                                                <h6 class="fw-semibold mb-0">{{ $sepithank->sepithank_unit }}</h6>
                                            </td>
                                            <td class="border-bottom-0">
                                                <button class="btn btn-warning" data-bs-toggle="modal"
                                                    data-bs-target="#editModal{{ $sepithank->sepithank_id }}">Ubah</button>
                                                <button class="btn btn-danger" data-bs-toggle="modal"
                                                    data-bs-target="#deleteModal{{ $sepithank->sepithank_id }}">Hapus</button>
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

        <div class="modal fade" id="modalAddSepithank" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Septic Tank</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="/tambah-sepithank" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="row mb-3">
                                <div class="col-9">
                                    <label for="" class="form-label">Vol Kapasitas Septic Tank / M3</label>
                                    <input type="number" class="form-control" id="" required name="sepithank_vol">
                                </div>
                                <div class="col">
                                    <label for="" class="form-label">Satuan</label>
                                    <select required name="sepithank_unit" class="form-control">
                                        <option value="M2">M2
                                        </option>
                                        <option value="M3">M3
                                        </option>
                                        <option value="LITER">LITER
                                        </option>
                                        <option value="KG">KG
                                        </option>
                                    </select>
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

        @foreach ($sepithanks as $sepithank)
            <div class="modal fade" id="editModal{{ $sepithank->sepithank_id }}" tabindex="-1"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Ubah Septic Tank</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="/edit-sepithank" method="POST">
                            @csrf
                            <input type="hidden" name="sepithank" value="{{ $sepithank->sepithank_id }}">
                            <div class="modal-body">
                                <div class="row mb-3">
                                    <div class="col-9">
                                        <label for="" class="form-label">Vol Kapasitas Septic Tank / M3</label>
                                        <input type="number" class="form-control" id=""
                                            value={{ $sepithank->sepithank_vol }} required name="sepithank_vol">
                                    </div>
                                    <div class="col">
                                        <label for="" class="form-label">Satuan</label>
                                        <select required name="sepithank_unit" class="form-control">
                                            <option value="M2" @if ($sepithank->sepithank_unit == 'M2') selected @endif>M2
                                            </option>
                                            <option value="M3" @if ($sepithank->sepithank_unit == 'M3') selected @endif>M3
                                            </option>
                                            <option value="LITER" @if ($sepithank->sepithank_unit == 'LITER') selected @endif>LITER
                                            </option>
                                            <option value="KG" @if ($sepithank->sepithank_unit == 'KG') selected @endif>KG
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn btn-warning">Ubah</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="deleteModal{{ $sepithank->sepithank_id }}" tabindex="-1"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Hapus Septic Tank</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Anda yakin ingin menghapus data Septic Tank {{ $sepithank->sepithank_vol }}
                            {{ $sepithank->sepithank_unit }}?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <a href="/hapus-sepithank/{{ $sepithank->sepithank_id }}" class="btn btn-danger">Hapus</a>
                        </div>
                        </form>
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
            responsive: true
        });
    </script>
@endsection
