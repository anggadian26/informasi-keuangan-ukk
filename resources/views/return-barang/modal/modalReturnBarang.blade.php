<div class="modal fade" id="modalReturnBarang" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel4">Return Barang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('returnAction.returnBarang') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="detail_penjualan_id" id="detail_penjualan_id">
                    <div class="row justify-content-start mb-3">
                        <label class="col-sm-3 col-form-label text-start" for="basic-default-name">Nota</label>
                        <div class="col-sm-9">
                            <input type="text" name="nota"
                                class="form-control" id="nota" readonly>
                        </div>
                    </div>
                    <div class="row justify-content-start mb-3">
                        <label class="col-sm-3 col-form-label text-start" for="basic-default-name">Produk</label>
                        <div class="col-sm-9">
                            <select name="product_id" class="form-select" id="selectProduct"
                                aria-label="Default select example">
                                <option value=""></option>
                            </select>
                            @error('product_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="row justify-content-start mb-3">
                        <label class="col-sm-3 col-form-label text-start" for="basic-default-name">Jumlah</label>
                        <div class="col-sm-9">
                            <input type="text" name="jumlah_return"
                                class="form-control @error('jumlah_return') is-invalid @enderror" id="jumlah_return">
                            @error('jumlah_return')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="row justify-content-start mb-3">
                        <label class="col-sm-3 col-form-label text-start" for="basic-default-name">Keterangan</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" name="keterangan" rows="4"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button type="submit" class="btn btn-primary">Return</button>
                </div>
            </form>
        </div>
    </div>
</div>
