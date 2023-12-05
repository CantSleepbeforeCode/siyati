@extends('base.auth')
@section('content')
    <form action="/daftar" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="" class="form-label">Nama Sesuai KTP</label>
            <input type="text" class="form-control" id="" required name="customer_name">
        </div>
        <div class="mb-3">
            <label for="" class="form-label">NIK</label>
            <input type="text" class="form-control" id="" required name="nik">
        </div>
        <div class="mb-3">
            <label for="" class="form-label">Nomor HP</label>
            <input type="text" class="form-control" id="" required name="customer_phone">
        </div>
        <div class="mb-3">
            <label for="" class="form-label">Nomenklatur</label>
            <select required name="customer_nomenklatur" class="form-control">
                <option value="PERKANTORAN">PERKANTORAN</option>
                <option value="HOTEL">HOTEL</option>
                <option value="RUMAH TANGGA">RUMAH TANGGA</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="" class="form-label">Alamat Sesuai KTP</label>
            <input type="text" class="form-control" id="" required name="customer_address">
        </div>
        <div class="row mb-3">
            <div class="col">
                <div class="mb-3">
                    <label for="" class="form-label">Kecamatan</label>
                    <select required name="customer_subdistrict" class="form-control">
                        @foreach ($kecamatans as $kecamatan)
                        <option value="{{$kecamatan->nama}}">{{$kecamatan->nama}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col">
                <div class="mb-3">
                    <label for="" class="form-label">Kelurahan</label>
                    <select required name="customer_urban_village" class="form-control">
                        @foreach ($kelurahans as $kelurahan)
                        <option value="{{$kelurahan->nama}}">{{$kelurahan->nama}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-9">
                <label for="" class="form-label">Vol Kapasitas Sepithank / M3</label>
                <input type="number" class="form-control" id="" required name="customer_vol">
            </div>
            <div class="col">
                <label for="" class="form-label">Satuan</label>
                <select required name="customer_unit" class="form-control">
                    <option value="M2">M2</option>
                    <option value="M3">M3</option>
                    <option value="LITER">LITER</option>
                    <option value="KG">KG</option>
                </select>
            </div>
        </div>
        <div class="mb-4">
            <label for="" class="form-label">Foto Rumah</label>
            <input type="file" required name="customer_photo" class="form-control" id="">
        </div>
        <div class="mb-4">
            <label for="" class="form-label">Password</label>
            <input type="password" required name="password" class="form-control" id="">
        </div>
        <input type="submit" value="Masuk" class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2">
        <div class="d-flex align-items-center justify-content-center">
            <p class="fs-4 mb-0 fw-bold">Sudah punya akun?</p>
            <a class="text-primary fw-bold ms-2" href="/masuk">Masuk</a>
        </div>
    </form>
@endsection
