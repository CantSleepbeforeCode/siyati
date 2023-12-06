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
                                <h5 class="card-title fw-semibold mb-4">List User Siyati</h5>
                            </div>
                            <div class="col">
                                <a href="/administrator/export-member" class="btn btn-primary float-end">Export</a>
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
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Aksi</h6>
                                        </th>
                                    </tr>
                                </thead>

                                <tbody>
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
                                            <td class="border-bottom-0">
                                                <button class="btn btn-info" data-bs-toggle="modal"
                                                    data-bs-target="#detailModal{{ $customer->customer_id }}">
                                                    <i class="ti ti-edit"></i> Detail
                                                </button>
                                                <button class="btn btn-warning" data-bs-toggle="modal"
                                                    data-bs-target="#editModal{{ $customer->customer_id }}">
                                                    <i class="ti ti-edit"></i> Edit
                                                </button>
                                                <button class="btn btn-danger" data-bs-toggle="modal"
                                                    data-bs-target="#deleteModal{{ $customer->customer_id }}">
                                                    <i class="ti ti-trash"></i> Hapus
                                                </button>
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

        @foreach ($customers as $customer)
        
        <div class="modal fade" id="detailModal{{ $customer->customer_id }}" tabindex="-1"
            aria-labelledby="detailModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="detailModalLabel">List Septic Tank</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-striped">
                            <tr>
                                <td>Volume</td>
                                <td>Unit</td>
                            </tr>
                            @foreach ($customer->sepithank as $sepithank)
                                <tr>
                                    <td>{{ $sepithank->sepithank_vol }}</td>
                                    <td>{{ $sepithank->sepithank_unit }}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
            <div class="modal fade" id="editModal{{ $customer->customer_id }}" tabindex="-1"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Ubah data member {{ $customer->customer_name }}
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="/administrator/update-member" method="POST">
                            @csrf
                            <input type="hidden" name="customer" value="{{ $customer->customer_id }}">
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="" class="form-label">Nama</label>
                                    <input type="text" class="form-control" id=""
                                        value="{{ $customer->customer_name }}" required name="customer_name">
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Nomor Telpon</label>
                                    <input type="text" class="form-control" id=""
                                        value="{{ $customer->customer_phone }}" required name="customer_phone">
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Alamat</label>
                                    <input type="text" class="form-control" id=""
                                        value="{{ $customer->customer_address }}" required name="customer_address">
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Nomenklatur</label>
                                    <select required name="customer_nomenklatur" class="form-control">
                                        <option value="PERKANTORAN" @if ($customer->customer_nomenklatur == 'PERKANTORAN') selected @endif>
                                            PERKANTORAN</option>
                                        <option value="HOTEL" @if ($customer->customer_nomenklatur == 'HOTEL') selected @endif>
                                            HOTEL</option>
                                        <option value="RUMAH TANGGA" @if ($customer->customer_nomenklatur == 'RUMAH TANGGA') selected @endif>
                                            RUMAH TANGGA</option>
                                    </select>
                                </div>
                                <div class="row mb-3">
                                    <div class="col">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Kecamatan</label>
                                            <select required name="customer_subdistrict" class="form-control">
                                                <option value="PALU UTARA"
                                                    @if ($customer->customer_subdistrict == 'PALU UTARA') selected @endif>
                                                    PALU UTARA</option>
                                                <option value="PALU BARAT"
                                                    @if ($customer->customer_subdistrict == 'PALU BARAT') selected @endif>
                                                    PALU BARAT</option>
                                                <option value="PALU TIMUR"
                                                    @if ($customer->customer_subdistrict == 'PALU TIMUR') selected @endif>
                                                    PALU TIMUR</option>
                                                <option value="PALU SELATAN"
                                                    @if ($customer->customer_subdistrict == 'PALU SELATAN') selected @endif>
                                                    PALU SELATAN</option>
                                                <option value="ULUJADI" @if ($customer->customer_subdistrict == 'ULUJADI') selected @endif>
                                                    ULUJADI</option>
                                                <option value="TAWAELI" @if ($customer->customer_subdistrict == 'TAWAELI') selected @endif>
                                                    TAWAELI</option>
                                                <option value="TATANGA" @if ($customer->customer_subdistrict == 'TATANGA') selected @endif>
                                                    TATANGA</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Kelurahan</label>
                                            <select required name="customer_urban_village" class="form-control">
                                                <option value="BAYAOGE"
                                                    @if ($customer->customer_urban_village == 'BAYAOGE') selected @endif>
                                                    BAYAOGE</option>
                                                <option value="PENGAWU"
                                                    @if ($customer->customer_urban_village == 'PENGAWU') selected @endif>
                                                    PENGAWU</option>
                                                <option value="NUNU" @if ($customer->customer_urban_village == 'NUNU') selected @endif>
                                                    NUNU
                                                </option>
                                                <option value="TAWANJUKA"
                                                    @if ($customer->customer_urban_village == 'TAWANJUKA') selected @endif>
                                                    TAWANJUKA</option>
                                                <option value="DUYU" @if ($customer->customer_urban_village == 'DUYU') selected @endif>
                                                    DUYU
                                                </option>
                                                <option value="SILAE" @if ($customer->customer_urban_village == 'SILAE') selected @endif>
                                                    SILAE
                                                </option>
                                                <option value="TALISE" @if ($customer->customer_urban_village == 'TALISE') selected @endif>
                                                    TALISE</option>
                                                <option value="TALISE VALANGGUNI"
                                                    @if ($customer->customer_urban_village == 'TALISE VALANGGUNI') selected @endif>TALISE VALANGGUNI
                                                </option>
                                                <option value="TONDO" @if ($customer->customer_urban_village == 'TONDO') selected @endif>
                                                    TONDO
                                                </option>
                                                <option value="MAMBORO"
                                                    @if ($customer->customer_urban_village == 'MAMBORO') selected @endif>
                                                    MAMBORO</option>
                                                <option value="MAMBORO BARAT"
                                                    @if ($customer->customer_urban_village == 'MAMBORO BARAT') selected @endif>MAMBORO BARAT
                                                </option>
                                                <option value="TAIPA" @if ($customer->customer_urban_village == 'TAIPA') selected @endif>
                                                    TAIPA
                                                </option>
                                                <option value="BAIYA" @if ($customer->customer_urban_village == 'BAIYA') selected @endif>
                                                    BAIYA
                                                </option>
                                                <option value="BESUSU BARAT"
                                                    @if ($customer->customer_urban_village == 'BESUSU BARAT') selected @endif>BESUSU BARAT
                                                </option>
                                                <option value="BESUSU TENGAH"
                                                    @if ($customer->customer_urban_village == 'BESUSU TENGAH') selected @endif>BESUSU TENGAH
                                                </option>
                                                <option value="BESUSU TIMUR"
                                                    @if ($customer->customer_urban_village == 'BESUSU TIMUR') selected @endif>BESUSU TIMUR
                                                </option>
                                                <option value="UJUNA" @if ($customer->customer_urban_village == 'UJUNA') selected @endif>
                                                    UJUNA
                                                </option>
                                                <option value="BIROBULI UTARA"
                                                    @if ($customer->customer_urban_village == 'BIROBULI UTARA') selected @endif>BIROBULI UTARA
                                                </option>
                                                <option value="BIROBULI SELATAN"
                                                    @if ($customer->customer_urban_village == 'BIROBULI SELATAN') selected @endif>BIROBULI SELATAN
                                                </option>
                                                <option value="LOLU SELATAN"
                                                    @if ($customer->customer_urban_village == 'LOLU SELATAN') selected @endif>LOLU SELATAN
                                                </option>
                                                <option value="LOLU UTARA"
                                                    @if ($customer->customer_urban_village == 'LOLU UTARA') selected @endif>
                                                    LOLU UTARA</option>
                                                <option value="TANAMODINDI"
                                                    @if ($customer->customer_urban_village == 'TANAMODINDI') selected @endif>
                                                    TANAMODINDI</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-9">
                                        <label for="" class="form-label">Vol Kapasitas Septic Tank / M3</label>
                                        <input type="number" class="form-control" id=""
                                            value={{ $customer->customer_vol }} required name="customer_vol">
                                    </div>
                                    <div class="col">
                                        <label for="" class="form-label">Satuan</label>
                                        <select required name="customer_unit" class="form-control">
                                            <option value="M2" @if ($customer->customer_urban_village == 'M2') selected @endif>M2
                                            </option>
                                            <option value="M3" @if ($customer->customer_urban_village == 'M3') selected @endif>M3
                                            </option>
                                            <option value="LITER" @if ($customer->customer_urban_village == 'LITER') selected @endif>
                                                LITER
                                            </option>
                                            <option value="KG" @if ($customer->customer_urban_village == 'KG') selected @endif>KG
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
            <div class="modal fade" id="deleteModal{{ $customer->customer_id }}" tabindex="-1"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Hapus data member
                                {{ $customer->customer_name }}?</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Setelah dihapus, data tidak dapat dikembalikan. Anda yakin?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <a href="/administrator/delete-member/{{ $customer->customer_id }}"
                                class="btn btn-danger">Ya, Hapus</a>
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
            responsive: true
        });
    </script>
@endsection
