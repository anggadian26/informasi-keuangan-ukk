@extends('app')
@section('head')
    laporan-pembelian
@endsection
@section('title2')
    Laporan Pembelian
@endsection
@section('content')
    <div class="card p-3">
        <div class="container-view">
            <form action="{{ route('download.laporanPembelian') }}" method="POST">
                @csrf
                <input type="hidden" name="action" id="action">
                <div class="row justify-content-start mb-3">
                    <label class="col-sm-2 col-form-label text-start" for="basic-default-name">Filter</label>
                    <div class="col-sm-7">
                        <select class="form-select" id="filterReport" name="select_filter" aria-label="Default select example">
                            <option value="hari_ini">Hari Ini</option>
                            <option value="kemarin">Kemarin</option>
                            <option value="bulan_ini">Bulan Ini</option>
                            <option value="bulan_kemarin">Bulan Kemarin</option>
                            <option value="lainnya">Lainnya</option>
                        </select>
                    </div>
                </div>
                <div class="row justify-content-start mb-3" id="tanggal" style="display: none;">
                    <label class="col-sm-2 col-form-label text-start" for="basic-default-name">Tanggal</label>
                    <div class="col-sm-7">
                        <div class="row">
                            <div class="col-sm-5">
                                <input type="date" class="form-control" name="date_from">
                            </div>
                            <div class="col-sm-1 text-center">
                                <h1>-</h1>
                            </div>
                            <div class="col-sm-5">
                                <input type="date" class="form-control" name="date_to" >
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-start mb-3">
                    <div class="col-sm-7 offset-sm-2"> 
                        <button type="button" class="btn btn-primary me-2" onclick="setAction('pdf')">Download PDF</button> 
                        <button type="button" class="btn btn-primary" onclick="setAction('excel')">Download Excel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#filterReport').change(function() {
                if ($(this).val() === 'lainnya') {
                    $('#tanggal').show();
                } else {
                    $('#tanggal').hide();
                }
            });
        });

        function setAction(action) {
            $('#action').val(action);
            $('form').submit();
        }
    </script>
@endsection
