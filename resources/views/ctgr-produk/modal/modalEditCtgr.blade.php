<div class="modal fade" id="editCtgrProduct{{ $i->ctgr_product_id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel3">Tambah Kategori Produk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

            </div>
            <form action="{{ route('edit.ctgrProduct', ['id' => $i->ctgr_product_id]) }}" method="POST">
                <hr>
                @csrf
                <div class="modal-body">
                    <div class="row justify-content-start mb-3">
                        <label class="col-sm-3 col-form-label text-start" for="basic-default-name">Kode Kategori</label>
                        <div class="col-sm-9">
                            <input type="text" name="ctgr_product_code"
                                class="form-control @error('ctgr_product_code') is-invalid @enderror"
                                id="basic-default-name" style="text-transform: uppercase"
                                value="{{ $i->ctgr_product_code }}" readonly>
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
                                class="form-control @error('ctgr_product_name') is-invalid @enderror"
                                id="basic-default-name" style="text-transform: uppercase"
                                value="{{ $i->ctgr_product_name }}">
                            @error('ctgr_product_name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="row justify-content-start mb-3">
                        <label class="col-sm-3 col-form-label text-start" for="basic-default-name">Status</label>
                        <div class="col-sm-9">
                            <select name="status" class="form-select @error('status') is-invalid @enderror"
                                id="basic-default-name">
                                <option value="Y" {{ $i->status == 'Y' ? 'selected' : '' }}>Aktif</option>
                                <option value="N" {{ $i->status == 'N' ? 'selected' : '' }}>Tidak Aktif</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Batal
                        </button>
                        <button type="submit" class="btn btn-primary">Ubah</button>
                    </div>
            </form>
        </div>
    </div>
</div>
