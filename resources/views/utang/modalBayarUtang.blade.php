<div class="modal fade" id="bayarUtang{{ $i->utang_id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel3">Bayar Utang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

            </div>
            <form action="{{ route('bayar.utang') }}" method="POST">
                <hr>
                @csrf
                <div class="modal-body">
                    <div class="row justify-content-start mb-3">
                        <label class="col-sm-3 col-form-label text-start" for="basic-default-name">Nominal</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control @error('bayar') is-invalid @enderror" id="nominal" aria-describedby="defaultFormControlHelp" oninput="formatNominal(this)" name="hiden" />
                            @error('bayar')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <input type="hidden" id="hiddenNominalInput{{ $i->utang_id }}" name="bayar" />
                        <input type="hidden" name="utang_id" id="utang_id" value="{{ $i->utang_id }}"/>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button type="submit" class="btn btn-primary">Bayar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function formatNominal(input) {
        let value = input.value.replace(/[^\d]/g, ''); // Hapus semua karakter kecuali digit
        let numericValue = parseInt(value);
        console.log(numericValue);

        if (!isNaN(numericValue)) {
            let formattedValue = numericValue.toLocaleString('id-ID'); // Menggunakan konfigurasi lokal Indonesia
            input.value = `Rp. ${formattedValue}`;
            input.setAttribute('data-value', numericValue);

            let utangId = document.getElementById('utang_id').value;
            console.log(utangId);

            // Set nilai sebenarnya di input tersembunyi
            let hiddenInput = document.getElementById('hiddenNominalInput' + utangId);
            hiddenInput.value = numericValue;
        } else {
            // Tangani jika input tidak berisi nilai numerik
            input.value = '';
            input.setAttribute('data-value', '');
            let hiddenInput = document.getElementById('hiddenNominalInput' + utangId);
            hiddenInput.value = '';
        }
    }

</script>
