@extends('app')
@section('head')
    add supplier
@endsection
@section('title1')
    Supplier /
@endsection
@section('title2')
    Tambah Supplier
@endsection

@section('content')
<div class="card p-3">
    <div class="container-view">
        <form action="" method="post">
            @csrf
            
            <div class="row justify-content-start mb-3">
                <label class="col-sm-2 col-form-label text-start" for="basic-default-name">Nama Supplier</label>
                <div class="col-sm-6">
                    <input type="text" name="supplier_name" class="form-control @error('supplier_name') is-invalid @enderror" style="text-transform: uppercase"
                        id="basic-default-name" value="{{ old('supplier_name') }}">
                    @error('supplier_name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="row justify-content-start mb-3">
                <label class="col-sm-2 col-form-label text-start" for="basic-default-name">No. Telepon</label>
                <div class="col-sm-6">
                    <input type="number" name="phone_number_person" class="form-control @error('phone_number_person') is-invalid @enderror" style="text-transform: uppercase"
                        id="basic-default-name" value="{{ old('phone_number_person') }}">
                    @error('phone_number_person')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="row justify-content-start mb-3">
                <label class="col-sm-2 col-form-label text-start" for="basic-default-name">Email</label>
                <div class="col-sm-6">
                    <input type="email" name="email_person" class="form-control @error('email_person') is-invalid @enderror" style="text-transform: uppercase"
                        id="basic-default-name" value="{{ old('email_person') }}">
                    @error('email_person')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="row justify-content-start mb-3">
                <label class="col-sm-2 col-form-label text-start" for="basic-default-name">Perusahaan</label>
                <div class="col-sm-6">
                    <input type="text" name="supplier_company" class="form-control @error('supplier_company') is-invalid @enderror"
                        id="basic-default-name" value="{{ old('supplier_company') }}">
                    @error('supplier_company')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>   
            <div class="row justify-content-start mb-3">
                <label class="col-sm-2 col-form-label text-start" for="basic-default-name">No. Tlpn Perusahaan</label>
                <div class="col-sm-6">
                    <input type="number" name="phone_number_person" class="form-control @error('phone_number_person') is-invalid @enderror" style="text-transform: uppercase"
                        id="basic-default-name" value="{{ old('phone_number_person') }}">
                    @error('phone_number_person')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="row justify-content-start mb-3">
                <label class="col-sm-2 col-form-label text-start" for="basic-default-name">Alamat Perusahhan</label>
                <div class="col-sm-6">
                    <input type="text" name="address_company" class="form-control @error('address_company') is-invalid @enderror" style="text-transform: uppercase"
                        id="basic-default-name" value="{{ old('address_company') }}">
                    @error('address_company')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="row justify-content-start mb-3">
                <div class="col-sm-6 offset-sm-6">
                    {{-- <button type="submit" class="btn btn-primary">Submit</button> --}}
                    <a href="{{ route('index.supplier') }}" class="btn btn-outline-secondary me-2">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection