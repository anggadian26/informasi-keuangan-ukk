<style>
    .modal-xl-scroll {
        max-height: 55vh;
        /* Set tinggi maksimum sesuai kebutuhan Anda, contoh menggunakan 80% dari tinggi viewport */
        overflow-y: auto;
        /* Tambahkan overflow-y: auto untuk memberikan kemampuan scroll jika kontennya melebihi tinggi maksimum */
    }
</style>


<div class="modal fade" id="modalSupplier" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel4">Pilih Supplier</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="">
                    <div class="row d-flex justify-content-end mb-2">
                        <div class="col-md-3">
                            <div class="input-group">
                                <input type="text" class="form-control" id="searchSupplier"
                                    placeholder="Nama Supplier" aria-label="Recipient's username"
                                    aria-describedby="button-addon2" />
                                <button class="btn btn-primary" type="button" id="button-addon2">
                                    <span class="tf-icons bx bx-search-alt-2"></span>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="modal-xl-scroll">
                    <div class="table-responsive text-nowrap">
                        <table class="table" id="supplierTable">
                            <thead>
                                <tr>
                                    <th><strong>Nama Supplier</strong></th>
                                    <th><strong>Perusahaan</strong></th>
                                    <th><strong>Telepon</strong></th>
                                    <th><strong>Email</strong></th>
                                    <th><strong>Aksi</strong></th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                                @if (count($supplier) < 1)
                                    <tr>
                                        <td colspan="5" style="padding: 20px; font-size: 20px;">
                                            <span>Tidak Ada Supplier Yang terdaftar</span>
                                        </td>
                                    </tr>
                                @else
                                    @foreach ($supplier as $i)
                                        <tr>
                                            <td>{{ $i->supplier_name }}</td>
                                            <td>{{ $i->supplier_company }}</td>
                                            <td>{{ $i->phone_number_person }}</td>
                                            <td>{{ $i->email_person }}</td>
                                            <td>
                                                <a href="{{ route('transactionCreate.pembelian', ['id' => $i->supplier_id]) }}" class="btn btn-primary ps-2 pe-2 pt-1 pb-1">
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
        $('#searchSupplier').on('input', function() {
            var searchTerm = $(this).val();

            $.ajax({
                url: '/search-supplier',
                method: 'GET',
                data: {
                    searchTerm: searchTerm
                },
                success: function(response) {
                    var supplierData = response.supplier;
                    var tableBody = $('#supplierTable tbody');

                    tableBody.empty();

                    if (supplierData.length > 0) {
                        $.each(supplierData, function(index, supplier) {
                            var newRow = '<tr>' +
                                '<td>' + supplier.supplier_name + '</td>' +
                                '<td>' + supplier.supplier_company + '</td>' +
                                '<td>' + supplier.phone_number_person + '</td>' +
                                '<td>' + supplier.email_person + '</td>' +
                                '<td>' +
                                '<a href="/transaksi-pembelian-page/' + supplier.supplier_id + '/create" class="btn btn-primary ps-2 pe-2 pt-1 pb-1">' +
                                '<span class="tf-icons bx bx-check-circle"></span>Pilih</a>' +
                                '</td>' +
                                '</tr>';

                            tableBody.append(newRow);
                        });
                    } else {
                        // Tampilkan pesan jika tidak ada hasil
                        tableBody.append(
                            '<tr><td colspan="5" style="padding: 20px; font-size: 20px;"><span>Tidak Ada Supplier Yang terdaftar</span></td></tr>'
                            );
                    }
                },
                error: function(error) {
                    console.error('Error:', error);
                }
            });
        });
    });
</script>
