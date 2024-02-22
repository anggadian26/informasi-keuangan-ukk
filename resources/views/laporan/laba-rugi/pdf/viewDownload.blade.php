<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>komobox | Laporan Pemasukkan</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-5">
                <h2 class="text-black fw-bold">Laporan <span style="color: #34A7F5">Laba Rugi</span></h2>
                <h4 class="text-black fw-bold">Periode {{ $parameter }}</h4>
            </div>
        </div>
        <div class="row">
            <table class="table">
                <tbody>
                    <tr>
                        <td><strong>Pendapatan</strong></td>
                    </tr>
                </tbody>
                <tbody>
                    <tr>
                        <td class="text-center">Pendapatan Penjualan</td>
                        <td class="text-end">Rp {{ number_format($pendapatan[0]->pendapatan, 0, ',', '.') }}</td>
                    </tr>
                </tbody>
                <br>
                <tbody>
                    <tr>
                        <td class="fs-4"><strong>Pengeluaran</strong></td>
                    </tr>
                </tbody>
                <tbody>
                    <tr>
                        <td class="text-center">Pengeluaran Pembelian</td>
                        <td class="text-end">Rp {{ number_format($pengeluaran[0]->pengeluaran, 0, ',', '.') }}</td>
                    </tr>
                </tbody>
            </table>
            <br>
            <hr>
            <table class="table"> 
                <tr>
                    <td><strong>LABA/RUGI</strong></td>
                    <td class="text-end fw-bold">Rp {{ number_format($labaRugi, 0, ',', '.') }}</td>
                </tr>
            </table>
            <hr>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>

</html>
