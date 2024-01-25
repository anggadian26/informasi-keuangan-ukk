@extends('app')
@section('head')
    TransaksiPembelianAction
@endsection
@section('title1')
    Transaksi Pembelian /
@endsection
@section('title2')
    Aksi Transaksi
@endsection
@section('style')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
    <div class="card p-3">
        <div class="">
            <a href="{{ route('backTransaction.pembelian', ['id' => $pembelian_id]) }}"
                class="btn btn-primary pt-1 pb-1 mb-3"><span class="tf-icons bx bx-left-arrow-alt fw-bold"></span> Kembali</a>
        </div>
        <div class="row">
            <div class="col-md-5">
                <table>
                    <tr>
                        <td>Nama Supplier</td>
                        <td class="fw-bold">: {{ $supplier->supplier_name }}</td>
                    </tr>
                    <tr>
                        <td>Telepon Supplier</td>
                        <td class="fw-bold">: {{ $supplier->phone_number_person }}</td>
                    </tr>
                    <tr>
                        <td>Perusahaan Supplier</td>
                        <td class="fw-bold">: {{ $supplier->supplier_company }}</td>
                    </tr>
                    <tr>
                        <td>Alamat Perusahaan</td>
                        <td class="fw-bold">: {{ $supplier->address_company }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="row justify-content-end mb-5">
            <div class="col-sm-3 text-end">
                <form class="form-produk">
                    @csrf
                    <input type="hidden" name="product_id" id="product_id">
                    <input type="hidden" name="product_code" id="product_code">
                    <input type="hidden" name="pembelian_id" id="pembelian_id" value="{{ $pembelian_id }}">
                    <button class="btn-lg btn-success ps-5 pe-5 fw-bold" data-bs-toggle="modal"
                        data-bs-target="#pilihProduk">Pilih Produk</button>
                </form>
            </div>
        </div>
        @include('pembelian.modal.modalPilihProduk')
        <div class="table-responsive text-nowrap">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th><strong>No</strong></th>
                        <th><strong>Kode Produk</strong></th>
                        <th><strong>Nama Produk</strong></th>
                        <th><strong>Harga Beli</strong></th>
                        <th><strong>Harga Jual</strong></th>
                        <th><strong>Jumlah</strong></th>
                        <th><strong>Sub Total</strong></th>
                        <th><strong>Aksi</strong></th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0" id="detailTableBody">
                    {{-- <tr>
                        <td>1</td>
                        <td>PRO3049</td>
                        <td>Iphone</td>
                        <td><input type="text" class="form-control form-control-sm" value="Rp. 20.000.0000"></td>
                        <td><input type="text" class="form-control form-control-sm" value="Rp. 20.000.0000"></td>
                        <td>203</td>
                        <td>Rp. 230.000.000</td>
                        <td><button class="btn btn-danger"><i class="bx bx-trash me-1"></button></td>

                    </tr> --}}

                </tbody>
            </table>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        let table;

        function fetchDataAndUpdateTable() {
            let pembelianId = $('#pembelian_id').val();

            // Fetch data from the server
            $.get('{{ route('detailProduct.pembelian', ['id' => '$pembelian_id']) }}/' + pembelianId + '/data')
                .done(response => {
                    updateTable(response.detail);
                })
                .fail(errors => {
                    alert('Tidak Dapat Mengambil Data');
                });
        }

        function updateTable(detailData) {
            let tableBody = $('#detailTableBody');
            tableBody.empty(); // Clear existing table rows

            // Loop through the data and append rows to the table
            $.each(detailData, function(index, detail) {
                let rowHtml = `<tr>
                    <td>${index + 1}</td>
                    <td>${detail.produk.product_code}</td>
                    <td>${detail.produk.product_name}</td>
                    <td><input type="text" class="form-control form-control-sm" value="Rp. ${detail.harga_beli}"></td>
                    <td><input type="text" class="form-control form-control-sm" value="Rp. ${detail.harga_jual}"></td>
                    <td>${detail.jumlah}</td>
                    <td>Rp. ${detail.sub_total}</td>
                    <td><button class="btn btn-danger"><i class="bx bx-trash me-1"></button></td>
                </tr>`;

                tableBody.append(rowHtml);
            });
        }
        
        function hideModalProduct() {
            $('#pilihProduk').modal('hide');
        }


        function pilihProduct(id, code, pembelian_id) {
            $('#product_id').val(id);
            $('#product_code').val(code);
            $('#pembelian_id').val(pembelian_id);
            console.log($('.form-produk'));
            hideModalProduct();
            addProduct();
        }

        function addProduct() {
            $.post('{{ route('storePembelianProduct.pembelian') }}', $('.form-produk').serialize())
                .done(response => {

                })
                .fail(errors => {
                    alert('Tidak Dapat Menyimpan Data');
                })
        }
        $(document).ready(function() {
            $('.form-produk').on('submit', function(event) {
                event.preventDefault();
            });
        });
    </script>
@endsection
