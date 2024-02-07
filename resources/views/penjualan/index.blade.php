@extends('app')
@section('head')
    TransaksiPenjualan
@endsection
@section('title2')
    Transaksi Penjualan
@endsection

@section('content')
    <div class="card p-3">
        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <button type="button" class="btn-lg btn-primary" onclick="addTransaction()">
                Transaksi Baru
            </button>
            {{-- @include('pembelian.modal.modalSupplier') --}}
        </div>
        <form action="#" method="GET">
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
                            <option value="{{ $i->supplier_id }}"
                                {{ isset($_GET['supplier_id']) && $_GET['supplier_id'] == $i->supplier_id ? 'selected' : '' }}>
                                {{ $i->supplier_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="" class="fw-bold">Jenis Transaksi</label>
                    <select name="jenis_pembelian" class="form-select">
                        <option value="">- Semua -</option>
                        <option value="cash"
                            {{ isset($_GET['jenis_pembelian']) && $_GET['jenis_pembelian'] == 'cash' ? 'selected' : '' }}>
                            Cash</option>
                        <option value="credit"
                            {{ isset($_GET['jenis_pembelian']) && $_GET['jenis_pembelian'] == 'credit' ? 'selected' : '' }}>
                            Credit</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary mt-4 btn-cari">Cari</button>
                </div>
            </div>
        </form>
        <div class="table-responsive text-nowrap">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th><strong>No Nota</strong></th>
                        <th><strong>Tanggal</strong></th>
                        <th><strong>Supplier</strong></th>
                        <th><strong>Total Item</strong></th>
                        <th><strong>Total Harga</strong></th>
                        <th><strong>Diskon</strong></th>
                        <th><strong>Total Bayar</strong></th>
                        <th><strong>Jenis Transaksi</strong></th>
                        <th><strong>Detail</strong></th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    {{-- @if (count($pembelian) < 1)
                        <tr>
                            <td colspan="9" style="padding: 20px; font-size: 20px;"><span>No data found</span> </td>
                        </tr>
                    @else
                        @foreach ($pembelian as $i)
                            <tr>
                                <td><span class="badge bg-primary">{{ $i->nota }}</span></td>
                                <td>{{ $i->tanggal_pembelian }}</td>
                                <td>{{ $i->supplier_name }}</td>
                                <td>{{ $i->total_item }}</td>
                                <td>Rp {{ number_format($i->total_harga, 0, ',', '.') }}</td>
                                <td>{{ $i->diskon }}%</td>
                                <td>Rp {{ number_format($i->total_bayar, 0, ',', '.') }}</td>
                                <td>
                                    @if ($i->jenis_pembelian == 'credit')
                                        <span class="badge bg-warning">Credit</span>
                                    @else
                                        <span class="badge bg-success">Cash</span>
                                    @endif
                                </td>
                                <td>
                                    <button type="button" onclick="detailPembelian('{{ $i->pembelian_id }}')"
                                        data-bs-toggle="modal" data-bs-target="#modalDetailPembelian" class="btn p-2 btn-primary">
                                        <span class="bx bxs-detail"></span>
                                    </button>                                    
                                </td>
                            </tr>
                        @endforeach
                    @endif --}}
                </tbody>
            </table>
            {{-- @include('pembelian.modal.modalDetailPembelian') --}}
        </div>
        <div class="mt-5">
            {{-- <nav aria-label="Page navigation">
                <ul class="pagination justify-content-end">
                    <li class="page-item {{ $pembelian->currentPage() == 1 ? 'disabled' : '' }} prev">
                        <a class="page-link" href="{{ $pembelian->previousPageUrl() }}" aria-label="Previous">
                            <i class="tf-icon bx bx-chevrons-left"></i>
                        </a>
                    </li>
                    @for ($i = 1; $i <= $pembelian->lastPage(); $i++)
                        <li class="page-item {{ $pembelian->currentPage() == $i ? 'active' : '' }}">
                            <a class="page-link" href="{{ $pembelian->url($i) }}">{{ $i }}</a>
                        </li>
                    @endfor
                    <li class="page-item {{ $pembelian->currentPage() == $pembelian->lastPage() ? 'disabled' : '' }} next">
                        <a class="page-link" href="{{ $pembelian->nextPageUrl() }}" aria-label="Next">
                            <i class="tf-icon bx bx-chevrons-right"></i>
                        </a>
                    </li>
                </ul>
                <span>Total Data {{ $total[0]->totalData }}, halaman {{ $pembelian->currentPage() }} dari
                    {{ $pembelian->lastPage() }}</span>
            </nav> --}}
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function addTransaction(){
            $.ajax({
                url: "{{ route('transactionCreate.penjualan') }}", 
                method: "GET",
                success: function(response) {
                    console.log("response success create transaction");
                    window.location.href = "{{ route('transactionPage.penjualan') }}";
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            })
        }
    </script>
@endsection
