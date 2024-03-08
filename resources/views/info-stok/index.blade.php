@extends('app')
@section('head')
    Informasi Stok
@endsection
@section('title2')
    Informasi Stok
@endsection
@section('content')
    <div class="card p-3">
        <form action="#" method="get" class="mb-3 mt-3">
            @csrf
            <div class="row mb-3">
                <div class="col-md-2">
                    <label for="" class="fw-bold">Tanggal</label>
                    <input name="tanggal" type="date" class="form-control" placeholder="Tanggal"
                        value="{{ isset($_GET['tanggal']) ? $_GET['tanggal'] : '' }}">
                </div>

                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary mt-4 btn-cari">Cari</button>
                </div>
            </div>
        </form>
        <div class="table-responsive text-nowrap">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th rowspan="2" width="3%"><strong>No</strong></th>
                        <th rowspan="2" class="text-center"><strong>Tanggal</strong></th>
                        <th colspan="2" class="text-center"><strong>Total Barang</strong></th>
                        <th rowspan="2" class="text-center"><strong>Keterangan</strong></th>
                        <th rowspan="2" class="text-center"><strong>Detail</strong></th>
                    </tr>
                    <tr>
                        <th class="text-center"><strong>Masuk</strong></th>
                        <th class="text-center"><strong>Keluar</strong></th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @php $no = 1; @endphp
                    @foreach ($mergeData as $tanggal => $data)
                        @php $rowspan = count($data['detail']); @endphp
                        @foreach ($data['detail'] as $detail)
                            <tr>
                                {{-- Kolom No --}}
                                @if ($loop->first)
                                    <td rowspan="{{ $rowspan }}">{{ $no }}</td>
                                @endif
                                {{-- Kolom Tanggal --}}
                                @if ($loop->first)
                                    <td rowspan="{{ $rowspan }}">{{ $data['tanggal'] }}</td>
                                @endif
                                {{-- Kolom Masuk --}}
                                <td>{{ $detail['masuk'] }}</td>
                                {{-- Kolom Keluar --}}
                                <td>{{ $detail['keluar'] }}</td>
                                {{-- Kolom Keterangan --}}
                                <td>{{ $detail['keterangan'] }}</td>
                                {{-- Kolom Aksi --}}
                                <td>
                                    <button class="btn btn-primary btn-icon btm-sm" onclick="detailDataStok('{{ $detail['id'] }}', '{{ $detail['flg'] }}')" data-bs-toggle="modal"
                                        data-bs-target="#modalDetailStok"><i class='bx bx-detail'></i></button>
                                </td>
                            </tr>
                        @endforeach
                        @php $no++; @endphp
                    @endforeach
                </tbody>
            </table>
        </div>
        @include('info-stok.modal.detail_stok')
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function detailDataStok(id, flg) {
            console.log(id);
            console.log(flg);
            $.ajax({
                url: "/detail-informasi-stok/" + id + "/" + flg,
                method: 'GET',
                success: function(response){
                    console.log(response);
                    var detailData = response.detail;
                    var tableBody = $('#table-detail tbody');

                    tableBody.empty();

                    if (detailData.length > 0) {
                        $.each(detailData, function(index, detail) {
                            var jumlah = detail.jumlah ? detail.jumlah : detail.jumlah_return;
                            var newRow = '<tr>' +
                                '<td>' + detail.product_code + '</td>' +
                                '<td>' + detail.product_name + '</td>' +
                                '<td>' + jumlah + '</td>' +
                                '</tr>';

                            tableBody.append(newRow);
                        });
                    } else {
                        // Tampilkan pesan jika tidak ada hasil
                        tableBody.append(
                            '<tr><td colspan="3" style="padding: 20px; font-size: 20px;"><span>Tidak Ada Stok yang terdaftar</span></td></tr>'
                        );
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });

        }
    </script>
@endsection
