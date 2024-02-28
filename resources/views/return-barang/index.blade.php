@extends('app')
@section('head')
    return-barang
@endsection
@section('title2')
    Return Barang
@endsection
@section('content')
    {{-- <div class="text-center">
        <h5 class="text-danger">Sorry, the page is still under development 🙏</h5>
    </div> --}}
    <div class="card p-3">
        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalReturn" onclick="buttonreturn()">Return Barang</button>
        </div>
        @include('return-barang.modal.modalnota')
        @include('return-barang.modal.modalerror')
        @include('return-barang.modal.modalReturnBarang')
        <form action="#" method="get" class="mb-3 mt-3">
            <div class="row mb-3">
                <div class="col-md-2">
                    <label for="" class="fw-bold">Tanggal</label>
                    <input name="tanggal" type="date" class="form-control" placeholder="Kode Produk"
                        value="{{ isset($_GET['tanggal']) ? $_GET['tanggal'] : '' }}">
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
                        <th><strong>Tanggal</strong></th>
                        <th><strong>Nota Penjualan</strong></th>
                        <th><strong>Produk</strong></th>
                        <th><strong>Jumlah</strong></th>
                        <th><strong>Record</strong></th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @if (count($return) < 0)
                        <tr>
                            <td colspan="8" style="padding: 20px; font-size: 20px;"><span>No data found</span> </td>
                        </tr>
                    @else
                        @foreach ($return as $key => $i)
                            <tr>
                                <td>{{ $i->tanggal }}</td>
                                <td>{{ $i->nota_penjualan }}</td>
                                <td>{{ $i->product_name }}</td>
                                <td>{{ $i->jumlah_return }}</td>
                                <td>{{ $i->name }}</td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
        <div class="mt-5">
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-end">
                    <li class="page-item {{ $return->currentPage() == 1 ? 'disabled' : '' }} prev">
                        <a class="page-link" href="{{ $return->previousPageUrl() }}" aria-label="Previous">
                            <i class="tf-icon bx bx-chevrons-left"></i>
                        </a>
                    </li>
                    @for ($i = 1; $i <= $return->lastPage(); $i++)
                        <li class="page-item {{ $return->currentPage() == $i ? 'active' : '' }}">
                            <a class="page-link" href="{{ $return->url($i) }}">{{ $i }}</a>
                        </li>
                    @endfor
                    <li class="page-item {{ $return->currentPage() == $return->lastPage() ? 'disabled' : '' }} next">
                        <a class="page-link" href="{{ $return->nextPageUrl() }}" aria-label="Next">
                            <i class="tf-icon bx bx-chevrons-right"></i>
                        </a>
                    </li>
                </ul>
                <span>Total data {{ $total[0]->totalData }}, halaman {{ $return->currentPage() }} dari
                    {{ $return->lastPage() }}</span>
            </nav>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#modalReturn form").submit(function(e) {
                e.preventDefault();
                var formData = $(this).serialize();
                $.ajax({
                    type: "POST",
                    url: "/return-barang-cek-nota", 
                    data: formData,
                    success: function(response) {
                        console.log(response);
                        if(!response.error) {
                            console.log(response.product);
                            $("#nota").val(response.penjualan.nota);
                            
                            
                            var selectElement = $("#selectProduct");
                            selectElement.empty();

                            selectElement.append('<option value=""></option>');

                            for (var i = 0; i < response.product.length; i++) {
                                var product = response.product[i];
                                selectElement.append('<option value="' + product.product_id + '">' + product.product_name + '</option>');
                            }

                            $('#modalReturn').modal('hide');
                            $('#modalReturnBarang').modal('show');

                            selectElement.on('change', function() {
                                var selectedProductId = $(this).val();
                                var detailPenjualan = response.detailPenjualan;

                                var selectedDetail = detailPenjualan.find(function(detail) {
                                    return detail.product_id == selectedProductId;
                                });

                                if (selectedDetail) {
                                    console.log(selectedDetail.detail_penjualan_id);
                                    $("#detail_penjualan_id").val(selectedDetail.detail_penjualan_id);
                                } else {
                                    $("#detail_penjualan_id").val("");
                                }
                            });

                            $('#jumlah_return').on('input', function() {
                                var selectedProductId = $('#selectProduct').val();
                                var detailPenjualan = response.detailPenjualan;

                                var selectedDetail = detailPenjualan.find(function(detail) {
                                    return detail.product_id == selectedProductId;
                                });

                                if (selectedDetail && parseInt($('#jumlah_return').val()) > selectedDetail.jumlah) {
                                    alert('Jumlah return melebihi jumlah pembelian baranng .');
                                    $('#jumlah_return').val('');
                                }
                            });
                        } else{
                            $("#nota_penjualan").val("");
                            $('#modalReturn').modal('hide');
                            $('#errorNota').modal('show');
                            // alert("Form submission failed. Please try again.");
                        }
                    },
                    error: function(error) {
                        console.error("Error submitting form:", error);
                        // Handle any errors if needed
                    }
                });
            });
        });

        function buttonreturn() {
            $("#nota_penjualan").val("");
        }
    </script>
@endsection
