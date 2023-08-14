<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Barang Terjual</title>
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
                Laporan Barang Terjual
            </td>
        </tr>
    </table>
    <table width="500" border="0">
        <tr>
            <td class="tanggal">
                Dari Bulan {{ Carbon::parse($start_month)->locale('id')->isoFormat('MMMM') }} Sampai
                {{ Carbon::parse($end_month)->locale('id')->isoFormat('MMMM') }}
            </td>
        </tr>
    </table>
    <br><br>
    <div class="center-content" style="margin: 0 auto;">
        <table id="table" style="margin-right: 2em;">
            <tr>
                <th width="5%">No</th>
                <th width="10%">Kode Produk</th>
                <th width="10%">Nama Produk</th>
                <th width="10%">Merk Produk</th>
                <th width="10%">Satuan Berat</th>
                <th width="10%">Total Terjual</th>
            </tr>
            @php
                $i = 1;
            @endphp
            @foreach ($products as $product)
                <tr>
                    <td>
                        {{ $i++ }}
                    </td>
                    <td>
                        {{ $product->product_code }}
                    </td>
                    <td>
                        {{ $product->product_name }}
                    </td>
                    <td>
                        {{ $product->product_brand }}
                    </td>
                    <td>
                        {{ $product->unit_weight }}
                    </td>
                    <td>
                        {{ $product->total_quantity }}
                    </td>
                </tr>
            @endforeach

        </table>
    </div>
</body>

</html>
