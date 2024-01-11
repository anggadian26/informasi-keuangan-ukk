<div class="modal fade" id="addCtgrProduct" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel3">Tambah Kategori Produk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                
            </div>
            <form action="{{ route('store.ctgrProduct') }}" method="POST">
                <hr>
                @csrf
                <div class="modal-body">
                    <div class="row justify-content-start mb-3">
                        <label class="col-sm-3 col-form-label text-start" for="basic-default-name">Kode Kategori</label>
                        <div class="col-sm-9">
                            <input type="text" name="ctgr_product_code"
                                class="form-control @error('ctgr_product_code') is-invalid @enderror" id="basic-default-name" style="text-transform: uppercase"
                                value="{{ old('ctgr_product_code') }}">
                            @error('ctgr_product_code')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="row justify-content-start mb-3">
                        <label class="col-sm-3 col-form-label text-start" for="basic-default-name">Nama Kategori</label>
                        <div class="col-sm-9">
                            <input type="text" name="ctgr_product_name"
                                class="form-control @error('ctgr_product_name') is-invalid @enderror" id="basic-default-name" style="text-transform: uppercase"
                                value="{{ old('ctgr_product_name') }}">
                            @error('ctgr_product_name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
