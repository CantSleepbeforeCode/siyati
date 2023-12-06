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
                            <img src="{{ $customer->customer_photo }}" width="200" height="200" class="">
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
                                Jenis Bangunan
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
                                            @foreach ($kecamatans as $kecamatan)
                                                @if($kecamatan->nama == $customer->customer_subdistrict)
                                                <option value="{{$kecamatan->nama}}" selected>{{$kecamatan->nama}}</option>
                                                @else
                                                <option value="{{$kecamatan->nama}}">{{$kecamatan->nama}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="" class="form-label">Kelurahan</label>
                                        <select required name="customer_urban_village" class="form-control">
                                            @foreach ($kelurahans as $kelurahan)
                                                @if($kelurahan->nama == $customer->customer_urban_village)
                                                <option value="{{$kelurahan->nama}}" selected>{{$kelurahan->nama}}</option>
                                                @else
                                                <option value="{{$kelurahan->nama}}">{{$kelurahan->nama}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label for="" class="form-label">Foto Rumah</label>
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
