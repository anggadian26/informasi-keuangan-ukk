<div class="modal fade" id="modalDetailUtang" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel4">Detail Pembayaran Utang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row d-flex justify-content-end">
                    <div class="col-2">
                        <button class="btn btn-primary ms-4 mb-3 mt-0 ps-5 pe-5" onclick="bayar()">Bayar</button>
                    </div>
                </div>
                <div class="modal-xl-scroll">
                    <div class="table-responsive text-nowrap">
                        <table class="table" id="table-detail">
                            <thead>
                                <tr>
                                    <th><strong>Tanggal</strong></th>
                                    <th><strong>Bayar</strong></th>
                                    <th><strong>Sisa</strong></th>
                                    <th><strong>Di bayar oleh</strong></th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
