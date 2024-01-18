@extends('app')
@section('head')
    data produk
@endsection
@section('title2')
    Data Produk
@endsection

@section('content')
    <div class="card p-3">
        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <a href="{{ route('editPage.product') }}" class="btn btn-primary me-md-2 pe-3 ps-3 btn-responsive-padding">Tambah
                Data</a>
        </div>
        <form action="#" method="get" class="mb-3">
            @csrf
            <div class="row mb-3">
                <div class="col-md-3">
                    <label for="" class="fw-bold">Nama</label>
                    <input name="name" type="text" class="form-control" placeholder="Nama"
                        value="{{ isset($_GET['name']) ? $_GET['name'] : '' }}">
                </div>
                <div class="col-md-2">
                    <label for="" class="fw-bold">Angkatan</label>
                    <input name="angkatan" type="number" class="form-control" placeholder="Angkatan"
                        value="{{ isset($_GET['angkatan']) ? $_GET['angkatan'] : '' }}">
                </div>
                <div class="col-md-3">
                    <label for="" class="fw-bold">Jurusan</label>
                    <select name="jurusan_id" class="form-select">
                        <option value="">- All -</option>
                        
                    </select>
                </div>


                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary mt-4 btn-cari">Cari</button>
                </div>
            </div>
        </form>
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                    <tr>
                        <th><strong>Aksi</strong></th>
                        <th><strong>Kode</strong></th>
                        <th><strong>Nama</strong></th>
                        <th><strong>Kategori</strong></th>
                        <th><strong>Sub Kategori</strong></th>
                        <th><strong>Harga Produk</strong></th>
                        <th><strong>Status</strong></th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    <tr>
                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                    data-bs-toggle="dropdown">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal"
                                        data-bs-target="#"><i class="bx bx-detail me-1"></i>
                                        Detail</a>
                                    <a class="dropdown-item" href="javascript:void(0);"><i
                                            class="bx bx-edit-alt me-1"></i>
                                        Edit</a>
                                    <a class="dropdown-item" href="javascript:void(0);"><i
                                            class="bx bx-trash me-1"></i>
                                        Delete</a>
                                </div>
                        </td>
                        <td>B89234</td>
                        <td>MacBook Pro M3</td>
                        <td>Laptop</td>
                        <td>Ultrabook</td>
                        <td>Rp. 18.000.000</td>
                        <td>
                            <span class="badge rounded-pill bg-success">Aktif</span>
                        </td>
                    </tr>
                    {{-- @if (count($siswa) < 1 || $siswa == null)
                        <tr>
                            <td colspan="8" style="padding: 20px; font-size: 20px;"><span>No data found</span> </td>
                        </tr>
                    @else
                        @foreach ($siswa as $i)
                            @include('data_siswa.modal.detail')
                            <tr>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                            data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal"
                                                data-bs-target="#detailUser{{ $i->id }}"><i class="bx bx-detail me-1"></i>
                                                Detail</a>
                                            <a class="dropdown-item" href="javascript:void(0);"><i
                                                    class="bx bx-edit-alt me-1"></i>
                                                Edit</a>
                                            <a class="dropdown-item" href="javascript:void(0);"><i
                                                    class="bx bx-trash me-1"></i>
                                                Delete</a>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $i->name }}</td>
                                <td>{{ $i->angkatan }}</td>
                                <td>{{ $i->jurusan_code }}</td>
                                <td>{{ $i->username }}</td>
                                <td>{{ $i->email }}</td>
                            </tr>
                        @endforeach
                    @endif --}}
                </tbody>
            </table>
        </div>
        {{-- <div class="mt-5">
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-end">
                    <li class="page-item {{ ($siswa->currentPage() == 1) ? 'disabled' : '' }} prev">
                        <a class="page-link" href="{{ $siswa->previousPageUrl() }}" aria-label="Previous">
                            <i class="tf-icon bx bx-chevrons-left"></i>
                        </a>
                    </li>
                    @for ($i = 1; $i <= $siswa->lastPage(); $i++)
                        <li class="page-item {{ ($siswa->currentPage() == $i) ? 'active' : '' }}">
                            <a class="page-link" href="{{ $siswa->url($i) }}">{{ $i }}</a>
                        </li>
                    @endfor
                    <li class="page-item {{ ($siswa->currentPage() == $siswa->lastPage()) ? 'disabled' : '' }} next">
                        <a class="page-link" href="{{ $siswa->nextPageUrl() }}" aria-label="Next">
                            <i class="tf-icon bx bx-chevrons-right"></i>
                        </a>
                    </li>
                </ul>
                <span>Total data {{ $total[0]->totalData }}, halaman {{ $siswa->currentPage() }} dari {{ $siswa->lastPage() }}</span>
            </nav>
        </div> --}}
    </div>
@endsection
