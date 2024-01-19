@extends('app')
@section('head')
    stok
@endsection
@section('title2')
    Stok
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
                        <th><strong>Stok</strong></th>
                        <th><strong>Update Terakhir</strong></th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @if (count($stok) < 1)
                        <tr>
                            <td colspan="8" style="padding: 20px; font-size: 20px;"><span>No data found</span> </td>
                        </tr>
                    @else
                        @foreach ($stok as $i)
                            <tr>
                                <td>{{ $i->product_code }}</td>
                                <td>{{ $i->product_name }}</td>
                                <td>{{ $i->total_stok }}</td>
                                <td>{{ $i->update_stok_date }}</td>
                            </tr> 
                        @endforeach
                    @endif
                    
                </tbody>
            </table>
        </div>
        <div class="mt-5">
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-end">
                    <li class="page-item {{ ($stok->currentPage() == 1) ? 'disabled' : '' }} prev">
                        <a class="page-link" href="{{ $stok->previousPageUrl() }}" aria-label="Previous">
                            <i class="tf-icon bx bx-chevrons-left"></i>
                        </a>
                    </li>
                    @for ($i = 1; $i <= $stok->lastPage(); $i++)
                        <li class="page-item {{ ($stok->currentPage() == $i) ? 'active' : '' }}">
                            <a class="page-link" href="{{ $stok->url($i) }}">{{ $i }}</a>
                        </li>
                    @endfor
                    <li class="page-item {{ ($stok->currentPage() == $stok->lastPage()) ? 'disabled' : '' }} next">
                        <a class="page-link" href="{{ $stok->nextPageUrl() }}" aria-label="Next">
                            <i class="tf-icon bx bx-chevrons-right"></i>
                        </a>
                    </li>
                </ul>
                <span>Total data {{ $total[0]->totalData }}, halaman {{ $stok->currentPage() }} dari {{ $stok->lastPage() }}</span>
            </nav>
        </div>
    </div>
@endsection
