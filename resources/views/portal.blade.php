<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SIYATI - Sistem Informasi Pelayanan Sedot Tinja</title>
    <link rel="shortcut icon" type="image/png" href="/image/web/palu.png" />
    <link rel="stylesheet" href="/assets/css/styles.min.css" />

    <style>
        @media (max-width: 480px) {
            body {
                font-size: 2.5vw;
            }
            .mh {
                min-height: 70vh;
            }
        }

        .mh {
                min-height: 80vh;
        }
    </style>
</head>

<body style="background-color: #f0f3fc;">
    <div class="ms-3 me-3 text-center align-items-center my-auto row mh">
        <div class="">
            <img class="mb-5" src="{{ asset('image/web/palu.png') }}">
            <div class="row justify-content-center">
                <div class="col-4 mb-4">
                    <div class="card mb-0">
                        <div class="card-body text-center ps-1 pe-1" style="">
                            <a href="/masuk"
                                class="link-dark link-underline link-underline-opacity-0 fw-bolder my-2">LOGIN</a>
                        </div>
                    </div>
                </div>
                <div class="col-4 mb-4">
                    <div class="card mb-0">
                        <div class="card-body text-center  ps-1 pe-1">
                            <a href="/daftar"
                                class="link-dark link-underline link-underline-opacity-0 fw-bolder my-2">DAFTAR</a>
                        </div>
                    </div>
                </div>
                <div class="col-4 mb-4">
                    <div class="card mb-0">
                        <div class="card-body text-center  ps-1 pe-1">
                            <a href="#" data-bs-toggle="modal"
                            data-bs-target="#ruteModal"
                                class="link-dark link-underline link-underline-opacity-0 fw-bolder my-2">RUTE</a>
                        </div>
                    </div>
                </div>
                <div class="col-4 mb-4">
                    <div class="card mb-0">
                        <div class="card-body text-center  ps-1 pe-1">
                            <a href="#" data-bs-toggle="modal"
                            data-bs-target="#scheduleModal"
                                class="link-dark link-underline link-underline-opacity-0 fw-bolder my-2">SCHEDULE</a>
                        </div>
                    </div>
                </div>
                <div class="col-4 mb-4">
                    <div class="card mb-0">
                        <div class="card-body text-center  ps-1 pe-1">
                            <a href="#" data-bs-toggle="modal"
                            data-bs-target="#regulasiModal"
                                class="link-dark link-underline link-underline-opacity-0 fw-bolder my-2">REGULASI</a>
                        </div>
                    </div>
                </div>
                <div class="col-4 mb-4">
                    <div class="card mb-0">
                        <div class="card-body text-center  ps-1 pe-1">
                            <a href="https://wa.me/6281277057373" target="__blank"
                                class="link-dark link-underline link-underline-opacity-0 fw-bolder my-2">CHAT
                                SAYA</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="text-center mb-5">
        <span style="position:absolute; bottom: 15px; left: 0; right: 0;"><img src="{{ asset('image/web/dpu.jpg') }}"
                width="50"> <span class="ms-2 fw-bold text-dark">Dinas Pekerjaan Umum Kota Palu</span></span>
    </div>

    
    <div class="modal fade" id="ruteModal" tabindex="-1"
        aria-labelledby="ruteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="ruteModalLabel">Rute</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Placeholder Rute
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    {{-- <a href="" class="btn btn-success">Selesai</a> --}}
                </div>
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="scheduleModal" tabindex="-1"
        aria-labelledby="scheduleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="scheduleModalLabel">Schedule</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Placeholder Schedule
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    {{-- <a href="" class="btn btn-success">Selesai</a> --}}
                </div>
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="regulasiModal" tabindex="-1"
        aria-labelledby="regulasiModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="regulasiModalLabel">Regulasi</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Placeholder Regulasi
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    {{-- <a href="" class="btn btn-success">Selesai</a> --}}
                </div>
            </div>
        </div>
    </div>
    {{-- 
    <div class=" justify-content-center align-items-center min-vh-100 d-flex">
        <div class="row ms-3 me-3">
        </div>
    </div> --}}
    <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
