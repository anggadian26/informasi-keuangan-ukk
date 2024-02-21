<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>komobox | Laporan Stok</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
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
            font-size: 1.1rem;
            /* Ukuran font yang lebih kecil */
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
            padding: 0.5rem;
            /* Ukuran padding yang lebih kecil */
            vertical-align: top;
            border-top: 1px solid #dee2e6;
            font-size: 0.9rem;
            /* Ukuran font yang lebih kecil */
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
            <div class="col-12 text-center mb-5">
                <h2 class="text-black fw-bold">Laporan <span style="color: #34A7F5">Stok</span></h2>
                <h4 class="text-black fw-bold">{{ $parameter }}</h4>
            </div>
        </div>
        <div class="row">
            <table class="table table-bordered">
                <thead style="background-color: #C3CEF4 !important;">
                    <tr>
                        <th><strong>No</strong></th>
                        <th><strong>Kode Produk</strong></th>
                        <th><strong>Nama Produk</strong></th>
                        <th><strong>Stok</strong></th>
                        <th><strong>Update Terakhir</strong></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $key => $i)    
                    <tr>
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $i->product_code }}</td>
                            <td>{{ $i->product_name }}</td>
                            <td>{{ $i->total_stok }}</td>
                            <td>{{ $i->update_stok_date }}</td>
                        </tr> 
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>

</html>
