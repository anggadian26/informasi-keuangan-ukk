<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>komobox | Laporan Pembelian</title>

    <style>
        /* Tambahkan gaya CSS Anda di sini */
    
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
    
        .container {
            max-width: 960px;
            margin: 0 auto;
            padding: 20px;
        }
    
        .text-center {
            text-align: center;
        }
    
        .text-black {
            color: #000;
        }
    
        .fw-bold {
            font-weight: bold;
        }
    
        .fw-semibold {
            font-weight: 600;
        }
    
        .fs-5 {
            font-size: 1.1rem; /* Ukuran font yang lebih kecil */
        }
    
        .mb-4 {
            margin-bottom: 1rem;
        }
    
    
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 1rem;
            background-color: transparent;
            color: #000;
            margin-right: -20px;
        }
    
        .table th,
        .table td {
            padding: 0.5rem; /* Ukuran padding yang lebih kecil */
            vertical-align: top;
            border-top: 1px solid #dee2e6;
            font-size: 0.9rem; /* Ukuran font yang lebih kecil */
        }
    
        .table-bordered th,
        .table-bordered td {
            border: 1px solid #dee2e6;
        }
    
        .bg-primary {
            background-color: #C3CEF4 !important;
        }
    
        .text-white {
            color: #fff !important;
        }
    
        .table-border-bottom-0 tbody tr:last-child th,
        .table-border-bottom-0 tbody tr:last-child td {
            border-bottom: 0;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-4">
                <h2 class="text-black fw-bold">Laporan Pembelian</h2>
                <h4 class="text-black fw-bold">Periode {{ $parameter }}</h4>
            </div>
        </div>
        <div class="text-nowrap">
            <table class="table table-bordered table-striped">
                <thead class="bg-primary">
                    <tr>
                        <th><strong>No</strong></th>
                        <th><strong>Tanggal</strong></th>
                        <th><strong>No Nota</strong></th>
                        <th><strong>Supplier</strong></th>
                        <th><strong>Jenis Transaksi</strong></th>
                        <th><strong>Total Item</strong></th>
                        <th><strong>Harga</strong></th>
                        <th><strong>Diskon</strong></th>
                        <th><strong>Bayar</strong></th>
                        <th><strong>Status</strong></th>
                        <th><strong>Admin</strong></th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach ($data as $key => $i)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $i->tanggal_pembelian }}</td>
                            <td>{{ $i->nota }}</td>
                            <td>{{ $i->supplier_name }} - {{ $i->supplier_company }}</td>
                            <td>{{ $i->jenis_pembelian }}</td>
                            <td>{{ $i->total_item }}</td>
                            <td>Rp {{ number_format($i->total_harga, 0, ',', '.') }}</td>
                            <td>{{ $i->diskon }}%</td>
                            <td>Rp {{ number_format($i->total_bayar, 0, ',', '.') }}</td>
                            <td>{{ $i->status_pembayaran == 'L' ? 'Lunas' : 'Belum Lunas' }}</td>
                            <td>{{ $i->name }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
