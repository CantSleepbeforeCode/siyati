@extends('base.user')
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
            <div class="col-lg-4 col-md-12">
                <div class="card overflow-hidden">
                    <div class="card-body p-4">
                        <h5 class="card-title mb-9 fw-semibold">Profil Saya</h5>
                        <div class="text-center">
                            <img src="{{ $customer->customer_photo }}" width="200" height="200" class="rounded-circle">
                        </div>

                        <hr class="mt-4 mb-4" />

                        <div class="row mt-3">
                            <div class="col-5">
                                Nama
                            </div>
                            <div class="col-1">
                                :
                            </div>
                            <div class="col">
                                {{ $customer->customer_name }}
                            </div>
                        </div>

                        <div class="row mt-1">
                            <div class="col-5">
                                NIK
                            </div>
                            <div class="col-1">
                                :
                            </div>
                            <div class="col">
                                {{ Auth::user()->nik }}
                            </div>
                        </div>

                        <div class="row mt-1">
                            <div class="col-5">
                                Nomor Telepon
                            </div>
                            <div class="col-1">
                                :
                            </div>
                            <div class="col">
                                {{ $customer->customer_phone }}
                            </div>
                        </div>

                        <div class="row mt-1">
                            <div class="col-5">
                                Nomenklatur
                            </div>
                            <div class="col-1">
                                :
                            </div>
                            <div class="col">
                                {{ $customer->customer_nomenklatur }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card overflow-hidden">
                    <div class="card-body p-4">
                        <h5 class="card-title mb-9 fw-semibold">Ubah Profil</h5>

                        <form action="/ubah-profil" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="" class="form-label">Alamat Sesuai KTP</label>
                                <input type="text" class="form-control" id=""
                                    value="{{ $customer->customer_address }}" required name="customer_address">
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="" class="form-label">Kecamatan</label>
                                        <select required name="customer_subdistrict" class="form-control">
                                            <option value="PALU UTARA" @if ($customer->customer_subdistrict == 'PALU UTARA') selected @endif>
                                                PALU UTARA</option>
                                            <option value="PALU BARAT" @if ($customer->customer_subdistrict == 'PALU BARAT') selected @endif>
                                                PALU BARAT</option>
                                            <option value="PALU TIMUR" @if ($customer->customer_subdistrict == 'PALU TIMUR') selected @endif>
                                                PALU TIMUR</option>
                                            <option value="PALU SELATAN" @if ($customer->customer_subdistrict == 'PALU SELATAN') selected @endif>
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
                                            <option value="BAYAOGE" @if ($customer->customer_urban_village == 'BAYAOGE') selected @endif>
                                                BAYAOGE</option>
                                            <option value="PENGAWU" @if ($customer->customer_urban_village == 'PENGAWU') selected @endif>
                                                PENGAWU</option>
                                            <option value="NUNU" @if ($customer->customer_urban_village == 'NUNU') selected @endif>NUNU
                                            </option>
                                            <option value="TAWANJUKA" @if ($customer->customer_urban_village == 'TAWANJUKA') selected @endif>
                                                TAWANJUKA</option>
                                            <option value="DUYU" @if ($customer->customer_urban_village == 'DUYU') selected @endif>DUYU
                                            </option>
                                            <option value="SILAE" @if ($customer->customer_urban_village == 'SILAE') selected @endif>SILAE
                                            </option>
                                            <option value="TALISE" @if ($customer->customer_urban_village == 'TALISE') selected @endif>
                                                TALISE</option>
                                            <option value="TALISE VALANGGUNI"
                                                @if ($customer->customer_urban_village == 'TALISE VALANGGUNI') selected @endif>TALISE VALANGGUNI
                                            </option>
                                            <option value="TONDO" @if ($customer->customer_urban_village == 'TONDO') selected @endif>TONDO
                                            </option>
                                            <option value="MAMBORO" @if ($customer->customer_urban_village == 'MAMBORO') selected @endif>
                                                MAMBORO</option>
                                            <option value="MAMBORO BARAT"
                                                @if ($customer->customer_urban_village == 'MAMBORO BARAT') selected @endif>MAMBORO BARAT</option>
                                            <option value="TAIPA" @if ($customer->customer_urban_village == 'TAIPA') selected @endif>TAIPA
                                            </option>
                                            <option value="BAIYA" @if ($customer->customer_urban_village == 'BAIYA') selected @endif>BAIYA
                                            </option>
                                            <option value="BESUSU BARAT"
                                                @if ($customer->customer_urban_village == 'BESUSU BARAT') selected @endif>BESUSU BARAT</option>
                                            <option value="BESUSU TENGAH"
                                                @if ($customer->customer_urban_village == 'BESUSU TENGAH') selected @endif>BESUSU TENGAH</option>
                                            <option value="BESUSU TIMUR"
                                                @if ($customer->customer_urban_village == 'BESUSU TIMUR') selected @endif>BESUSU TIMUR</option>
                                            <option value="UJUNA" @if ($customer->customer_urban_village == 'UJUNA') selected @endif>UJUNA
                                            </option>
                                            <option value="BIROBULI UTARA"
                                                @if ($customer->customer_urban_village == 'BIROBULI UTARA') selected @endif>BIROBULI UTARA</option>
                                            <option value="BIROBULI SELATAN"
                                                @if ($customer->customer_urban_village == 'BIROBULI SELATAN') selected @endif>BIROBULI SELATAN
                                            </option>
                                            <option value="LOLU SELATAN"
                                                @if ($customer->customer_urban_village == 'LOLU SELATAN') selected @endif>LOLU SELATAN</option>
                                            <option value="LOLU UTARA" @if ($customer->customer_urban_village == 'LOLU UTARA') selected @endif>
                                                LOLU UTARA</option>
                                            <option value="TANAMODINDI" @if ($customer->customer_urban_village == 'TANAMODINDI') selected @endif>
                                                TANAMODINDI</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-9">
                                    <label for="" class="form-label">Vol Kapasitas Sepithank / M3</label>
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
                                        <option value="LITER" @if ($customer->customer_urban_village == 'LITER') selected @endif>LITER
                                        </option>
                                        <option value="KG" @if ($customer->customer_urban_village == 'KG') selected @endif>KG
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label for="" class="form-label">Foto Selfie & KTP</label>
                                <input type="file" name="customer_photo" class="form-control" id="">
                            </div>
                            <input type="submit" value="Ubah Profil Saya"
                                class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2">
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col">
                <div class="card overflow-hidden">
                    <div class="card-body p-4">
                        <h5 class="card-title mb-9 fw-semibold">Lokasi Saya</h5>
                        <div class="row">
                            <div class="col">
                                <div id="map" style="height: 300px; width: 100%;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            var map = L.map('map').setView([{{ $customer->customer_lat }}, {{ $customer->customer_long }}], 13);

            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            L.marker([{{ $customer->customer_lat }}, {{ $customer->customer_long }}]).addTo(map);
        });
    </script>
@endsection
