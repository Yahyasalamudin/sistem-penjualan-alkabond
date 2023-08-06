<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pendapatan</title>
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

    @php
        use Illuminate\Support\Carbon;
    @endphp

    <table width="500" border="0">
        <tr>
            <td class="title">
                Laporan Pendapatan
            </td>
        </tr>
    </table>
    <table width="500" border="0">
        <tr>
            <td class="tanggal">
                {{-- Dari tanggal {{ Carbon::parse($tgl_awal)->locale('id')->isoFormat('D MMMM Y') }} Sampai Tanggal
                {{ Carbon::parse($tgl_akhir)->locale('id')->isoFormat('D MMMM Y') }} --}}
            </td>
        </tr>
    </table>
    <br><br>
    <table id="table">
        <tr>
            <th>No</th>
            <th>Tahun</th>
            <th>Bulan</th>
            <th>Jumlah Transaksi</th>
            <th>Penjualan Kotor</th>
            <th>Penjualan Bersih</th>
        </tr>
        @php
            $i = 1;
            setlocale(LC_TIME, 'ID_id');
        @endphp
        @foreach ($transactions->groupBy('year') as $year => $yearTransactions)
            @foreach ($yearTransactions as $index => $transaction)
                <tr>
                    @if ($index === 0)
                        <td rowspan="{{ $yearTransactions->count() }}">{{ $i++ }}</td>
                        <td rowspan="{{ $yearTransactions->count() }}">{{ $year }}</td>
                    @endif
                    <td>{{ Carbon::createFromFormat('m', $transaction->month)->formatLocalized('%B') }}</td>
                    <td>{{ $transaction->transaction_count }}</td>
                    <td>Rp {{ number_format($transaction->transaction_gross) }}</td>
                    <td>Rp {{ number_format($transaction->transaction_net) }}</td>
                </tr>
            @endforeach
        @endforeach

        <tr>
            <td scope="row" colspan="4"
                style="text-align:center ; font-weight:bold; font-size: 13px;background-color: #f9f8f8;">Grand Total
            </td>
            <td style="font-weight:bold; font-size: 13px;background-color: #f9f8f8;">
                Rp {{ number_format($transactions->sum('transaction_gross')) }}
            </td>
            <td style="font-weight:bold; font-size: 13px;background-color: #f9f8f8;">
                Rp {{ number_format($transactions->sum('transaction_net')) }}
            </td>
        </tr>
    </table>

</body>



</html>
