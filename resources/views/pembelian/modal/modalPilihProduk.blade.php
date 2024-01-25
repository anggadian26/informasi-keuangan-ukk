<style>
    .modal-xl-scroll {
        max-height: 55vh;
        /* Set tinggi maksimum sesuai kebutuhan Anda, contoh menggunakan 80% dari tinggi viewport */
        overflow-y: auto;
        /* Tambahkan overflow-y: auto untuk memberikan kemampuan scroll jika kontennya melebihi tinggi maksimum */
    }
</style>


<div class="modal fade" id="pilihProduk" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel4">Pilih Produk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="">
                    <div class="row d-flex justify-content-end mb-2">
                        <div class="col-md-3">
                            <div class="input-group">
                                <input type="text" class="form-control" id="searchProduct" placeholder="Nama Produk"
                                    aria-label="Recipient's username" aria-describedby="button-addon2" />
                                <button class="btn btn-primary" type="button" id="button-addon2">
                                    <span class="tf-icons bx bx-search-alt-2"></span>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="modal-xl-scroll">
                    <div class="table-responsive text-nowrap">
                        <table class="table" id="productTable">
                            <thead>
                                <tr>
                                    <th><strong>Kode Produk</strong></th>
                                    <th><strong>Nama Produk</strong></th>
                                    <th><strong>Harga Beli</strong></th>
                                    <th><strong>Stok</strong></th>
                                    <th><strong>Aksi</strong></th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                                @if (count($product) < 1)
                                    <tr>
                                        <td colspan="5" style="padding: 20px; font-size: 20px;">
                                            <span>Tidak Ada Produk Yang terdaftar</span>
                                        </td>
                                    </tr>
                                @else
                                    @foreach ($product as $i)
                                        <tr>
                                            <td>{{ $i->product_code }}</td>
                                            <td>{{ $i->product_name }}</td>
                                            <td>{{ $i->product_purcase }}</td>
                                            <td>{{ $i->total_stok }}</td>
                                            <td>
                                                <a href="#"
                                                    onclick="pilihProduct('{{ $i->product_id }}', '{{ $i->product_code }}', '{{ $pembelian_id }}')"
                                                    class="btn btn-primary ps-2 pe-2 pt-1 pb-1">
                                                    <span class="tf-icons bx bx-check-circle"></span>Pilih
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#searchProduct').on('input', function() {
            var searchTerm = $(this).val();

            $.ajax({
                url: '/search-product-transaction',
                method: 'GET',
                data: {
                    searchTerm: searchTerm
                },
                success: function(response) {
                    var productData = response.product;
                    var tableBody = $('#productTable tbody');

                    tableBody.empty();

                    if (productData.length > 0) {
                        $.each(productData, function(index, product) {
                            var newRow = '<tr>' +
                                '<td>' + product.product_code + '</td>' +
                                '<td>' + product.product_name + '</td>' +
                                '<td>' + product.product_purcase + '</td>' +
                                '<td>' + product.total_stok + '</td>' +
                                '<td>' +
                                    '<a href="#" onclick="pilihProduct(\'' + product
                                    .product_id + '\', \'' + product.product_code +
                                    '\', \'' + pembelian_id +
                                    '\')" class="btn btn-primary ps-2 pe-2 pt-1 pb-1">' +
                                    '<span class="tf-icons bx bx-check-circle"></span>Pilih</a>' +
                                '</td>' +
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
                error: function(error) {
                    console.error('Error:', error);
                }
            });
        });
    });

    $(document).ready(function() {
        // Menangani klik pada ikon search
        $('#button-addon2').on('click', function() {
            focusSearchInput();
        });

        // Menangani klik pada ikon close
        $('.btn-close').on('click', function() {
            // Mengosongkan nilai input
            $('#searchProduct').val('');
        });

        // Fungsi untuk memindahkan fokus ke input pencarian
        function focusSearchInput() {
            $('#searchProduct').focus();
        }

        // Fungsi untuk menangani input pada modal
        $('#pilihProduk').on('shown.bs.modal', function() {
            // Memindahkan fokus ke input pencarian saat modal ditampilkan
            focusSearchInput();
        });
    });
</script>
