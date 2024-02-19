@extends('app')
@section('head')
    Pengeluaran
@endsection
@section('title2')
    Pengeluaran
@endsection
@section('content')
    <div class="card p-3">
        <form action="#" method="get" class="mb-3 mt-3">
            @csrf
            <div class="row mb-3">
                <div class="col-md-2">
                    <label for="" class="fw-bold">Tanggal Pemasukkan</label>
                    <input name="tanggal" type="date" class="form-control" placeholder="Tanggal"
                        value="{{ isset($_GET['tanggal']) ? $_GET['tanggal'] : '' }}">
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
                        <th><strong>Tanggal Pemasukkan</strong></th>
                        <th><strong>Nominal</strong></th>
                        <th><strong>Keterangan</strong></th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @if (count($data) < 1)
                        <tr>
                            <td colspan="8" style="padding: 20px; font-size: 20px;"><span>No data found</span> </td>
                        </tr>
                    @else
                        @foreach ($data as $i)
                            <tr>
                                <td>{{ $i->tanggal_pengeluaran }}</td>
                                <td>Rp {{ number_format($i->total_nominal, 0, ',', '.') }}</td>
                                <td>{{ $i->keterangan }}</td>
                            </tr> 
                        @endforeach
                    @endif
                    
                </tbody>
            </table>
        </div>
        <div class="mt-5">
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-end">
                    <li class="page-item {{ ($data->currentPage() == 1) ? 'disabled' : '' }} prev">
                        <a class="page-link" href="{{ $data->previousPageUrl() }}" aria-label="Previous">
                            <i class="tf-icon bx bx-chevrons-left"></i>
                        </a>
                    </li>
                    @for ($i = 1; $i <= $data->lastPage(); $i++)
                        <li class="page-item {{ ($data->currentPage() == $i) ? 'active' : '' }}">
                            <a class="page-link" href="{{ $data->url($i) }}">{{ $i }}</a>
                        </li>
                    @endfor
                    <li class="page-item {{ ($data->currentPage() == $data->lastPage()) ? 'disabled' : '' }} next">
                        <a class="page-link" href="{{ $data->nextPageUrl() }}" aria-label="Next">
                            <i class="tf-icon bx bx-chevrons-right"></i>
                        </a>
                    </li>
                </ul>
                <span>Total data {{ $total[0]->totalData }}, halaman {{ $data->currentPage() }} dari {{ $data->lastPage() }}</span>
            </nav>
        </div>
    </div>
@endsection
