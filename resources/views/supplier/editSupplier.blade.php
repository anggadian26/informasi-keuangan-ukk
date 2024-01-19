@extends('app')
@section('head')
    edit supplier
@endsection
@section('title1')
    Supplier /
@endsection
@section('title2')
    Ubah Supplier
@endsection

@section('content')
<div class="card p-3">
    <div class="container-view">
        <form action="{{ route('editAction.supplier', ['id' => $supplier->supplier_id]) }}" method="post">
            @csrf
            <div class="row justify-content-start mb-3">
                <label class="col-sm-2 col-form-label text-start" for="basic-default-name">Nama Supplier</label>
                <div class="col-sm-6">
                    <input type="text" name="supplier_name" class="form-control @error('supplier_name') is-invalid @enderror"
                        id="basic-default-name" value="{{ old('supplier_name', $supplier->supplier_name) }}">
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
                    <input type="text" name="phone_number_person" class="form-control @error('phone_number_person') is-invalid @enderror"
                        id="basic-default-name" value="{{ old('phone_number_person', $supplier->phone_number_person) }}">
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
                    <input type="email" name="email_person" class="form-control @error('email_person') is-invalid @enderror"
                        id="basic-default-name" value="{{ old('email_person', $supplier->email_person) }}">
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
                        id="basic-default-name" value="{{ old('supplier_company', $supplier->supplier_company) }}">
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
                    <input type="text" name="phone_number_company" class="form-control @error('phone_number_company') is-invalid @enderror"
                        id="basic-default-name" value="{{ old('phone_number_company', $supplier->phone_number_company) }}">
                    @error('phone_number_company')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="row justify-content-start mb-3">
                <label class="col-sm-2 col-form-label text-start" for="basic-default-name">Alamat Perusahhan</label>
                <div class="col-sm-6">
                    <input type="text" name="address_company" class="form-control @error('address_company') is-invalid @enderror"
                        id="basic-default-name" value="{{ old('address_company', $supplier->address_company) }}">
                    @error('address_company')
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
                                <option value="Y" {{ $supplier->status == 'Y' ? 'selected' : '' }}>Aktif</option>
                                <option value="N" {{ $supplier->status == 'N' ? 'selected' : '' }}>Tidak Aktif</option>
                            </select>
                    @error('status')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>  
            <div class="row justify-content-start mb-3">
                <div class="col-sm-6 offset-sm-6">
                    <a href="{{ route('index.supplier') }}" class="btn btn-outline-secondary me-2">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection