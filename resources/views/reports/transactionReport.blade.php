<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Transaksi</title>
    <style>
        .title {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
        }

        .title,
        .tanggal {
            text-align: center;
            font-family: sans-serif;
        }

        #table {
            font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        #table td,
        #table th {
            border: 1px solid #ddd;
            padding: 8px;
            font-size: 13px;

        }

        /*
        #table tr:nth-child(even) {
            background-color: #f9f8f8;
        } */

        #table tr:hover {
            background-color: #ddd;
        }

        #table th {
            padding-top: 10px;
            padding-bottom: 10px;
            text-align: left;
            background-color: #538b82;
            color: white;
            font-size: 13px;
        }

    </style>
</head>

<body>

    <table width="500" border="0">
        <tr>
            <td class="title">
                Laporan Transaksi
            </td>
        </tr>
    </table>
    <table width="500" border="0">
        <tr>
            <td class="tanggal">
                Dari tanggal 24 Mei 2023 Sampai Tanggal
                25 Mei 2023
            </td>
        </tr>
    </table>
    <br><br>
    <table id="table">
        <tr>
            <th>No</th>
            <th>Invoice Code</th>
            <th>Nama Toko</th>
            <th>Nama Sales</th>
            <th>Metode Pembayaran</th>
            <th>Status Pembayaran</th>
            <th>Status Pengiriman</th>
            <th>Tanggal Transaksi</th>
            <th>Nominal</th>
            <th>Jumlah Bayar</th>
            <th>Sisa</th>
        </tr>
        <tr>
            <td>1</td>
            <td>INV202304100001</td>
            <td>Toko Jaya Abadi</td>
            <td>Abdul</td>
            <td>Tempo</td>
            <td>Unpaid</td>
            <td>Process</td>
            <td>24 Mei 2023</td>
            <td>Rp 70.000</td>
            <td>Rp 20.000</td>
            <td>Rp 50.000</td>

        </tr>

        <tr>
            <td scope="row" colspan="10" style="text-align:center ; font-weight:bold; font-size: 13px;background-color: #f9f8f8;">Grand Total
            </td>
            <td style="font-weight:bold; font-size: 13px;background-color: #f9f8f8;">
                Rp 245.000
            </td>

            </td>
        </tr>
    </table>

</body>



</html>
