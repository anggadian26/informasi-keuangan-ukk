@extends('app')
@section('head')
    sub kategori produk
@endsection
@section('title2')
    Sub Kategori Produk
@endsection

@section('content')
    <div class="card p-3">
        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSubCtgrProduct">
                Tambah Data
            </button>
            @include('sub-ctgr-product.modal.modalAddSubCtgr')
        </div>
        <form action="#" method="get" class="mb-3">
            @csrf
            <div class="row mb-3">
                <div class="col-md-2">
                    <label for="" class="fw-bold">Kode Sub Kategori</label>
                    <input name="sub_ctgr_product_code" type="text" class="form-control" placeholder="Kode Kategori"
                        value="{{ isset($_GET['sub_ctgr_product_code']) ? $_GET['sub_ctgr_product_code'] : '' }}">
                </div>
                <div class="col-md-2">
                    <label for="" class="fw-bold">Nama Sub Kategori</label>
                    <input name="sub_ctgr_product_name" type="text" class="form-control" placeholder="Nama Kategori"
                        value="{{ isset($_GET['sub_ctgr_product_name']) ? $_GET['sub_ctgr_product_name'] : '' }}">
                </div>
                <div class="col-md-2">
                    <label for="" class="fw-bold">Kategori</label>
                    <select name="ctgr_product_id" class="form-select" id="exampleFormControlSelect1"
                        aria-label="Default select example">
                        <option value="">- Semua -</option>
                        @foreach ($category as $i)
                            <option value="{{ $i->ctgr_product_id }}"
                                {{ isset($_GET['ctgr_product_id']) && $_GET['ctgr_product_id'] == $i->ctgr_product_id ? 'selected' : '' }}>
                                {{ $i->ctgr_product_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="" class="fw-bold">Status</label>
                    <select name="status" class="form-select">
                        <option value="">- Semua -</option>
                        <option value="Y" {{ isset($_GET['status']) && $_GET['status'] == 'Y' ? 'selected' : '' }}>
                            Aktif</option>
                        <option value="N" {{ isset($_GET['status']) && $_GET['status'] == 'N' ? 'selected' : '' }}>
                            Tidak Aktif</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary mt-4 btn-cari">Cari</button>
                </div>
            </div>
        </form>
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                    <tr>
                        <th><strong>Aksi</strong></th>
                        <th><strong>Kode Sub Kategori</strong></th>
                        <th><strong>Nama Sub Kategori</strong></th>
                        <th><strong>Kategori Produk</strong></th>
                        <th><strong>Status</strong></th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @if (count($subCtgr) < 1)
                        <tr>
                            <td colspan="8" style="padding: 20px; font-size: 20px;"><span>No data found</span> </td>
                        </tr>
                    @else
                        @foreach ($subCtgr as $i)
                            @include('sub-ctgr-product.modal.modalDetailSubCtgr')
                            @include('sub-ctgr-product.modal.modalEditSubCtgr')
                            @include('sub-ctgr-product.modal.modalDelSubCtgr')
                            <tr>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                            data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal"
                                                data-bs-target="#detailSubCtgrProduct{{ $i->sub_ctgr_product_id }}"><i
                                                    class="bx bx-detail me-1 text-primary"></i>
                                                Detail</a>
                                            <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal"
                                                data-bs-target="#editSubCtgrProduct{{ $i->sub_ctgr_product_id }}"><i
                                                    class="bx bx-edit-alt me-1 text-warning"></i>
                                                Ubah</a>
                                            <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal"
                                                data-bs-target="#delSubCtgrProduct{{ $i->sub_ctgr_product_id }}"><i
                                                    class="bx bx-trash-alt me-1 text-danger"></i>
                                                Hapus</a>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $i->sub_ctgr_product_code }}</td>
                                <td>{{ $i->sub_ctgr_product_name }}</td>
                                <td>{{ $i->ctgr_product_name }}</td>
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
                    <li class="page-item {{ $subCtgr->currentPage() == 1 ? 'disabled' : '' }} prev">
                        <a class="page-link" href="{{ $subCtgr->previousPageUrl() }}" aria-label="Previous">
                            <i class="tf-icon bx bx-chevrons-left"></i>
                        </a>
                    </li>
                    @for ($i = 1; $i <= $subCtgr->lastPage(); $i++)
                        <li class="page-item {{ $subCtgr->currentPage() == $i ? 'active' : '' }}">
                            <a class="page-link" href="{{ $subCtgr->url($i) }}">{{ $i }}</a>
                        </li>
                    @endfor
                    <li class="page-item {{ $subCtgr->currentPage() == $subCtgr->lastPage() ? 'disabled' : '' }} next">
                        <a class="page-link" href="{{ $subCtgr->nextPageUrl() }}" aria-label="Next">
                            <i class="tf-icon bx bx-chevrons-right"></i>
                        </a>
                    </li>
                </ul>
                <span>Total data {{ $total[0]->totalData }}, halaman {{ $subCtgr->currentPage() }} dari
                    {{ $subCtgr->lastPage() }}</span>
            </nav>
        </div>
    </div>
@endsection
