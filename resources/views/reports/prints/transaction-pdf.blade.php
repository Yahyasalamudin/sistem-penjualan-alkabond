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
            text-align: center;
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
            /* text-align: center; */
            background-color: #538b82;
            color: white;
            font-size: 13px;
        }
    </style>
</head>

<body>

    @php
        use Illuminate\Support\Carbon;
    @endphp

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
                Dari tanggal {{ Carbon::parse($start_date)->locale('id')->isoFormat('D MMMM Y') }} Sampai Tanggal
                {{ Carbon::parse($end_date)->locale('id')->isoFormat('D MMMM Y') }}
            </td>
        </tr>
    </table>
    <br><br>
    <div class="center-content" style="margin: 0 auto;">
        <table id="table" style="margin-right: 2em;">
            <tr>
                <th width="5%">No</th>
                <th width="10%">Invoice Code</th>
                <th width="15%">Nama Toko</th>
                <th width="15%">Nama Sales</th>
                <th width="10%">Metode Pembayaran</th>
                <th width="10%">Status Pembayaran</th>
                <th width="10%">Status Pengiriman</th>
                <th width="10%">Tanggal Transaksi</th>
                <th width="15%">Total Transaksi</th>
            </tr>
            @php
                $i = 1;
            @endphp
            @foreach ($transactions as $transaction)
                <tr>
                    <td>
                        {{ $i++ }}
                    </td>
                    <td>
                        {{ $transaction->invoice_code }}
                    </td>
                    <td>
                        {{ $transaction->stores->store_name }}
                    </td>
                    <td>
                        {{ $transaction->sales->sales_name }}
                    </td>
                    <td>
                        {{ $transaction->payment_method != null ? $transaction->payment_method : '-' }}
                    </td>
                    <td>
                        @if ($transaction->status === 'paid')
                            Dibayar
                        @elseif ($transaction->status === 'unpaid')
                            Belum Dibayar
                        @elseif ($transaction->status === 'partial')
                            Dicicil
                        @endif
                    </td>
                    <td>
                        @if ($transaction->delivery_status === 'unsent')
                            Belum Dikirim
                        @elseif($transaction->delivery_status === 'proccess')
                            Proses
                        @else
                            Dikirim
                        @endif
                    </td>
                    <td>
                        {{ Carbon::parse($transaction->created_at)->isoFormat('D MMMM Y') }}
                    </td>
                    <td>
                        Rp {{ number_format($transaction->grand_total) }}
                    </td>
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
    </div>
</body>

</html>
