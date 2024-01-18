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
        
        <form action="#" method="post">
            @csrf
            <div class="row mb-3 justify-content-start mt-4">
                <label class="col-sm-2 col-form-label text-start" for="basic-default-name">Nama</label>
                <div class="col-sm-6">
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                        id="basic-default-name" value="{{ old('name') }}">
                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="row justify-content-start mb-3">
                <label class="col-sm-2 col-form-label text-start" for="basic-default-name">Jurusan</label>
                <div class="col-sm-6">
                    <select name="jurusan_id" class="form-select @error('jurusan_id') is-invalid @enderror"
                        id="exampleFormControlSelect1" aria-label="Default select example">
                        <option value=""></option>
                        {{-- @foreach ($jurusan as $i)
                            <option value="{{ $i->jurusan_id }}"
                                {{ old('jurusan_id') == $i->jurusan_id ? 'selected' : '' }}>{{ $i->jurusan_name }}
                            </option>
                        @endforeach --}}
                    </select>
                    @error('jurusan_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="row justify-content-start mb-3">
                <label class="col-sm-2 col-form-label text-start" for="basic-default-name">Angkatan</label>
                <div class="col-sm-6">
                    <input type="number" name="angkatan" class="form-control @error('angkatan') is-invalid @enderror"
                        id="basic-default-name" value="{{ old('angkatan') }}">
                    @error('angkatan')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="row mb-3 justify-content-start">
                <label class="col-sm-2 col-form-label text-start" for="basic-default-name">Username</label>
                <div class="col-sm-6">
                    <input type="text" name="username" class="form-control @error('username') is-invalid @enderror"
                        id="basic-default-name" value="{{ old('username') }}">
                    @error('username')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="row mb-3 justify-content-start">
                <label class="col-sm-2 col-form-label text-start" for="basic-default-name">Email</label>
                <div class="col-sm-6">
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                        id="basic-default-name" value="{{ old('email') }}">
                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="row mb-4 justify-content-start">
                <label class="col-sm-2 col-form-label text-start" for="basic-default-name">Password</label>
                <div class="col-sm-6">
                    <input type="text" name="password" class="form-control @error('password') is-invalid @enderror"
                        id="basic-default-name" value="{{ old('password') }}">
                    @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            
                <input type="hidden" id="hiddenNominalInput" name="saldo" />
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
</script>
@endsection