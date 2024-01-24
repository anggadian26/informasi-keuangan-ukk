@extends('app')
@section('head')
    add produk
@endsection
@section('title1')
    Data Produk /
@endsection
@section('title2')
    Tambah Produk
@endsection

@section('content')
<div class="card p-3">
    <div class="container-view">
        
        <form action="{{ route('addAction.product') }}" method="post">
            @csrf
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
            <div class="row justify-content-start mb-3">
                <label class="col-sm-2 col-form-label text-start" for="basic-default-name">Nama Produk</label>
                <div class="col-sm-6">
                    <input type="text" name="product_name" class="form-control @error('product_name') is-invalid @enderror"
                        id="basic-default-name" value="{{ old('product_name') }}">
                    @error('product_name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div> 
            <div class="row justify-content-start mb-3">
                <label class="col-sm-2 col-form-label text-start" for="basic-default-name">Sub Kategori Produk</label>
                <div class="col-sm-6">
                    <select name="sub_ctgr_product_id" class="form-select @error('sub_ctgr_product_id') is-invalid @enderror"
                        id="exampleFormControlSelect1" aria-label="Default select example">
                        <option value=""></option>
                        @foreach ($subCtgr as $i)
                            <option value="{{ $i->sub_ctgr_product_id }}"
                                {{ old('sub_ctgr_product_id') == $i->sub_ctgr_product_id ? 'selected' : '' }}>{{ $i->sub_ctgr_product_name }}
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
                <label class="col-sm-2 col-form-label text-start" for="basic-default-name">Merek Produk</label>
                <div class="col-sm-6">
                    <input type="text" name="merek" class="form-control @error('merek') is-invalid @enderror"
                        id="basic-default-name" value="{{ old('merek') }}">
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
                    <input type="text" class="form-control @error('product_purcase') is-invalid @enderror" id="hargaBeliInput" aria-describedby="defaultFormControlHelp" oninput="formatHargaBeli(this)" name="hiden" />
                    @error('product_purcase')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <input type="hidden" id="hiddenHargaBeliInput" name="product_purcase" />
            </div>

            <div class="row justify-content-start mb-5">
                <label class="col-sm-2 col-form-label text-start" for="basic-default-name">Harga Jual</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control @error('product_purcase') is-invalid @enderror" id="nominalInput"
                        aria-describedby="defaultFormControlHelp" oninput="formatNominal(this)" name="hiden" />
                    @error('product_price')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                    </div>
                <input type="hidden" id="hiddenNominalInput" name="product_price" />
            </div>


            <div class="row justify-content-start mb-3">
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
    function formatNominal(input) {
        let value = input.value.replace(/[^\d]/g, ''); // Hapus semua karakter kecuali digit
        let numericValue = parseInt(value);

        if (!isNaN(numericValue)) {
            let formattedValue = numericValue.toLocaleString('id-ID'); // Menggunakan konfigurasi lokal Indonesia
            input.value = `Rp. ${formattedValue}`;
            input.setAttribute('data-value', numericValue);

            // Set nilai sebenarnya di input tersembunyi
            let hiddenInput = document.getElementById('hiddenNominalInput');
            hiddenInput.value = numericValue;
        } else {
            // Tangani jika input tidak berisi nilai numerik
            input.value = '';
            input.setAttribute('data-value', '');
            let hiddenInput = document.getElementById('hiddenNominalInput');
            hiddenInput.value = '';
        }
    }

    function formatHargaBeli(input) {
        let value = input.value.replace(/[^\d]/g, ''); // Hapus semua karakter kecuali digit
        let numericValue = parseInt(value);

        if (!isNaN(numericValue)) {
            let formattedValue = numericValue.toLocaleString('id-ID'); // Menggunakan konfigurasi lokal Indonesia
            input.value = `Rp. ${formattedValue}`;
            input.setAttribute('data-value', numericValue);

            // Set nilai sebenarnya di input tersembunyi
            let hiddenInput = document.getElementById('hiddenHargaBeliInput');
            hiddenInput.value = numericValue;
        } else {
            // Tangani jika input tidak berisi nilai numerik
            input.value = '';
            input.setAttribute('data-value', '');
            let hiddenInput = document.getElementById('hiddenHargaBeliInput');
            hiddenInput.value = '';
        }
    }
</script>
@endsection