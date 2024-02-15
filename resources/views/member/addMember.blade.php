@extends('app')
@section('head')
    addMember
@endsection
@section('title1')
    Member /
@endsection
@section('title2')
    Tambah Member
@endsection

@section('content')
<div class="card p-3">
    <div class="container-view">
        
        <form action="#" method="post">
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
                <div class="col-sm-6 offset-sm-6">
                    {{-- <button type="submit" class="btn btn-primary">Submit</button> --}}
                    <a href="{{ route('index.member') }}" class="btn btn-outline-secondary me-2">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection