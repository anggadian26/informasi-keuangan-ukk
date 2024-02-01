@extends('app')
@section('head')
    TransaksiPembelianAction
@endsection
@section('title1')
    Transaksi Pembelian /
@endsection
@section('title2')
    Aksi Transaksi
@endsection
@section('style')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .tampil-bayar {
            font-size: 5em;
            text-align: center;
            height: 100px;
        }

        .tampil-terbilang {
            padding: 10px;
            background: #f0f0f0;
        }

        .table-penjualan tbody tr:last-child {
            display: none;
        }

        @media(max-width: 768px) {
            .tampil-bayar {
                font-size: 3em;
                height: 70px;
                padding-top: 5px;
            }
        }
    </style>
@endsection

@section('content')
    <div class="card p-3">
        <div class="">
            <a href="{{ route('backTransaction.pembelian', ['id' => $pembelian_id]) }}"
                class="btn btn-primary pt-1 pb-1 mb-3"
                onclick="return confirm('Apakah Anda yakin ingin keluar dari transaksi?')">
                <span class="tf-icons bx bx-left-arrow-alt fw-bold"></span> Kembali
            </a>
        </div>
        
        <div class="row">
            <div class="col-md-5">
                <table>
                    <tr>
                        <td>Nama Supplier</td>
                        <td class="fw-bold">: {{ $supplier->supplier_name }}</td>
                    </tr>
                    <tr>
                        <td>Telepon Supplier</td>
                        <td class="fw-bold">: {{ $supplier->phone_number_person }}</td>
                    </tr>
                    <tr>
                        <td>Perusahaan Supplier</td>
                        <td class="fw-bold">: {{ $supplier->supplier_company }}</td>
                    </tr>
                    <tr>
                        <td>Alamat Perusahaan</td>
                        <td class="fw-bold">: {{ $supplier->address_company }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="row justify-content-end mb-5">
            <div class="col-sm-3 text-end">
                <form class="form-produk">
                    @csrf
                    <input type="hidden" name="product_id" id="product_id">
                    <input type="hidden" name="product_code" id="product_code">
                    <input type="hidden" name="pembelian_id" id="pembelian_id" value="{{ $pembelian_id }}">
                    <button class="btn-lg btn-success ps-5 pe-5 fw-bold" data-bs-toggle="modal"
                        data-bs-target="#pilihProduk">Pilih Produk</button>
                </form>
            </div>
        </div>
        @include('pembelian.modal.modalPilihProduk')
        @include('pembelian.modal.modalInfo')
        <div class="table-responsive text-nowrap">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th width="3%"><strong>No</strong></th>
                        <th><strong>Kode Produk</strong></th>
                        <th ><strong>Nama Produk</strong></th>
                        <th width=15%>
                            <strong>Harga Jual</strong>
                            <button type="button" data-bs-toggle="modal" data-bs-target="#infoHargaJual" class="btn-xs rounded-pill btn-icon btn-primary">
                                <span class="tf-icons bx bx-info-circle"></span>
                              </button>
                        </th>
                        <th width=15%>
                            <strong>Harga Beli</strong>
                            <button type="button" data-bs-toggle="modal" data-bs-target="#infoHargaBeli" class="btn-xs rounded-pill btn-icon btn-primary">
                                <span class="tf-icons bx bx-info-circle"></span>
                              </button>
                        </th>
                        <th width="12%"><strong>Jumlah</strong></th>
                        <th width="17%"><strong>Sub Total</strong></th>
                        <th><strong>Aksi</strong></th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0" id="detailTableBody">

                </tbody>
            </table>
            
        </div>
        <div class="row mt-5">
            <div class="col-lg-8">
                <div class="tampil-bayar bg-primary text-white"></div>
                <div class="tampil-terbilang"></div>
            </div>
            <div class="col-lg-4">
                <form action="#" class="form-penjualan" method="post">
                    @csrf
                    

                    <div class="form-group row mb-2">
                        <label for="totalrp" class="col-lg-4 control-label">Total</label>
                        <div class="col-lg-8">
                            <input type="text" id="totalrp" class="form-control" readonly>
                        </div>
                    </div>
                    
                    <div class="form-group row mb-2">
                        <label for="diskon" class="col-lg-4 control-label">Diskon (%)</label>
                        <div class="col-lg-8">
                            <input type="number" name="diskon" id="diskon"  value="0" class="form-control" onchange="updateBayar()">
                        </div>
                    </div>
                    
                    <div class="form-group row mb-2">
                        <label for="bayar" class="col-lg-4 control-label">Bayar</label>
                        <div class="col-lg-8">
                            <input type="text" id="bayarrp" class="form-control" readonly>
                        </div>
                    </div>
                   
                </form>
            </div>
        </div>
        <hr>
        <div class="text-end">
            <button class="btn-lg btn-primary"><span class="tf-icons bx bxs-save"></span> Simpan Transaksi</button>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        let table;

        function fetchDataAndUpdateTable() {
            let pembelianId = $('#pembelian_id').val();
            // Fetch data from the server
            $.get("{{ route('detailProduct.pembelian', ['id' => $pembelian_id]) }}")
                .done(response => {
                    console.log("berhasil");
                    updateTable(response.detail);
                })
                .fail(errors => {
                    alert('Tidak Dapat Mengambil Data');
                });
        }

        document.addEventListener("DOMContentLoaded", function() {
            fetchDataAndUpdateTable();
        });


        function updateTable(detailData) {
            let tableBody = $('#detailTableBody');
            tableBody.empty(); 
            let total = 0;
            // Loop through the data and append rows to the table
            $.each(detailData, function(index, detail) {
                let harga_beli = detail.harga_beli.toString().split('.')[0];
                let harga_jual = detail.harga_jual.toString().split('.')[0];
                let sub_total_number = parseFloat(detail.sub_total);
                // Check if sub_total is a valid number
                let sub_total_formatted;
                if (!isNaN(sub_total_number)) {
                    // Format sub_total as currency if it's a valid number
                    sub_total_formatted = sub_total_number.toLocaleString('id-ID');
                    total += sub_total_number;
                } else {
                    // If sub_total is not a valid number, display it as is
                    sub_total_formatted = detail.sub_total;
                }
                let rowHtml = 
                
                `<tr>
                    <td>${index + 1}</td>
                    <td>${detail.produk.product_code}</td>
                    <td>${detail.produk.product_name}</td>
                    <td><input type="number" class="form-control hargaJual" data-id="${detail.detail_pembelian_id}" value="${harga_jual}"></td>
                    <td><input type="number" class="form-control hargaBeli" data-id="${detail.detail_pembelian_id}" value="${harga_beli}"></td>
                    <td><input type="number" class="form-control quantity" data-id="${detail.detail_pembelian_id}" value="${detail.jumlah}"></td>
                    <td class="fw-bold">Rp ${sub_total_formatted}</td>
                    <td><a href="#" class="btn btn-danger delete-item" data-id="${detail.detail_pembelian_id}"><i class="bx bx-trash me-1"></i></a></td>
                </tr>`;

                tableBody.append(rowHtml);

                $(document).on('mouseleave', '.hargaJual', function () {
                    
                    let id = $(this).data('id');
                    let hargaJual = $(this).val();

                    if (hargaJual < 1) {
                        $(this).val(1);
                        alert('Jumlah tidak boleh kurang dari 1');
                        return;
                    }

                    $.post(`{{ url('/pembelian_quantity') }}/${id}`, {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        _method: 'POST',
                        harga_jual: hargaJual
                    })
                        .done(response => {
                            fetchDataAndUpdateTable();
                        })
                        .fail(errors => {
                            // alert('Tidak Dapat Menyimpan Data');
                            return;
                        })
                        
                });

                $(document).on('mouseleave', '.hargaBeli', function () {
                    
                    let id = $(this).data('id');
                    let hargaBeli = $(this).val();

                    if (hargaBeli < 1) {
                        $(this).val(1);
                        alert('Jumlah tidak boleh kurang dari 1');
                        return;
                    }

                    $.post(`{{ url('/pembelian_quantity') }}/${id}`, {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        _method: 'POST',
                        harga_beli: hargaBeli
                    })
                        .done(response => {
                            fetchDataAndUpdateTable();
                        })
                        .fail(errors => {
                            // alert('Tidak Dapat Menyimpan Data');
                            return;
                        })
                        
                });

                $(document).on('mouseleave', '.quantity', function () {
                    
                    let id = $(this).data('id');
                    let jumlah = $(this).val();

                    if (jumlah < 1) {
                        $(this).val(1);
                        alert('Jumlah tidak boleh kurang dari 1');
                        return;
                    }
                    if (jumlah > 100000) {
                        $(this).val(100000);
                        alert('Jumlah tidak boleh lebih dari 100000');
                        return;
                    }

                    $.post(`{{ url('/pembelian_quantity') }}/${id}`, {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        _method: 'POST',
                        jumlah: jumlah
                    })
                        .done(response => {
                            fetchDataAndUpdateTable();
                        })
                        .fail(errors => {
                            // alert('Tidak Dapat Menyimpan Data');
                            return;
                        })
                        
                });
            });

            $('#totalrp').val('Rp ' +total.toLocaleString('id-ID'));

            updateBayar();
        }

        function updateBayar() {
            let diskon = parseFloat($('#diskon').val());
            let totalString = $('#totalrp').val().replace(/\./g, ''); 
            let totalReplace = totalString.replace(/[^\d.-]/g, '');
            let totalDiskon = parseInt(totalReplace);
            console.log(diskon);
            if (diskon < 0) {
                $(this).val(0);
            }
            let bayar;
            if (isNaN(diskon) || diskon <= 0) {
                bayar = totalDiskon; 
            } else {;
                let diskonAbsolut = (diskon / 100) * totalDiskon; 
                console.log(diskonAbsolut);
                bayar = totalDiskon - diskonAbsolut;
            }

            $('#bayarrp').val('Rp ' + bayar.toLocaleString('id-ID'));
            $('.tampil-bayar').text('Rp ' + bayar.toLocaleString('id-ID'));
            $('.tampil-terbilang').text(terbilang(bayar) + ' Rupiah');
        }

        function terbilang(n) {
            const bilangan = [
                '', 'Satu', 'Dua', 'Tiga', 'Empat', 'Lima', 'Enam', 'Tujuh', 'Delapan', 'Sembilan'
            ];
            const belasan = [
                'Sepuluh', 'Sebelas', 'Dua Belas', 'Tiga Belas', 'Empat Belas', 'Lima Belas', 'Enam Belas', 'Tujuh Belas', 'Delapan Belas', 'Sembilan Belas'
            ];
            const puluhan = [
                '', 'Sepuluh', 'Dua Puluh', 'Tiga Puluh', 'Empat Puluh', 'Lima Puluh', 'Enam Puluh', 'Tujuh Puluh', 'Delapan Puluh', 'Sembilan Puluh'
            ];

            if (n < 10) {
                return bilangan[n];
            } else if (n >= 10 && n < 20) {
                return belasan[n - 10];
            } else if (n >= 20 && n < 100) {
                return puluhan[Math.floor(n / 10)] + ' ' + bilangan[n % 10];
            } else if (n >= 100 && n < 1000) {
                return bilangan[Math.floor(n / 100)] + ' Ratus ' + terbilang(n % 100);
            } else if (n >= 1000 && n < 1000000) {
                return terbilang(Math.floor(n / 1000)) + ' Ribu ' + terbilang(n % 1000);
            } else if (n >= 1000000 && n < 1000000000) {
                return terbilang(Math.floor(n / 1000000)) + ' Juta ' + terbilang(n % 1000000);
            } else if (n >= 1000000000 && n < 1000000000000) {
                return terbilang(Math.floor(n / 1000000000)) + ' Miliar ' + terbilang(n % 1000000000);
            } else {
                return 'Angka terlalu besar untuk dijabarkan.';
            }
        }



        $(document).on('click', '.delete-item', function(e) {
            e.preventDefault();
            let id_detail = $(this).data('id');

            $.ajax({
                url: '/delete-pembelian-detail/' + id_detail, // Anda mungkin perlu menyesuaikan URL ini
                method: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    // Hapus baris dari tabel setelah berhasil menghapus data dari server
                    $(this).closest('tr').remove();
                    fetchDataAndUpdateTable();
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    alert('Gagal menghapus data. Silakan coba lagi.');
                }
            });
        });

        function hideModalProduct() {
            $('#pilihProduk').modal('hide');
        }


        function pilihProduct(id, code, pembelian_id) {
            $('#product_id').val(id);
            $('#product_code').val(code);
            $('#pembelian_id').val(pembelian_id);
            console.log($('.form-produk'));
            hideModalProduct();
            addProduct();
        }

        function addProduct() {
            $.post('{{ route('storePembelianProduct.pembelian') }}', $('.form-produk').serialize())
                .done(response => {
                    fetchDataAndUpdateTable();
                })
                .fail(errors => {
                    alert('Tidak Dapat Menyimpan Data');
                })
        }
        $(document).ready(function() {
            $('.form-produk').on('submit', function(event) {
                event.preventDefault();
            });
        });
    </script>
@endsection
