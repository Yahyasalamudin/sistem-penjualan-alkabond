<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="description">
    <meta content="" name="keywords">
    <title> Delivery Order</title>

    <!-- Favicons -->
    <link href="{{ public_path('img/logo.png') }}" rel="icon">
    <link href="{{ public_path('img/logo.png') }}" rel="icon">

    <!-- Vendor CSS Files -->

    <style type="text/css">
        body {
            font-family: arial;
        }

        .rangkasurat {
            /* width: 980px; */
            margin: 0 auto;
            background-color: #fff;
            height: 500px;
            padding: 20px;
        }

        #table {
            font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
            table-layout: fixed
        }

        #table td,
        #table th {
            border: 1px solid #ddd;
            padding: 8px;
            font-size: 13px;

        }

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

        .tengah {
            text-align: center;
        }

        .kiri {
            text-align: left;
        }

        .kanan {
            text-align: right;
        }

        .jarak {
            font-size: 15px;
        }
    </style>
</head>

<body>
    <div class="rangkasurat">

        <table width="100%">

            <table>
                <tr class="jarak">
                    <td>
                        <p style="font-size:16px;font-weight:bold;">DELIVERY ORDER</p>
                    </td>
                    <td width="150"></td>
                    <td>
                        <p style="font-size:16px;font-weight:bold;">CV. SEJAHTERA BERSAMA</p>
                    </td>
                    <td></td>
                </tr>
            </table>
            {{-- <div style="display: flex; margin-top: 24px;">
                <div style="display: inline-block;">
                    Kepada,
                    <p style="margin: 0;">{{ $transaction->stores->store_name }}</p>
                </div>
                <div style="display: inline-block; margin-left: 256px;">
                    <p style="margin: 0;">Status : {{ $transaction->delivery_status }}</p>
                    <p style="margin: 0;">Invoice Code : {{ $transaction->invoice_code }}</p>
                    <p style="margin: 0;">Tanggal</p>
                    <p style="margin: 0;">Nomor Telepon</p>
                </div>
            </div> --}}
            <table>
                <tr class="jarak">
                    <td>Kepada,
                    </td>
                    <td width="38"></td>
                    <td width="80">Status</td>
                    <td>:
                        @if ($transaction->delivery_status == 'sent')
                            Dikirim
                        @elseif ($transaction->delivery_status == 'unsent')
                            Belum Dikirim
                        @else
                            Sedang Diproses
                        @endif
                    </td>
                </tr>
                <tr class="jarak">
                    <td>{{ $transaction->stores->store_name }}
                    </td>
                    <td width="38"></td>
                    <td width="80">Invoice Code</td>
                    <td>: {{ $transaction->invoice_code }}
                    </td>
                </tr>
                <tr class="jarak">
                    <td>
                        {{-- {{ $transaction->stores->address }} --}}
                    </td>
                    <td width="38"></td>
                    <td width="40">Tanggal</td>
                    <td>{{ ' : ' . date('d M Y', $transaction->delivery_status == 'sent' ? strtotime($transaction->sent_at) : strtotime(now())) }}
                    </td>
                </tr>
                <tr class="jarak">
                    <td>
                    </td>
                    <td></td>
                    <td width="40">Phone</td>
                    <td>: 08937393303
                    </td>
                </tr>

                <tr class="jarak">
                    <td>Dikirim Ke
                    </td>
                    <td></td>
                    <td width="40"></td>
                    <td>
                    </td>
                </tr>
                <tr class="jarak">
                    <td>{{ $transaction->stores->address }}
                    </td>
                    <td></td>
                    <td width="40"></td>
                    <td>
                    </td>
                </tr>
            </table>
        </table>
        <br><br>
        <table style="width:100%;" id="table" cellpadding='5' cellspacing='0'>
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
        <br><br><br>
        <table>
            <tr class="jarak tengah">
                <td width="120">Dibuat</td>
                <td width="120">Diperiksa</td>
                <td width="120">Dikirim</td>
                <td width="120">Penerima </td>
            </tr>
            <br><br><br><br><br>
            <tr class="jarak tengah">
                <td>{{ auth()->user()->name }}</td>
                <td>(..................................)</td>
                <td>(..................................)</td>
                <td>{{ $transaction->stores->store_name }}</td>
            </tr>
            <br>
            <tr class="jarak tengah ">
                <td>Admin</td>
                <td>Gudang</td>
                <td>Sopir</td>
                <td></td>
            </tr>
        </table>
    </div>
</body>

</html>
