@extends('app')
@section('head')
    dataDiskon
@endsection
@section('title2')
    Data Diskon
@endsection
@section('content')
    <div class="card p-3">
        <form action="#" method="get" class="mb-3 mt-3">
            @csrf
            <div class="row mb-3">
                <div class="col-md-2">
                    <label for="" class="fw-bold">Kode Produk</label>
                    <input name="product_code" type="text" class="form-control" placeholder="Kode Produk"
                        value="{{ isset($_GET['product_code']) ? $_GET['product_code'] : '' }}">
                </div>
                <div class="col-md-2">
                    <label for="" class="fw-bold">Nama Produk</label>
                    <input name="product_name" type="text" class="form-control" placeholder="Nama Produk"
                        value="{{ isset($_GET['product_name']) ? $_GET['product_name'] : '' }}">
                </div>
                
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary mt-4 btn-cari">Cari</button>
                </div>
            </div>
        </form>
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                    <tr>
                        <th><strong>Kode Produk</strong></th>
                        <th><strong>Nama Produk</strong></th>
                        <th><strong>Harga Jual</strong></th>
                        <th><strong>Diskon</strong></th>
                        @if ($loggedInUser->role->role == 'manager')
                        <th><strong>Aksi</strong></th>
                        @endif
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @if (count($data) < 1)
                        <tr>
                            <td colspan="8" style="padding: 20px; font-size: 20px;"><span>No data found</span> </td>
                        </tr>
                    @else
                        @foreach ($data as $i)
                            @include('diskon.modal.modalUbahDiskon')
                            <tr>
                                <td>{{ $i->product_code }}</td>
                                <td>{{ $i->product_name }}</td>
                                <td>Rp {{ number_format($i->product_price, 0, ',', '.') }}</td>
                                <td class="fw-bold">{{ $i->diskon }}%</td>
                                @if ($loggedInUser->role->role == 'manager')
                                <td><button class="btn-sm btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#modalUbahDiskon{{ $i->product_id }}">Ubah Diskon</button></td>
                                @endif
                            </tr> 
                        @endforeach
                    @endif
                    
                </tbody>
            </table>
        </div>
        <div class="mt-5">
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-end">
                    <li class="page-item {{ ($data->currentPage() == 1) ? 'disabled' : '' }} prev">
                        <a class="page-link" href="{{ $data->previousPageUrl() }}" aria-label="Previous">
                            <i class="tf-icon bx bx-chevrons-left"></i>
                        </a>
                    </li>
                    @for ($i = 1; $i <= $data->lastPage(); $i++)
                        <li class="page-item {{ ($data->currentPage() == $i) ? 'active' : '' }}">
                            <a class="page-link" href="{{ $data->url($i) }}">{{ $i }}</a>
                        </li>
                    @endfor
                    <li class="page-item {{ ($data->currentPage() == $data->lastPage()) ? 'disabled' : '' }} next">
                        <a class="page-link" href="{{ $data->nextPageUrl() }}" aria-label="Next">
                            <i class="tf-icon bx bx-chevrons-right"></i>
                        </a>
                    </li>
                </ul>
                <span>Total data {{ $total[0]->totalData }}, halaman {{ $data->currentPage() }} dari {{ $data->lastPage() }}</span>
            </nav>
        </div>
    </div>
@endsection
