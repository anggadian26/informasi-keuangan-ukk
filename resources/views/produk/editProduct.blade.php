@extends('app')
@section('head')
    edit product
@endsection
@section('title1')
    Data Produk /
@endsection
@section('title2')
    Ubah Produk
@endsection

@section('content')
    <div class="card p-3">
        <div class="container-view">
            <form action="{{ route('editAction.product', ['id' => $product->product_id]) }}" method="post">
                @csrf
                <div class="row justify-content-start mb-3">
                    <label class="col-sm-2 col-form-label text-start" for="basic-default-name">Sub Kategori Produk</label>
                    <div class="col-sm-6">
                        <select name="sub_ctgr_product_id"
                            class="form-select @error('sub_ctgr_product_id') is-invalid @enderror"
                            id="exampleFormControlSelect1" aria-label="Default select example">
                            @foreach ($subCtgr as $i)
                                <option value="{{ $i->sub_ctgr_product_id }}"
                                    {{ (old('sub_ctgr_product_id') ?? $product->sub_ctgr_product_id) == $i->sub_ctgr_product_id ? 'selected' : '' }}>
                                    {{ $i->sub_ctgr_product_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('sub_ctgr_product_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="row justify-content-start mb-3">
                    <label class="col-sm-2 col-form-label text-start" for="basic-default-name">Kode Produk</label>
                    <div class="col-sm-6">
                        <input type="text" name="product_code"
                            class="form-control @error('product_code') is-invalid @enderror"
                            style="text-transform: uppercase" id="basic-default-name"
                            value="{{ old('product_code', $product->product_code) }}" readonly>
                        @error('product_code')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="row justify-content-start mb-3">
                    <label class="col-sm-2 col-form-label text-start" for="basic-default-name">Nama Produk</label>
                    <div class="col-sm-6">
                        <input type="text" name="product_name"
                            class="form-control @error('product_name') is-invalid @enderror" id="basic-default-name"
                            value="{{ old('product_name', $product->product_name) }}">
                        @error('product_name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="row justify-content-start mb-3">
                    <label class="col-sm-2 col-form-label text-start" for="basic-default-name">Merek</label>
                    <div class="col-sm-6">
                        <input type="text" name="merek" class="form-control @error('merek') is-invalid @enderror"
                            id="basic-default-name" value="{{ old('merek', $product->merek) }}">
                        @error('merek')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="row justify-content-start mb-3">
                    <label class="col-sm-2 col-form-label text-start" for="basic-default-name">Harga Beli</label>
                    <div class="col-sm-6">
                        <input type="number" name="product_purcase" class="form-control @error('product_purcase') is-invalid @enderror"
                            id="basic-default-name" value="{{ old('product_purcase', $product->product_purcase) }}">
                        @error('product_purcase')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="row justify-content-start mb-3">
                    <label class="col-sm-2 col-form-label text-start" for="basic-default-name">Harga Jual</label>
                    <div class="col-sm-6">
                        <input type="number" name="product_price" class="form-control @error('product_price') is-invalid @enderror"
                            id="basic-default-name" value="{{ old('product_price', $product->product_price) }}">
                        @error('product_price')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="row justify-content-start mb-3">
                    <label class="col-sm-2 col-form-label text-start" for="basic-default-name">Status</label>
                    <div class="col-sm-6">
                        <select name="status" class="form-select @error('status') is-invalid @enderror"
                            id="basic-default-name">
                            <option value="Y" {{ $product->status == 'Y' ? 'selected' : '' }}>Aktif</option>
                            <option value="N" {{ $product->status == 'N' ? 'selected' : '' }}>Tidak Aktif</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="row justify-content-start mb-3 mt-5">
                    <div class="col-sm-6 offset-sm-6">
                        {{-- <button type="submit" class="btn btn-primary">Submit</button> --}}
                        <a href="{{ route('index.produk') }}" class="btn btn-outline-secondary me-2">Batal</a>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        unction formatNominal(input) {
            let value = input.value.replace(/[^\d]/g, ''); // Hapus semua karakter kecuali digit
            let numericValue = parseInt(value);

            if (!isNaN(numericValue)) {
                let formattedValue = numericValue.toLocaleString('id-ID'); // Menggunakan konfigurasi lokal Indonesia
                input.value = `Rp. ${formattedValue}`;
                input.setAttribute('data-value', numericValue);
            } else {
                input.value = '';
                input.setAttribute('data-value', '');
            }

            // Set nilai sebenarnya di input tersembunyi
            let hiddenInput = document.getElementById('hiddenNominalInput');
            hiddenInput.value = numericValue !== undefined ? numericValue : '';
        }

        function formatHargaBeli(input) {
            let value = input.value.replace(/[^\d]/g, ''); // Hapus semua karakter kecuali digit
            let numericValue = parseInt(value);

            if (!isNaN(numericValue)) {
                let formattedValue = numericValue.toLocaleString('id-ID'); // Menggunakan konfigurasi lokal Indonesia
                input.value = `Rp. ${formattedValue}`;
                input.setAttribute('data-value', numericValue);
            } else {
                input.value = '';
                input.setAttribute('data-value', '');
            }

            // Set nilai sebenarnya di input tersembunyi
            let hiddenInput = document.getElementById('hiddenHargaBeliInput');
            hiddenInput.value = numericValue !== undefined ? numericValue : '';
        }
    </script>
@endsection
