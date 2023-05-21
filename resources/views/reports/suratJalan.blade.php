<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Surat Jalan</title>
</head>

<body>
    <style>
        @media print {
            /* @page {
                size: 8.267in 5.5in;
                margin: 0;
            } */

            .header-pt {
                font-size: 24px;
                font-weight: bold;
            }
        }

        .tbl-resi {
            font-size: 16px;
            /* font-style: bold; */
        }

        .table-wrapper {
            margin: 24px, 0;
            border: 1px solid gray;
            border-top: 4px solid gray;
            padding-top: 5px;
        }

        .border-bottom {
            border-bottom: 1px solid gray;
        }

        .border-top {
            border-top: 1px solid gray;
        }

        .border-left {
            border-left: 1px solid gray;
        }

        .img-qrcode {
            position: absolute;
            top: 0;
            right: 0;
        }

        .img-logo {
            position: absolute;
            top: 10px;
            left: 20px;
        }
    </style>
    <div class="content-wrapper print resi">
        <table>
            <tr>
                <td height='100' width='400' align="center" style="display: flex; align-items: center;">
                    <img class="img-logo" src="{{ public_path('img/logo.png') }}" height="100" />
                    <div height='100' style="margin-left: 120px;margin-top:24px;" valign='center'>
                        <div class="header-pt" style="font-size: 24px">CV. SEJAHTERA BERSAMA</div>
                        <div>Jl. Raya Puger No. 6</div>
                        <div>Puger 16512, Indonesia</div>
                    </div>
                </td>
                <td valign='top'>
                    <div>
                        Puger, {{ date('d M Y', strtotime(now())) }}
                    </div>
                </td>
            </tr>
            <tr>
                <td rowspan="2">
                    <div class='' style="margin-top:24px;">
                        <span style="display: block; margin: 4px 0;">KEPADA Yth. Pemilik
                            {{ $transaction->stores->store_name }},</span>
                        <span style="display: block; margin: 4px 0;">{{ $transaction->stores->address }},</span>
                        <span style="display: block; margin: 4px 0;">{{ $transaction->stores->city_branch }}</span>
                    </div>
                    <br>
                    <br>
                    <div>Harap diterima dengan baik barang2 tsb. Dibawah ini</div>
                </td>
            <tr>
        </table>
        <div class='table-wrapper' style="margin-bottom: 24px;">
            <table style="width:100%;" cellpadding='5' cellspacing='0'>
                <tr>
                    <th class="border-bottom border-top" height="10">No</th>
                    <th class="border-bottom border-top">Kode Barang</th>
                    <th class="border-bottom border-top">Nama Barang</th>
                    <th class="border-bottom border-top">QTY</th>
                    <th class="border-bottom border-top">Sat</th>
                </tr>
                <tbody>
                    @php
                        $i = 1;
                    @endphp
                    @foreach ($transaction->transaction_details as $detail)
                        <tr class="tbl-resi">
                            <td align="center" height="10">{{ $i++ }}</td>
                            <td align="center">{{ $detail->product->product_code }}</td>
                            <td align="center">{{ $detail->product->product_name }}</td>
                            <td align="center">{{ $detail->quantity }}</td>
                            <td align="center">{{ $detail->product->unit_weight }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <table style="width:100%">
            <tr>
                <td valign="top">
                    Kode Transaksi : {{ $transaction->invoice_code }}
                </td>
                <td valign='top' style="width:20%;text-align:center;">
                    Diterima Oleh:
                    <br>
                    <br>
                    <br>
                    <br>
                    .............................
                    <br><br>Hormat Kami
                </td>
            </tr>
        </table>
    </div>
</body>

</html>
