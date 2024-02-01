<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default"
    data-assets-path="../assets/" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>komobox | transaksi-penjualan</title>

    <meta name="description" content="" />

    @include('link-asset.head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .tampil-bayar {
            font-size: 5em;
            text-align: center;
            height: 100px;
        }

        .tampil-terbilang {
            padding: 10px;
            background: #f0f0f0;
        }

        .table-penjualan tbody tr:last-child {
            display: none;
        }

        @media(max-width: 768px) {
            .tampil-bayar {
                font-size: 3em;
                height: 70px;
                padding-top: 5px;
            }
        }
    </style>
</head>

<body>
    @include('sweetalert::alert')

    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar layout-without-menu">
        <div class="layout-container">


            {{-- contentdisini --}}
            <div class="layout-page">
                <!-- Navbar -->
                @include('partials.navbar')
                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->
                    <div class="container-xxl flex-grow-1 container-p-y">
                        <div class="card p-3">
                            <div class="">
                                <a href="#"
                                    class="btn btn-primary pt-1 pb-1 mb-3"
                                    onclick="return confirm('Apakah Anda yakin ingin keluar dari transaksi?')">
                                    <span class="tf-icons bx bx-left-arrow-alt fw-bold"></span> Kembali
                                </a>
                            </div>

                            <div class="row">
                                <div class="col-md-5">
                                    
                                </div>
                            </div>

                            <div class="row justify-content-end mb-5">
                                <div class="col-sm-3 text-end">
                                    <form class="form-produk">
                                        @csrf
                                        {{-- <input type="hidden" name="product_id" id="product_id">
                                        <input type="hidden" name="product_code" id="product_code">
                                        <input type="hidden" name="pembelian_id" id="pembelian_id"
                                            value="{{ $pembelian_id }}"> --}}
                                        <button class="btn-lg btn-success ps-5 pe-5 fw-bold" data-bs-toggle="modal"
                                            data-bs-target="#pilihProduk">Pilih Produk</button>
                                    </form>
                                </div>
                            </div>
                            @include('pembelian.modal.modalPilihProduk')
                            @include('pembelian.modal.modalInfo')
                            <div class="table-responsive text-nowrap">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th width="3%"><strong>No</strong></th>
                                            <th><strong>Kode Produk</strong></th>
                                            <th><strong>Nama Produk</strong></th>
                                            <th width=15%>
                                                <strong>Harga Jual</strong>
                                                <button type="button" data-bs-toggle="modal"
                                                    data-bs-target="#infoHargaJual"
                                                    class="btn-xs rounded-pill btn-icon btn-primary">
                                                    <span class="tf-icons bx bx-info-circle"></span>
                                                </button>
                                            </th>
                                            <th width=15%>
                                                <strong>Harga Beli</strong>
                                                <button type="button" data-bs-toggle="modal"
                                                    data-bs-target="#infoHargaBeli"
                                                    class="btn-xs rounded-pill btn-icon btn-primary">
                                                    <span class="tf-icons bx bx-info-circle"></span>
                                                </button>
                                            </th>
                                            <th width="12%"><strong>Jumlah</strong></th>
                                            <th width="17%"><strong>Sub Total</strong></th>
                                            <th><strong>Aksi</strong></th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-border-bottom-0" id="detailTableBody">

                                    </tbody>
                                </table>

                            </div>
                            <div class="row mt-5">
                                <div class="col-lg-8">
                                    <div class="tampil-bayar bg-primary text-white"></div>
                                    <div class="tampil-terbilang"></div>
                                </div>
                                <div class="col-lg-4">
                                    <form action="#" class="form-pembelian" method="post">
                                        @csrf
                                        <input type="hidden" name="pembelian_id" value="">
                                        <input type="hidden" name="total_harga" id="totalInputan">
                                        <input type="hidden" name="total_item" id="total_item">
                                        <input type="hidden" name="diskon" id="diskonInputan">
                                        <input type="hidden" name="total_bayar" id="bayar">

                                        <div class="form-group row mb-2">
                                            <label for="totalrp" class="col-lg-4 control-label">Total</label>
                                            <div class="col-lg-8">
                                                <input type="text" id="totalrp" class="form-control" readonly>
                                            </div>
                                        </div>

                                        <div class="form-group row mb-2">
                                            <label for="diskon" class="col-lg-4 control-label">Diskon (%)</label>
                                            <div class="col-lg-8">
                                                <input type="number" name="diskon" id="diskon" value="0"
                                                    class="form-control" onchange="updateBayar()">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-2">
                                            <label for="ppn" class="col-lg-4 control-label">PPN 11%</label>
                                            <div class="col-lg-8">
                                                <input type="text" id="ppn" class="form-control" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row mb-2">
                                            <label for="bayar" class="col-lg-4 control-label">Bayar + PPN</label>
                                            <div class="col-lg-8">
                                                <input type="text" id="bayarrp" class="form-control" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row mb-2">
                                            <label for="" class="col-lg-4 control-label">Jenis Pembelian</label>
                                            <div class="col-lg-8">
                                                <select name="jenis_pembelian" class="form-select" id="jenis_pembelian" aria-label="Default select example">
                                                    <option value="cash">Cash</option>
                                                    <option value="credit">Credit</option>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group row mb-2" id="uang_muka_input" style="display: none;">
                                            <label for="uang_muka" class="col-lg-4 control-label">Uang Muka</label>
                                            <div class="col-lg-8">
                                                <input type="number" name="uang_muka" id="uang_muka" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-2" id="tanggal_jatuh_tempo_input" style="display: none;">
                                            <label for="tanggal_jatuh_tempo" class="col-lg-4 control-label">Tanggal Jatuh Tempo</label>
                                            <div class="col-lg-8">
                                                <input type="date" name="tanggal_jatuh_tempo" id="tanggal_jatuh_tempo" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-2">
                                            <label for="" class="col-lg-4 control-label">Catatan</label>
                                            <div class="col-lg-8">
                                                <textarea class="form-control" name="catatan" rows="3"></textarea>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <hr>
                            <div class="text-end">
                                <button class="btn-lg btn-primary" onclick="saveTransaksi()" type="submit"><span class="tf-icons bx bxs-save"></span> Simpan
                                    Transaksi</button>
                            </div>
                        </div>
                    </div>
                    <!-- / Content -->

                    <!-- Footer -->
                    @include('partials.footer')
                    <!-- / Footer -->

                    <div class="content-backdrop fade"></div>
                </div>
            </div>

        </div>
    </div>

    @include('link-asset.script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        
    </script>
    
</body>

</html>
