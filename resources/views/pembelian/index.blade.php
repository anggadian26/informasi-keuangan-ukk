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
            <button type="button" class="btn-lg btn-primary" data-bs-toggle="modal" data-bs-target="#modalSupplier">
                Transaksi Baru
            </button>
            @include('pembelian.modal.modalSupplier')
        </div>

            @csrf
            <div class="row mb-3">
                <div class="col-md-2">
                    <label for="" class="fw-bold">Tanggal</label>
                    <input name="tanggal_pembelian" type="date" class="form-control" placeholder="Tanggal"
                        value="{{ isset($_GET['tanggal_pembelian']) ? $_GET['tanggal_pembelian'] : '' }}">
                </div>
                <div class="col-md-2">
                    <label for="" class="fw-bold">Supplier</label>
                    <select name="supplier_id" class="form-select">
                        <option value="">- Semua -</option>
                        @foreach ($supplier as $i)
                            <option value="{{ $i->supplier_id }}" {{ isset($_GET['supplier_id']) && $_GET['supplier_id'] == $i->supplier_id ? 'selected' : '' }}>{{ $i->supplier_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="" class="fw-bold">Jenis Transaksi</label>
                    <select name="jenis_pembelian" class="form-select">
                        <option value="">- Semua -</option>
                        <option value="cash" {{ isset($_GET['jenis_pembelian']) && $_GET['jenis_pembelian'] == 'cash' ? 'selected' : '' }}>Cash</option>
                        <option value="credit" {{ isset($_GET['jenis_pembelian']) && $_GET['jenis_pembelian'] == 'credit' ? 'selected' : '' }}>Credit</option>
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
                    @if ($data == null)
                        <tr>
                            <td colspan="8" style="padding: 20px; font-size: 20px;"><span>No data found</span> </td>
                        </tr>
                    @else
                        @foreach ($data as $key => $pembelian)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $pembelian->tanggal_pembelian }}</td>
                                <td>{{ $pembelian->supplier->supplier_name }}</td>
                                <td>{{ $pembelian->total_item }}</td>
                                <td>{{ $pembelian->total_harga }}</td>
                                <td>{{ $pembelian->diskon }}%</td>
                                <td>Rp. {{ $pembelian->total_bayar }}</td>
                                <td>
                                    @if ($pembelian->jenis_pembelian == 'credit')
                                        <span class="badge rounded-pill bg-warning">Credit</span>
                                    @else
                                        <span class="badge rounded-pill bg-success">Cash</span>
                                    @endif
                                </td>
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
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    {{-- <tr>
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
                    </tr> --}}
                    
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
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-end">
                    <li class="page-item {{ $data->currentPage() == 1 ? 'disabled' : '' }} prev">
                        <a class="page-link" href="{{ $data->previousPageUrl() }}" aria-label="Previous">
                            <i class="tf-icon bx bx-chevrons-left"></i>
                        </a>
                    </li>
                    @for ($i = 1; $i <= $data->lastPage(); $i++)
                        <li class="page-item {{ $data->currentPage() == $i ? 'active' : '' }}">
                            <a class="page-link" href="{{ $data->url($i) }}">{{ $i }}</a>
                        </li>
                    @endfor
                    <li class="page-item {{ $data->currentPage() == $data->lastPage() ? 'disabled' : '' }} next">
                        <a class="page-link" href="{{ $data->nextPageUrl() }}" aria-label="Next">
                            <i class="tf-icon bx bx-chevrons-right"></i>
                        </a>
                    </li>
                </ul>
                <span>Total data {{ $total[0]->totalData }}, halaman {{ $data->currentPage() }} dari
                    {{ $data->lastPage() }}</span>
            </nav>
        </div>
    </div>
@endsection
