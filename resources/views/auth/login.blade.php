@extends('base.auth')
@section('content')
<form action="/masuk" method="POST">
    @csrf
    <div class="mb-3">
        <label for="" class="form-label">NIK / Username</label>
        <input type="text" class="form-control" id="" required name="nik">
    </div>
    <div class="mb-4">
        <label for="" class="form-label">Password</label>
        <input type="password" required name="password" class="form-control" id="">
    </div>
    <input type="submit" value="Masuk" class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2">
    <div class="d-flex align-items-center justify-content-center">
        <p class="fs-4 mb-0 fw-bold">Tidak punya akun?</p>
        <a class="text-primary fw-bold ms-2" href="/daftar">Daftar</a>
    </div>
</form>
@endsection
