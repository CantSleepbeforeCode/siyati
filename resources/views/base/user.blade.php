<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SIYATI - Sistem Informasi Pelayanan Sedot Tinja</title>
    <link rel="shortcut icon" type="image/png" href="/image/web/palu.png" />
    <link rel="stylesheet" href="/assets/css/styles.min.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

    @yield('css')
</head>

<body style="height: 100% width:100%">
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <!-- Sidebar Start -->
        <aside class="left-sidebar">
            <!-- Sidebar scroll-->
            <div>
                <div class="row text-center">
                    <div class="brand-logo d-flex align-items-center justify-content-between mx-auto w-50" style="padding: 0px;">
                        <a href="/beranda" class="text-nowrap logo-img">
                            <div class="text-center">
                                <span>
                                    <img src="/image/web/palu.png" width="50" alt="" />
                                    <span class="fw-bolder text-dark h4 mt-3">SIYATI </span> <br>
                                </span>
                            </div>
                        </a>
                        <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                            <i class="ti ti-x fs-8"></i>
                        </div>
                    </div>
                </div>
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
                    <ul id="sidebarnav" class="mt-4">
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="/beranda" aria-expanded="false">
                                <span>
                                    <i class="ti ti-layout-dashboard"></i>
                                </span>
                                <span class="hide-menu">Beranda</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="/septic-tank" aria-expanded="false">
                                <span>
                                    <i class="ti ti-box"></i>
                                </span>
                                <span class="hide-menu">Septic Tank</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="/permintaan" aria-expanded="false">
                                <span>
                                    <i class="ti ti-flag"></i>
                                </span>
                                <span class="hide-menu">Permintaan</span>
                            </a>
                        </li>
                        {{-- <li class="sidebar-item">
                            <a class="sidebar-link" href="/pembayaran" aria-expanded="false">
                                <span>
                                    <i class="ti ti-wallet"></i>
                                </span>
                                <span class="hide-menu">Pembayaran</span>
                            </a>
                        </li> --}}
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="/laporan" aria-expanded="false">
                                <span>
                                    <i class="ti ti-receipt"></i>
                                </span>
                                <span class="hide-menu">Laporan</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="/e-card-siyati" aria-expanded="false">
                                <span>
                                    <i class="ti ti-id-badge"></i>
                                </span>
                                <span class="hide-menu">E-Card Siyati</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link-no-active" href="https://wa.me/{{\App\Models\AppSetting::find(1)->admin_wa}}" target="__blank"
                                aria-expanded="false">
                                <span>
                                    <i class="ti ti-brand-whatsapp"></i>
                                </span>
                                <span class="hide-menu">Whatsapp Petugas</span>
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
        <!--  Sidebar End -->
        <!--  Main wrapper -->
        <div class="body-wrapper">
            <!--  Header Start -->
            <header class="app-header">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <ul class="navbar-nav">
                        <li class="nav-item d-block d-xl-none">
                            <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse"
                                href="javascript:void(0)">
                                <i class="ti ti-menu-2"></i>
                            </a>
                        </li>
                    </ul>
                    <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
                        <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
                            <li class="nav-item dropdown">
                                <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <img src="{{ asset('image/web/profile.jpg') }}" alt="" width="35"
                                        height="35" class="rounded-circle">
                                </a>
                                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up"
                                    aria-labelledby="drop2">
                                    <div class="message-body">
                                        <a href="javascript:void(0)"
                                            class="d-flex align-items-center gap-2 dropdown-item">
                                            <i class="ti ti-user fs-6"></i>
                                            <p class="mb-0 fs-3">Akun Saya</p>
                                        </a>
                                        <a href="/keluar" class="btn btn-outline-primary mx-3 mt-2 d-block">Keluar</a>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>
            <!--  Header End -->

            @yield('content')

        </div>
    </div>
    <script src="/assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/sidebarmenu.js"></script>
    <script src="/assets/js/app.min.js"></script>
    {{-- <script src="/assets/libs/apexcharts/dist/apexcharts.min.js"></script> --}}
    <script src="/assets/libs/simplebar/dist/simplebar.js"></script>
    <script src="/assets/js/dashboard.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    @yield('js')

    <script>
        $(document).ready(function() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition);
            }
        });

        function showPosition(position) {
            $.ajax('/send-location', {
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    latitude: position.coords.latitude,
                    longitude: position.coords.longitude
                },
                success: function(data, status, xhr) {},
            });
        }
    </script>

</body>

</html>
