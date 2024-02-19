<div class="modal fade" id="modalUbahDiskon{{ $i->product_id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel3">Ubah Diskon Produk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

            </div>
            <form action="{{ route('store.diskon', ['id' => $i->product_id]) }}" method="POST">
                <hr>
                @csrf
                <div class="modal-body">
                    <div class="row justify-content-start mb-3">
                        <label class="col-sm-3 col-form-label text-start" for="basic-default-name">Diskon %</label>
                        <div class="col-sm-9">
                            <input type="number" name="diskon"
                                class="form-control @error('diskon') is-invalid @enderror"
                                id="basic-default-name"
                                value="{{ $i->diskon }}">
                            @error('diskon')
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
