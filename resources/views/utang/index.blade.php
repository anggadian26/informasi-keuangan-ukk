@extends('app')
@section('head')
    UtangData
@endsection
@section('title2')
    Utang
@endsection
@section('content')
    <div class="card p-3">
        <form action="#" method="get" class="mb-3 mt-3">
            @csrf
            <div class="row mb-3">
                <div class="col-md-2">
                    <label for="" class="fw-bold">Tanggal Jatuh Tempo</label>
                    <input name="tanggal_jatuh_tempo" type="date" class="form-control" placeholder="Tanggal Jatuh Tempo"
                        value="{{ isset($_GET['tanggal_jatuh_tempo']) ? $_GET['tanggal_jatuh_tempo'] : '' }}">
                </div>
                <div class="col-md-2">
                    <label for="" class="fw-bold">Status Pembayaran</label>
                    <select name="status_pembayaran" class="form-select">
                        <option value="">- Semua -</option>
                        <option value="L"
                            {{ isset($_GET['status_pembayaran']) && $_GET['status_pembayaran'] == 'L' ? 'selected' : '' }}>
                            Lunas</option>
                        <option value="U"
                            {{ isset($_GET['status_pembayaran']) && $_GET['status_pembayaran'] == 'U' ? 'selected' : '' }}>
                            Belum Lunas</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary mt-4 btn-cari">Cari</button>
                </div>
            </div>
        </form>
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                    <tr>
                        <th><strong>No Nota</strong></th>
                        <th><strong>Total Utang</strong></th>
                        <th><strong>Uang Muka</strong></th>
                        <th><strong>Sisa Utang</strong></th>
                        <th><strong>Tanggal Jatuh Tempo</strong></th>
                        <th><strong>Status</strong></th>
                        <th><strong>Aksi</strong></th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @if (count($utang) < 1)
                        <tr>
                            <td colspan="8" style="padding: 20px; font-size: 20px;"><span>No data found</span> </td>
                        </tr>
                    @else
                        @foreach ($utang as $i)
                            <tr>
                                <td><span class="badge bg-primary">{{ $i->nota }}</span></td>
                                <td>Rp {{ number_format($i->total_bayar, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($i->uang_muka, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($i->sisa_pembayaran, 0, ',', '.') }}</td>
                                <td>{{ $i->tanggal_jatuh_tempo }}</td>
                                <td>
                                    @if ($i->status_pembayaran == 'U')
                                        <span class="badge bg-warning">Utang</span>
                                    @else
                                        <span class="badge bg-success">Lunas</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                            data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item"
                                                onclick="detailUtang('{{ $i->utang_id }}')" data-bs-toggle="modal"
                                                data-bs-target="#modalDetailUtang"><i class="bx bx-detail me-1"></i>
                                                Detail Pembayaran</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
        @include('utang.modalBayarUtang')
        @include('utang.modalDetailUtang')
        <div class="mt-5">
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-end">
                    <li class="page-item {{ $utang->currentPage() == 1 ? 'disabled' : '' }} prev">
                        <a class="page-link" href="{{ $utang->previousPageUrl() }}" aria-label="Previous">
                            <i class="tf-icon bx bx-chevrons-left"></i>
                        </a>
                    </li>
                    @for ($i = 1; $i <= $utang->lastPage(); $i++)
                        <li class="page-item {{ $utang->currentPage() == $i ? 'active' : '' }}">
                            <a class="page-link" href="{{ $utang->url($i) }}">{{ $i }}</a>
                        </li>
                    @endfor
                    <li class="page-item {{ $utang->currentPage() == $utang->lastPage() ? 'disabled' : '' }} next">
                        <a class="page-link" href="{{ $utang->nextPageUrl() }}" aria-label="Next">
                            <i class="tf-icon bx bx-chevrons-right"></i>
                        </a>
                    </li>
                </ul>
                <span>Total data {{ $total[0]->totalData }}, halaman {{ $utang->currentPage() }} dari
                    {{ $utang->lastPage() }}</span>
            </nav>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function detailUtang($id) {
            console.log($id);
            $.ajax({
                url: "{{ route('detail.utang', ['id' => ':id']) }}".replace(':id', $id),
                method: "GET",
                success: function(response) {
                    console.log(response);
                    var detailData = response.utang;
                    console.log(detailData);
                    var tableBody = $('#table-detail tbody');

                    tableBody.empty();

                    if (detailData.length > 0) {
                        $.each(detailData, function(index, detail) {
                            var newRow = '<tr>' +
                                '<td>' + detail.detail_tanggal + '</td>' +
                                '<td>' + 'Rp ' + formatCurrency(detail.bayar) + '</td>' +
                                '<td>' + 'Rp ' + formatCurrency(detail.sisa) + '</td>' +
                                '<td>' + detail.name + '</td>' +
                                '</tr>';

                            tableBody.append(newRow);
                        });
                    } else {
                        // Tampilkan pesan jika tidak ada hasil
                        tableBody.append(
                            '<tr><td colspan="5" style="padding: 20px; font-size: 20px;"><span>Tidak Ada Product Yang terdaftar</span></td></tr>'
                        );
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }

        function formatCurrency(amount) {
            // Format amount to currency with Indonesian Rupiah (IDR) format
            return new Intl.NumberFormat('id-ID').format(amount);
        }


    </script>
@endsection
