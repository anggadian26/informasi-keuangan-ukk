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
        
        </div>
        <form action="#" method="GET">
            @csrf
            <div class="row mb-3">

                <div class="col-md-2">
                    <label for="" class="fw-bold">Tanggal</label>
                    <input name="tanggal_penjualan" type="date" class="form-control" placeholder="Tanggal"
                        value="{{ isset($_GET['tanggal_penjualan']) ? $_GET['tanggal_penjualan'] : '' }}">
                </div>
                <div class="col-md-2">
                    <label for="" class="fw-bold">Jenis Transaksi</label>
                    <select name="jenis_transaksi" class="form-select">
                        <option value="">- Semua -</option>
                        <option value="cash"
                            {{ isset($_GET['jenis_transaksi']) && $_GET['jenis_transaksi'] == 'cash' ? 'selected' : '' }}>
                            Cash</option>
                        <option value="credit"
                            {{ isset($_GET['jenis_transaksi']) && $_GET['jenis_transaksi'] == 'credit' ? 'selected' : '' }}>
                            Credit</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="" class="fw-bold">Status Pembayaran</label>
                    <select name="status_pembayaran" class="form-select">
                        <option value="">- Semua -</option>
                        <option value="L"
                            {{ isset($_GET['status_pembayaran']) && $_GET['status_pembayaran'] == 'L' ? 'selected' : '' }}>
                            Lunas</option>
                        <option value="U"
                            {{ isset($_GET['status_pembayaran']) && $_GET['status_pembayaran'] == 'U' ? 'selected' : '' }}>
                            Belum Lunas</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary mt-4 btn-cari">Cari</button>
                </div>
            </div>
        </form>
        <div class=" text-nowrap">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th><strong>No Nota</strong></th>
                        <th><strong>Tanggal</strong></th>
                        <th><strong>Total Item</strong></th>
                        <th><strong>Total Harga</strong></th>
                        <th><strong>Jenis Transaksi</strong></th>
                        <th><strong>Status Pembayaran</strong></th>
                        <th><strong>Detail</strong></th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @if (count($penjualan) < 1)
                        <tr>
                            <td colspan="9" style="padding: 20px; font-size: 20px;"><span>No data found</span> </td>
                        </tr>
                    @else
                        @foreach ($penjualan as $i)
                            <tr>
                                <td><span class="badge bg-primary">{{ $i->nota }}</span></td>
                                <td>{{ $i->tanggal_penjualan }}</td>
                                <td>{{ $i->total_item }}</td>
                                <td>Rp {{ number_format($i->total_harga, 0, ',', '.') }}</td>
                                <td>
                                    @if ($i->jenis_transaksi == 'credit')
                                        <span class="badge bg-warning">Credit</span>
                                    @else
                                        <span class="badge bg-success">Cash</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($i->status_pembayaran == 'U')
                                        <span class="badge bg-warning">Belum Lunas</span>
                                    @else
                                        <span class="badge bg-success">Lunas</span>
                                    @endif
                                </td>
                                <td>
                                    <button type="button" onclick="detailPenjualan('{{ $i->penjualan_id }}')"
                                        data-bs-toggle="modal" data-bs-target="#modalDetaiPenjualan" class="btn p-2 btn-primary">
                                        <span class="bx bxs-detail"></span>
                                    </button>                                    
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
            @include('penjualan.modal.modalDetailPenjualan')
        </div>
        <div class="mt-5">
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-end">
                    <li class="page-item {{ $penjualan->currentPage() == 1 ? 'disabled' : '' }} prev">
                        <a class="page-link" href="{{ $penjualan->previousPageUrl() }}" aria-label="Previous">
                            <i class="tf-icon bx bx-chevrons-left"></i>
                        </a>
                    </li>
                    @for ($i = 1; $i <= $penjualan->lastPage(); $i++)
                        <li class="page-item {{ $penjualan->currentPage() == $i ? 'active' : '' }}">
                            <a class="page-link" href="{{ $penjualan->url($i) }}">{{ $i }}</a>
                        </li>
                    @endfor
                    <li class="page-item {{ $penjualan->currentPage() == $penjualan->lastPage() ? 'disabled' : '' }} next">
                        <a class="page-link" href="{{ $penjualan->nextPageUrl() }}" aria-label="Next">
                            <i class="tf-icon bx bx-chevrons-right"></i>
                        </a>
                    </li>
                </ul>
                <span>Total Data {{ $total[0]->totalData }}, halaman {{ $penjualan->currentPage() }} dari
                    {{ $penjualan->lastPage() }}</span>
            </nav>
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
        function detailPenjualan(id) {
            $.ajax({
                url: "{{ route('penjualanDetail.penjualan', ['id' => ':id']) }}".replace(':id', id),
                method: "GET",
                success: function(response) {
                    console.log(response);
                    let catatan = '';
                    if(response.penjualan[0].catatan != null) {
                        catatan = response.penjualan[0].catatan;
                    } else {
                        catatan = '';
                    }
                    $('#notavalue').text(': ' + response.penjualan[0].nota);
                    $('#authorBy').text( ': ' + response.penjualan[0].name);
                    $('#bayarValue').text( ': Rp.' + formatCurrency(response.penjualan[0].bayar));
                    $('#kembalianValue').text( ': Rp.' + formatCurrency(response.penjualan[0].kembalian));
                    $('#catatanValue').text( ': ' + catatan);
                    var detailData = response.detail;
                    var tableBody = $('#table-detail tbody');

                    tableBody.empty();

                    if (detailData.length > 0) {
                        $.each(detailData, function(index, detail) {
                            var returnSpan = detail.flg_return ? ' <span class="text-warning"> [return]</span>' : '';
                            var newRow = '<tr>' +
                                '<td>' + detail.product_code + '</td>' +
                                '<td>' + detail.product_name + returnSpan + '</td>' +
                                '<td>' + 'Rp ' + formatCurrency(detail.harga_jual) + '</td>' +
                                '<td>' + detail.diskon + '%' + '</td>' +
                                '<td>' + 'Rp ' + formatCurrency(detail.harga_diskon) + '</td>' +
                                '<td>' + detail.jumlah + '</td>' +
                                '<td>' + 'Rp ' + formatCurrency(detail.sub_total) + '</td>' +
                                '</tr>';

                            tableBody.append(newRow);
                        });
                    } else {
                        // Tampilkan pesan jika tidak ada hasil
                        tableBody.append(
                            '<tr><td colspan="5" style="padding: 20px; font-size: 20px;"><span>Tidak Ada Product Yang terdaftar</span></td></tr>'
                        );
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }

        function formatCurrency(amount) {
            // Format amount to currency with Indonesian Rupiah (IDR) format
            return new Intl.NumberFormat('id-ID').format(amount);
        }
    </script>
@endsection
