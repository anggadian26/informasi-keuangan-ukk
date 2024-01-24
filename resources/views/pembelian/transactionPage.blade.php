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

        <div class="row justify-content-start mb-3">
            <label class="col-sm-2 col-form-label text-start" for="basic-default-name">Kode Produk</label>
            <div class="col-sm-6">
                <input type="text" name="product_code" class="form-control @error('product_code') is-invalid @enderror" style="text-transform: uppercase"
                    id="basic-default-name" value="{{ old('product_code') }}">
                @error('product_code')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
    </div>
@endsection