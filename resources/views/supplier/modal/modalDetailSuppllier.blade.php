<div class="modal fade" id="detailSupplier{{ $i->supplier_id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel3">Detail Supplier</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

            </div>
            <form action="#">
                <hr>
                @csrf
                <div class="modal-body">
                    <div class="row justify-content-start mb-3">
                        <label class="col-sm-3 col-form-label text-start" for="basic-default-name">Nama Supplier</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="basic-default-name"
                                value="{{ $i->supplier_name }}" readonly>
                        </div>
                    </div>
                    <div class="row justify-content-start mb-3">
                        <label class="col-sm-3 col-form-label text-start" for="basic-default-name">No. Tlpn Supplier</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="basic-default-name"
                                value="{{ $i->phone_number_person }}" readonly>
                        </div>
                    </div>
                    <div class="row justify-content-start mb-3">
                        <label class="col-sm-3 col-form-label text-start" for="basic-default-name">Email Supplier</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="basic-default-name"
                                value="{{ $i->email_person }}" readonly>
                        </div>
                    </div>
                    <div class="row justify-content-start mb-3">
                        <label class="col-sm-3 col-form-label text-start" for="basic-default-name">Perusahaan</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="basic-default-name"
                                value="{{ $i->supplier_company }}" readonly>
                        </div>
                    </div>
                    <div class="row justify-content-start mb-3">
                        <label class="col-sm-3 col-form-label text-start" for="basic-default-name">No. Tlpn Perusahaan</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="basic-default-name"
                                value="{{ $i->phone_number_company }}" readonly>
                        </div>
                    </div>
                    <div class="row justify-content-start mb-3">
                        <label class="col-sm-3 col-form-label text-start" for="basic-default-name">Alamat Perusahaan</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="basic-default-name"
                                value="{{ $i->address_company }}" readonly>
                        </div>
                    </div>
                    <div class="row justify-content-start mb-3">
                        <label class="col-sm-3 col-form-label text-start" for="basic-default-name">Status</label>
                        <div class="col-sm-9">
                            <input type="text" name="ctgr_product_code" class="form-control" id="basic-default-name"
                                value="{{ $i->status == 'Y' ? 'Aktif' : 'Tidak Aktif' }}" readonly>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
