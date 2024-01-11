<div class="modal fade" id="detailCtgrProduct{{ $i->ctgr_product_id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel3">Detail Kategori Produk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

            </div>
            <form action="#" method="POST">
                <hr>
                @csrf
                <div class="modal-body">
                    <div class="row justify-content-start mb-3">
                        <label class="col-sm-3 col-form-label text-start" for="basic-default-name">Kode Kategori Produk</label>
                        <div class="col-sm-9">
                            <input type="text" name="ctgr_product_code" class="form-control" id="basic-default-name"
                                value="{{ $i->ctgr_product_code }}" readonly>
                        </div>
                    </div>
                    <div class="row justify-content-start mb-3">
                        <label class="col-sm-3 col-form-label text-start" for="basic-default-name">Nama Kategori Produk</label>
                        <div class="col-sm-9">
                            <input type="text" name="ctgr_product_code" class="form-control" id="basic-default-name"
                                value="{{ $i->ctgr_product_code }}" readonly>
                        </div>
                    </div>
                    <div class="row justify-content-start mb-3">
                        <label class="col-sm-3 col-form-label text-start" for="basic-default-name">Status</label>
                        <div class="col-sm-9">
                            <input type="text" name="ctgr_product_code" class="form-control" id="basic-default-name"
                                value="{{ $i->status == 'Y' ? 'Aktif' : 'Tidak Aktif' }}" readonly>
                        </div>
                    </div>
                    <div class="row justify-content-start mb-3">
                        <label class="col-sm-3 col-form-label text-start" for="basic-default-name">Terakhir diubah Oleh</label>
                        <div class="col-sm-9">
                            <input type="text" name="ctgr_product_code" class="form-control" id="basic-default-name"
                                value="{{ $i->name }}" readonly>
                        </div>
                    </div>
                    <div class="row justify-content-start mb-3">
                        <label class="col-sm-3 col-form-label text-start" for="basic-default-name">Tanggal Ubah Terakhir</label>
                        <div class="col-sm-9">
                            <input type="text" name="ctgr_product_code" class="form-control" id="basic-default-name"
                                value="{{ $i->updated_at }}" readonly>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
