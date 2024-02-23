@extends('app')
@section('head')
    supplier
@endsection
@section('title2')
    Supplier
@endsection
@section('content')
    <div class="card p-3">
        @if ($loggedInUser->role->role == 'manager')
        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <a href="{{ route('addPage.supplier') }}" class="btn btn-primary">Tambah
                Data</a>
        </div>
        @endif
        <form action="#" method="get" class="mb-3 mt-3">
            @csrf
            <div class="row mb-3">
                <div class="col-md-2">
                    <label for="" class="fw-bold">Nama Supplier</label>
                    <input name="supplier_name" type="text" class="form-control" placeholder="Kode Produk"
                        value="{{ isset($_GET['supplier_name']) ? $_GET['supplier_name'] : '' }}">
                </div>
                <div class="col-md-2">
                    <label for="" class="fw-bold">Perusahaan</label>
                    <input name="supplier_company" type="text" class="form-control" placeholder="Nama Produk"
                        value="{{ isset($_GET['supplier_company']) ? $_GET['supplier_company'] : '' }}">
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
                        <th><strong>Nama</strong></th>
                        <th><strong>No. Tlpn</strong></th>
                        <th><strong>Email</strong></th>
                        <th><strong>Perusahaan</strong></th>
                        <th><strong>Status</strong></th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @if (count($supplier) < 1)
                        <tr>
                            <td colspan="8" style="padding: 20px; font-size: 20px;"><span>No data found</span> </td>
                        </tr>
                    @else
                        @foreach ($supplier as $i )
                            @include('supplier.modal.modalDetailSuppllier')
                            <tr>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                            data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal"
                                                data-bs-target="#detailSupplier{{ $i->supplier_id }}"><i
                                                    class="bx bx-detail me-1"></i>
                                                Detail</a>
                                            @if ($loggedInUser->role->role == 'manager')
                                            <a class="dropdown-item"
                                                href="{{ route('editPage.supplier', ['id' => $i->supplier_id]) }}"><i
                                                    class="bx bx-edit-alt me-1"></i>
                                                Edit</a>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $i->supplier_name }}</td>
                                <td>{{ $i->phone_number_person }}</td>
                                <td>{{ $i->email_person }}</td>
                                <td>{{ $i->supplier_company }}</td>
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
                    <li class="page-item {{ $supplier->currentPage() == 1 ? 'disabled' : '' }} prev">
                        <a class="page-link" href="{{ $supplier->previousPageUrl() }}" aria-label="Previous">
                            <i class="tf-icon bx bx-chevrons-left"></i>
                        </a>
                    </li>
                    @for ($i = 1; $i <= $supplier->lastPage(); $i++)
                        <li class="page-item {{ $supplier->currentPage() == $i ? 'active' : '' }}">
                            <a class="page-link" href="{{ $supplier->url($i) }}">{{ $i }}</a>
                        </li>
                    @endfor
                    <li class="page-item {{ $supplier->currentPage() == $supplier->lastPage() ? 'disabled' : '' }} next">
                        <a class="page-link" href="{{ $supplier->nextPageUrl() }}" aria-label="Next">
                            <i class="tf-icon bx bx-chevrons-right"></i>
                        </a>
                    </li>
                </ul>
                <span>Total data {{ $total[0]->totalData }}, halaman {{ $supplier->currentPage() }} dari
                    {{ $supplier->lastPage() }}</span>
            </nav>
        </div>
    </div>
@endsection
