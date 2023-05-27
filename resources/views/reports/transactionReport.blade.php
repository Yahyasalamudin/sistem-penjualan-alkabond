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
                Dari tanggal {{ date('d-F-Y', strtotime($tgl_awal)) }} Sampai Tanggal
                {{ date('d-F-Y', strtotime($tgl_akhir)) }}
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
            <th>Total Transaksi</th>
        </tr>
        @php
            $i = 1;
        @endphp
        @foreach ($transactions as $transaction)
            <tr>
                <td>{{ $i++ }}</td>
                <td>{{ $transaction->invoice_code }}</td>
                <td>{{ $transaction->stores->store_name }}</td>
                <td>{{ $transaction->sales->sales_name }}</td>
                <td>{{ $transaction->payment_method != null ? $transaction->payment_method : 'Belum Dibayar' }}
                </td>
                <td>{{ $transaction->status }}</td>
                <td>{{ $transaction->delivery_status }}</td>
                <td>{{ date('d F Y', strtotime($transaction->created_at)) }}</td>
                <td>Rp {{ number_format($transaction->grand_total) }}</td>
            </tr>
        @endforeach


        <tr>
            <td scope="row" colspan="8"
                style="text-align:center ; font-weight:bold; font-size: 13px;background-color: #f9f8f8;">Grand Total
            </td>
            <td style="font-weight:bold; font-size: 13px;background-color: #f9f8f8;">
                Rp {{ number_format($transactions->sum('grand_total')) }}
            </td>
        </tr>
    </table>

</body>



</html>
