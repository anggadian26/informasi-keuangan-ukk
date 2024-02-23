<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default"
    data-assets-path="../assets/" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>komobox | Dashboard)</title>

    <meta name="description" content="" />

    @include('link-asset.head')

    @include('home.stylecss')
</head>

<body>
    @include('sweetalert::alert')
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->
            @include('partials.sidebar')
            <!-- / Menu -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->
                @include('partials.navbar')
                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->
                    <div class="container-xxl flex-grow-1 container-p-y">
                        <div class="row">
                            <div class="col-lg-12 mb-4 order-0">
                                <div class="card">
                                    <div class="d-flex align-items-end row">
                                        <div class="col-sm-7">
                                            <div class="card-body">
                                                <h5 class="card-title text-primary">Hallo {{ Auth::user()->name }}! 🎉</h5>
                                                @if ($loggedInUser->role->role == 'admin')
                                                    <p class="mb-4">
                                                        Total Penjualan Anda sudah mencapai <span class="fw-bold">{{ $total_penjualan }} kali</span> dan sudah melakukan pembelian sebanyak <span class="fw-bold">{{ $total_pembelian }} kali</span>, tetap semangat dan jangan menyerah 💪
                                                    </p>
                                                @endif
                                                @if ($loggedInUser->role->role == 'owner')
                                                    <p>Tetap semangat, Hari ini adalah awal dari perjalanan menuju kesuksesan yang lebih besar.</p>
                                                @endif
                                                @if ($loggedInUser->role->role == 'manager')
                                                    <p>Kerja keras dan kegigihanmu sebagai seorang manager akan membawa tim menuju puncak keberhasilan.</p>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-sm-5 text-center text-sm-left">
                                            <div class="card-body pb-0 px-0 px-md-4">
                                                <img src="../assets/img/illustrations/man-with-laptop-light.png"
                                                    height="140" alt="View Badge User"
                                                    data-app-dark-img="illustrations/man-with-laptop-dark.png"
                                                    data-app-light-img="illustrations/man-with-laptop-light.png" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Total Revenue -->
                            <div class="col-12 col-lg-8 order-2 order-md-3 order-lg-2 mb-4">
                                <div class="card">
                                    <div class="row row-bordered g-0">
                                        <div class="col-md-12">
                                            <div id="labaRugiGrafik" class="px-2 mt-3"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4 col-md-8 col-lg-4 order-3 order-md-2">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-12 mb-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="card-title d-flex align-items-start">
                                                    <div class="wrapper">
                                                        <header class="text-center">
                                                            <p class="current-date"></p>
                                                            <div class="icons">
                                                                <span id="prev" class="material-symbols-rounded">chevron_left</span>
                                                                <span id="next" class="material-symbols-rounded">chevron_right</span>
                                                            </div>
                                                        </header>
                                                        <div class="calendar">
                                                            <ul class="weeks">
                                                                <li>Sun</li>
                                                                <li>Mon</li>
                                                                <li>Tue</li>
                                                                <li>Wed</li>
                                                                <li>Thu</li>
                                                                <li>Fri</li>
                                                                <li>Sat</li>
                                                            </ul>
                                                            <ul class="days"></ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--/ Total Revenue -->
                            <div class="col-12 col-lg-8 order-2 order-md-3 order-lg-2 mb-4">
                                <div class="card">
                                    <div class="row row-bordered g-0">
                                        <div class="col-md-12">
                                            <div id="pendapatanGrafik" class="px-2 mt-3"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-8 col-lg-4 order-3 order-md-2">
                                <div class="row">
                                    <!-- </div>
                                <div class="row"> -->
                                    <div class="col-12 mb-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <div
                                                    class="d-flex justify-content-between flex-sm-row flex-column gap-3">
                                                    <div
                                                        class="d-flex flex-sm-column flex-row align-items-start justify-content-between">
                                                        <div class="card-title">
                                                            <h5 class="text-nowrap mb-2">Total Pendapatan Penjualan</h5>
                                                            <span class="badge bg-label-warning rounded-pill"><?php echo date("Y"); ?></span>
                                                        </div>
                                                        <div class="mt-sm-auto">
                                                            <h3 class="mb-0">Rp {{ number_format($nominal_pemasukkan[0], 0, ',', '.') }}</h3>
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <div
                                                    class="d-flex justify-content-between flex-sm-row flex-column gap-3">
                                                    <div
                                                        class="d-flex flex-sm-column flex-row align-items-start justify-content-between">
                                                        <div class="card-title">
                                                            <h5 class="text-nowrap mb-2">Total Pengeluaran</h5>
                                                            <span class="badge bg-label-warning rounded-pill"><?php echo date("Y"); ?></span>
                                                        </div>
                                                        <div class="mt-sm-auto">
                                                            <h3 class="mb-0">Rp {{ number_format($nominal_pengeluaran[0], 0, ',', '.') }}</h3>
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-8 order-2 order-md-3 order-lg-2 mb-4">
                                <div class="card">
                                    <div class="row row-bordered g-0">
                                        <div class="col-md-12">
                                            <div id="pengeluaranGrafik" class="px-2 mt-3"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- / Content -->

                    <!-- Footer -->
                    @include('partials.footer')
                    <!-- / Footer -->

                    <div class="content-backdrop fade"></div>
                </div>
                <!-- Content wrapper -->
            </div>
            <!-- / Layout page -->
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->

    <!--script-->
    @include('link-asset.script')
    <!--/ script-->
    @include('home.scriptjs')
</body>

</html>
