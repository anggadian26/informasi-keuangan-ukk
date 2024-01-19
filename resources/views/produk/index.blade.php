@extends('app')
@section('head')
    data produk
@endsection
@section('title2')
    Data Produk
@endsection

@section('content')
    <div class="card p-3">
        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <a href="{{ route('addPage.product') }}" class="btn btn-primary">Tambah
                Data</a>
        </div>
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
                    <label for="" class="fw-bold">Kategori Produk</label>
                    <select name="ctgr_product_id" class="form-select">
                        <option value="">- Semua -</option>
                        @foreach ($ctgr_product as $i)
                            <option value="{{ $i->ctgr_product_id }}" {{ isset($_GET['ctgr_product_id']) && $_GET['ctgr_product_id'] == $i->ctgr_product_id ? 'selected' : '' }}>{{ $i->ctgr_product_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="" class="fw-bold">Sub Kategori Produk</label>
                    <select name="sub_ctgr_product_id" class="form-select">
                        <option value="">- Semua -</option>
                        @foreach ($sub_ctgr_product as $i)
                            <option value="{{ $i->sub_ctgr_product_id }}" {{ isset($_GET['sub_ctgr_product_id']) && $_GET['sub_ctgr_product_id'] == $i->sub_ctgr_product_id ? 'selected' : '' }}>{{ $i->sub_ctgr_product_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="" class="fw-bold">Status</label>
                    <select name="status" class="form-select">
                        <option value="">- Semua -</option>
                        <option value="Y" {{ isset($_GET['status']) && $_GET['status'] == 'Y' ? 'selected' : '' }}>Aktif</option>
                        <option value="N" {{ isset($_GET['status']) && $_GET['status'] == 'N' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
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
                        <th><strong>Aksi</strong></th>
                        <th><strong>Kode</strong></th>
                        <th><strong>Nama</strong></th>
                        <th><strong>Kategori</strong></th>
                        <th><strong>Sub Kategori</strong></th>
                        <th><strong>Harga Produk</strong></th>
                        <th><strong>Status</strong></th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @if (count($product) < 1)
                        <tr>
                            <td colspan="8" style="padding: 20px; font-size: 20px;"><span>No data found</span> </td>
                        </tr>
                    @else
                        @foreach ($product as $i)
                            @include('produk.modal.modalDetailProduct')
                            @include('produk.modal.modalDelProduct')
                            <tr>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                            data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal"
                                                data-bs-target="#detailProduct{{ $i->product_id }}"><i class="bx bx-detail me-1"></i>
                                                Detail</a>
                                            <a class="dropdown-item" href="{{ route('editPage.product', ['id' => $i->product_id]) }}"><i
                                                    class="bx bx-edit-alt me-1"></i>
                                                Edit</a>
                                            <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal"
                                            data-bs-target="#delProduct{{ $i->product_id }}" ><i
                                                    class="bx bx-trash me-1"></i>
                                                Delete</a>
                                        </div>
                                </td>
                                <td>{{ $i->product_code }}</td>
                                <td>{{ $i->product_name }}</td>
                                <td>{{ $i->ctgr_product_name }}</td>
                                <td>{{ $i->sub_ctgr_product_name }}</td>
                                <td>Rp. {{ number_format($i->product_price, 0, ',', '.') }}</td>
                                <td>
                                    @if ($i->status == 'Y')
                                        <span class="badge rounded-pill bg-success">Aktif</span>
                                    @else
                                        <span class="badge rounded-pill bg-danger">Tidak Aktif</span>
                                    @endif
                                </td>
                            </tr> 
                        @endforeach
                    @endif
                    
                </tbody>
            </table>
        </div>
        <div class="mt-5">
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-end">
                    <li class="page-item {{ ($product->currentPage() == 1) ? 'disabled' : '' }} prev">
                        <a class="page-link" href="{{ $product->previousPageUrl() }}" aria-label="Previous">
                            <i class="tf-icon bx bx-chevrons-left"></i>
                        </a>
                    </li>
                    @for ($i = 1; $i <= $product->lastPage(); $i++)
                        <li class="page-item {{ ($product->currentPage() == $i) ? 'active' : '' }}">
                            <a class="page-link" href="{{ $product->url($i) }}">{{ $i }}</a>
                        </li>
                    @endfor
                    <li class="page-item {{ ($product->currentPage() == $product->lastPage()) ? 'disabled' : '' }} next">
                        <a class="page-link" href="{{ $product->nextPageUrl() }}" aria-label="Next">
                            <i class="tf-icon bx bx-chevrons-right"></i>
                        </a>
                    </li>
                </ul>
                <span>Total data {{ $total[0]->totalData }}, halaman {{ $product->currentPage() }} dari {{ $product->lastPage() }}</span>
            </nav>
        </div>
    </div>
@endsection
