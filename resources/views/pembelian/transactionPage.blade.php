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

@section('content')
    <div class="card p-3">
        <div class="row">
            <div class="col-md-5">
                <p class="mb-1"><span class="fw-bold">Nama Supplier :</span> {{ $supplier->supplier_name }}</p>
                <p class="mb-1"><span class="fw-bold">Telepon Supplier :</span> {{ $supplier->phone_number_person }}</p>
                <p class="mb-1"><span class="fw-bold">Perusahaan Supplier :</span> {{ $supplier->supplier_company }}</p>
                <p class="mb-0"><span class="fw-bold">Alamat Perusahaan :</span> {{ $supplier->address_company }}</p>
            </div>
        </div>

        <div class="row justify-content-end mb-5">
            <div class="col-sm-2">
                <button class="btn-lg btn-success" data-bs-toggle="modal"
                data-bs-target="#pilihProduk">Pilih Produk</button>
              
            </div>
        </div>

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
                <tbody class="table-border-bottom-0">
                    <tr>
                        <td>1</td>
                        <td>PRO3049</td>
                        <td>Iphone</td>
                        <td><input type="text" class="form-control form-control-sm" value="Rp. 20.000.0000"></td>
                        <td><input type="text" class="form-control form-control-sm" value="Rp. 20.000.0000"></td>
                        <td>203</td>
                        <td>Rp. 230.000.000</td>
                        <td><button class="btn btn-danger"><i
                            class="bx bx-trash me-1"></button></td>
                        
                    </tr>
                    
                </tbody>
            </table>
        </div>
    </div>
@endsection