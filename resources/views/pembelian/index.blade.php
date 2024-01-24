@extends('app')
@section('head')
    TransaksiPembelian
@endsection
@section('title2')
    Transaksi Pembelian
@endsection

@section('content')
    <div class="card p-3">
        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalSupplier">
                Transaksi Baru
            </button>
            @include('pembelian.modal.modalSupplier')
        </div>

        <form action="#" method="get" class="mb-3">
            @csrf
            <div class="row mb-3">
                <div class="col-md-2">
                    <label for="" class="fw-bold">Kode Kategori</label>
                    <input name="ctgr_product_code" type="text" class="form-control" placeholder="Kode Kategori"
                        value="{{ isset($_GET['ctgr_product_code']) ? $_GET['ctgr_product_code'] : '' }}">
                </div>
                <div class="col-md-2">
                    <label for="" class="fw-bold">Nama Kategori</label>
                    <input name="ctgr_product_name" type="text" class="form-control" placeholder="Nama Kategori"
                        value="{{ isset($_GET['ctgr_product_name']) ? $_GET['ctgr_product_name'] : '' }}">
                </div>
                <div class="col-md-2">
                    <label for="" class="fw-bold">Status</label>
                    <select name="status" class="form-select">
                        <option value="">- Semua -</option>
                        <option value="Y" {{ isset($_GET['status']) && $_GET['status'] == 'Y' ? 'selected' : '' }}>Aktif</option>
                        <option value="N" {{ isset($_GET['status']) && $_GET['status'] == 'N' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary mt-4 btn-cari">Cari</button>
                </div>
            </div>
        </form> 
        <div class="table-responsive text-nowrap">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th><strong>No</strong></th>
                        <th><strong>Tanggal</strong></th>
                        <th><strong>Supplier</strong></th>
                        <th><strong>Total Item</strong></th>
                        <th><strong>Total Harga</strong></th>
                        <th><strong>Diskon</strong></th>
                        <th><strong>Total Bayar</strong></th>
                        <th><strong>Jenis Transaksi</strong></th>
                        <th><strong>Aksi</strong></th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    <tr>
                        <td>1</td>
                        <td>26/09/2024</td>
                        <td>Wonka</td>
                        <td>120</td>
                        <td>Rp. 900.000</td>
                        <td>20%</td>
                        <td>Rp. 750.000</td>
                        <td><span class="badge rounded-pill bg-success">Cash</span></td>
                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                    data-bs-toggle="dropdown">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal"
                                        data-bs-target="#"><i
                                            class="bx bx-detail me-1 text-primary"></i>
                                        Detail</a>
                                    <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal"
                                        data-bs-target="#"><i
                                            class="bx bx-trash-alt me-1 text-danger"></i>
                                        Hapus</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>26/09/2024</td>
                        <td>Wonka</td>
                        <td>120</td>
                        <td>Rp. 900.000</td>
                        <td>20%</td>
                        <td>Rp. 750.000</td>
                        <td><span class="badge rounded-pill bg-warning">Credit</span></td>
                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                    data-bs-toggle="dropdown">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal"
                                        data-bs-target="#"><i
                                            class="bx bx-detail me-1 text-primary"></i>
                                        Detail</a>
                                    <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal"
                                        data-bs-target="#"><i
                                            class="bx bx-trash-alt me-1 text-danger"></i>
                                        Hapus</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>26/09/2024</td>
                        <td>Wonka</td>
                        <td>120</td>
                        <td>Rp. 900.000</td>
                        <td>20%</td>
                        <td>Rp. 750.000</td>
                        <td><span class="badge rounded-pill bg-success">Cash</span></td>
                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                    data-bs-toggle="dropdown">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal"
                                        data-bs-target="#"><i
                                            class="bx bx-detail me-1 text-primary"></i>
                                        Detail</a>
                                    <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal"
                                        data-bs-target="#"><i
                                            class="bx bx-trash-alt me-1 text-danger"></i>
                                        Hapus</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>26/09/2024</td>
                        <td>Wonka</td>
                        <td>120</td>
                        <td>Rp. 900.000</td>
                        <td>20%</td>
                        <td>Rp. 750.000</td>
                        <td><span class="badge rounded-pill bg-success">Cash</span></td>
                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                    data-bs-toggle="dropdown">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal"
                                        data-bs-target="#"><i
                                            class="bx bx-detail me-1 text-primary"></i>
                                        Detail</a>
                                    <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal"
                                        data-bs-target="#"><i
                                            class="bx bx-trash-alt me-1 text-danger"></i>
                                        Hapus</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    {{-- @if (count($kategori) < 1)
                        <tr>
                            <td colspan="8" style="padding: 20px; font-size: 20px;"><span>No data found</span> </td>
                        </tr>
                    @else
                        @foreach ($kategori as $i)
                            @include('ctgr-produk.modal.modalDelCtgr')
                            @include('ctgr-produk.modal.modalDetailCtgr')
                            @include('ctgr-produk.modal.modalEditCtgr')
                            <tr>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                            data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal"
                                                data-bs-target="#detailCtgrProduct{{ $i->ctgr_product_id }}"><i
                                                    class="bx bx-detail me-1 text-primary"></i>
                                                Detail</a>
                                            <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal"
                                                data-bs-target="#editCtgrProduct{{ $i->ctgr_product_id }}"><i
                                                    class="bx bx-edit-alt me-1 text-warning"></i>
                                                Ubah</a>
                                            <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal"
                                                data-bs-target="#delCtgrProduct{{ $i->ctgr_product_id }}"><i
                                                    class="bx bx-trash-alt me-1 text-danger"></i>
                                                Hapus</a>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $i->ctgr_product_code }}</td>
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
                    @endif --}}
                </tbody>
            </table>
        </div>
        <div class="mt-5">
            {{-- <nav aria-label="Page navigation">
                <ul class="pagination justify-content-end">
                    <li class="page-item {{ $kategori->currentPage() == 1 ? 'disabled' : '' }} prev">
                        <a class="page-link" href="{{ $kategori->previousPageUrl() }}" aria-label="Previous">
                            <i class="tf-icon bx bx-chevrons-left"></i>
                        </a>
                    </li>
                    @for ($i = 1; $i <= $kategori->lastPage(); $i++)
                        <li class="page-item {{ $kategori->currentPage() == $i ? 'active' : '' }}">
                            <a class="page-link" href="{{ $kategori->url($i) }}">{{ $i }}</a>
                        </li>
                    @endfor
                    <li class="page-item {{ $kategori->currentPage() == $kategori->lastPage() ? 'disabled' : '' }} next">
                        <a class="page-link" href="{{ $kategori->nextPageUrl() }}" aria-label="Next">
                            <i class="tf-icon bx bx-chevrons-right"></i>
                        </a>
                    </li>
                </ul>
                <span>Total data {{ $total[0]->totalData }}, halaman {{ $kategori->currentPage() }} dari
                    {{ $kategori->lastPage() }}</span>
            </nav> --}}
        </div>
    </div>
@endsection
