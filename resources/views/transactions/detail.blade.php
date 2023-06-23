@extends('layouts.app')

@section('content')
    @if ($transaction->delivery_status != 'proccess' && $transaction->delivery_status != 'sent')
        <div class="row py-4">
            <div class="col">
                <h1 class="h3 mb-2 text-gray-800">Detail Pesanan</h1>
            </div>
        </div>
    @endif

    @if ($transaction->delivery_status == 'proccess' || $transaction->delivery_status == 'sent')
        <div class="row py-4 mx-1 d-flex flex-row justify-content-between">
            <h1 class="h3 mb-2 text-gray-800">Detail Pesanan</h1>
            {{-- <h1 class="h3 mb-2 text-gray-800">{{ $transaction->invoice_code }}</h1> --}}
            <a href="{{ route('suratjalan', $transaction->invoice_code) }}" class="btn btn-info mb-1" target="_blank">
                Cetak Surat Jalan
            </a>
        </div>
    @endif

    {{-- <div class="py-3 d-flex flex-row justify-content-between">
        <h1 class="h3 mb-2 text-gray-800"> Pembayaran</h1>
        <h1 class="h3 mb-2 text-gray-800">{{ $transaction->invoice_code }}</h1>
    </div> --}}

    <div class="row">
        <div class="col-md-8 col-lg-12">
            <form action="" method="post" id="registration">
                <nav>
                    <hr>
                    <div class="nav nav-pills nav-fill mb-4 " id="nav-tab" role="tablist">
                        <a class="nav-link active" id="step1-tab" data-bs-toggle="tab" href="#step1">Detail Pesanan</a>

                        <a class="nav-link  " id="step2-tab" data-bs-toggle="tab" href="#step2">Pembayaran</a>

                        @if (isset($transaction->payment_method))
                            <a class="nav-link" id="step3-tab" data-bs-toggle="tab" href="#step3">Return Pesanan</a>
                        @endif
                    </div>
                    <hr>
                </nav>
                <div class="tab-content py-4">
                    <div class="tab-pane fade show active" id="step1">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="card shadow-tabl mb-4 crddet mx-2 col">
                                    <div class="card-header btcolor py-3 ">
                                        <h6 class="m-0 font-weight-bold text-white">Detail Transaksi</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped" width="100%" cellspacing="0">
                                                <tbody>
                                                    <tr>
                                                        <td>Kode Transaksi</td>
                                                        <td>{{ $transaction->invoice_code }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Nama Sales</td>
                                                        <td>{{ $transaction->sales->sales_name }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Payment Method</td>
                                                        <td>
                                                            @if (empty($transaction->payment_method))
                                                                -
                                                            @else
                                                                {{ $transaction->payment_method }}
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Status</td>
                                                        <td>
                                                            @if ($transaction->status == 'unpaid')
                                                                Belum Dibayar
                                                            @elseif ($transaction->status == 'partial')
                                                                Dicicil
                                                            @else
                                                                Lunas
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Pengiriman</td>
                                                        <td>
                                                            @if ($transaction->delivery_status == 'unsent')
                                                                Belum Dikirim
                                                            @elseif ($transaction->delivery_status == 'proccess')
                                                                Dalam Perjalanan
                                                            @else
                                                                Telah Terkirim
                                                            @endif
                                                        </td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="card shadow  mb-4 crddet col">
                                    <div class="card-header btcolor py-3 ">
                                        <h6 class="m-0 font-weight-bold text-white">Detail Toko</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped" width="100%" cellspacing="0">
                                                <tbody>
                                                    <tr>
                                                        <td>Nama Toko</td>
                                                        <td>{{ $transaction->stores->store_name }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Alamat</td>
                                                        <td>{{ $transaction->stores->address }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Nomor Toko</td>
                                                        <td>{{ $transaction->stores->store_number }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Kota</td>
                                                        <td>{{ $transaction->stores->city_branch }}</td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="card shadow mb-4 crddet col">
                                <div class="card-header btcolor py-3 ">
                                    <h6 class="m-0 font-weight-bold text-white">Detail Pesanan</h6>
                                </div>

                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>Kode Barang</th>
                                                    <th>Nama Barang </th>
                                                    <th>Berat </th>
                                                    <th>Harga per PCS</th>
                                                    <th>Jumlah</th>
                                                    <th>SubTotal</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($transaction->transaction_details as $detail)
                                                    <tr>
                                                        <td>{{ $detail->product->product_code }}</td>
                                                        <td>{{ $detail->product->product_name }}</td>
                                                        <td>{{ $detail->product->unit_weight }}</td>
                                                        <td>Rp {{ number_format($detail->price) }}</td>
                                                        <td>{{ $detail->quantity }}</td>
                                                        <td>Rp {{ number_format($detail->subtotal) }}</td>
                                                    </tr>
                                                @endforeach
                                                <tr>
                                                    <td scope="row" colspan="5" class="grnd">Grand Total
                                                    </td>
                                                    <td class="grnd1">
                                                        Rp {{ number_format($transaction->grand_total) }}
                                                    </td>

                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Pembayaran --}}
                    <div class="tab-pane fade" id="step2">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="card shadow-tabl mb-4 crddet mx-2 col-md-6">
                                    <div class="card-header btcolor py-3 d-flex flex-row justify-content-between">
                                        <h6 class="mt-0 font-weight-bold text-white"> Riwayat Pembayaran</h6>
                                        <h6 class=" mt-0 font-weight-bold text-white">{{ $transaction->invoice_code }}</h6>
                                    </div>

                                    <div class="card-body">
                                        <div class="table-responsive">
                                            @if ($transaction->payments->sum('total_pay') == 0)
                                                <div class="mt-4">
                                                    <div
                                                        class="d-flex
                                                    justify-content-center">
                                                        Pesanan Masih Belum Dibayar
                                                    </div>
                                                </div>
                                            @else
                                                <table class="table table-striped table-bordered" width="100%"
                                                    cellspacing="0">
                                                    <thead>
                                                        <tr>
                                                            <th>No.</th>
                                                            <th>Tanggal Bayar</th>
                                                            <th>Pembayaran</th>
                                                        </tr>
                                                    </thead>
                                                    @php
                                                        $i = 1;
                                                    @endphp
                                                    <tbody>
                                                        @foreach ($transaction->payments as $payment)
                                                            <tr>
                                                                <th scope="row">{{ $i++ }}</th>
                                                                <td>{{ date('d F Y', strtotime($payment->created_at)) }}
                                                                </td>
                                                                <td>-Rp {{ number_format($payment->total_pay) }}</td>
                                                            </tr>
                                                        @endforeach

                                                        <tr>
                                                            <td scope="row" colspan="2" class="grnd">Total
                                                            </td>
                                                            <td class="grnd1">
                                                                -Rp
                                                                {{ number_format($transaction->payments->sum('total_pay')) }}
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-5 mb-4 hcb">
                                    <div class="card border-success shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="text-xs text-center font-weight-bold mb-5">
                                                        <p class="jumlh">
                                                            Total Sisa Jumlah Cicilan
                                                        </p>
                                                        <h2 class="total">
                                                            Rp {{ number_format($transaction->remaining_pay) }}
                                                        </h2>
                                                    </div>

                                                    <h6 class="mb-0 text-center font-weight-bold text-gray-800">Total
                                                        Pembayaran : Rp {{ number_format($transaction->grand_total) }}</h6>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if (isset($transaction->payment_method))
                        <div class="tab-pane fade" id="step3">
                            <div class="row justify-content-center">
                                <div class="card shadow-tabl mb-4 crddet mx-2 col-md-12">
                                    <div class="card-header btcolor py-3 d-flex flex-row justify-content-between">
                                        <h6 class="m-0 font-weight-bold text-white">Return Pesanan</h6>
                                        <h6 class=" mt-0 font-weight-bold text-white">
                                            {{ $transaction->invoice_code }}</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered text-center" widht="100"
                                                cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th>Kode Produk</th>
                                                        <th>Nama Produk</th>
                                                        <th>Product Saat Ini</th>
                                                        <th>Jumlah Return</th>
                                                        <th>Keterangan Return</th>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    @foreach ($transaction->transaction_details as $detail)
                                                        @if (isset($detail->return_id))
                                                            <tr>
                                                                <td>{{ $detail->product->product_code }}</td>
                                                                <td>{{ $detail->product->product_name }}</td>
                                                                <td>{{ $detail->quantity }}</td>
                                                                <td>{{ $detail->product_return->return }}</td>
                                                                <td>{{ $detail->product_return->description_return }}</td>
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        {{-- <div class="table-responsive">
                                            <table class="table table-striped table-bordered" width="100%"
                                                cellspacing="0">
                                                <thead>
                                                    <th>Nama Produk</th>
                                                    <th>Jumlah Return</th>
                                                    <th>Jumlah Product</th>
                                                    <th>Keterangan Return</th>
                                                </thead>
                                                @foreach ($transaction->transaction_details as $detail)
                                                    @if (isset($detail->return_id))
                                                    <tbody>
                                                        <tr>
                                                            <td>{{ $detail->product->product_name }}</td>
                                                        </tr>
                                                    </tbody>
                                                    @endif
                                                @endforeach
                                            </table>
                                        </div> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                {{-- <div class="row justify-content-between">
            <div class="col-auto"><button type="button" class="btn btn-secondary" data-enchanter="previous">Previous</button></div>
            <div class="col-auto">
              <button type="button" class="btn btn-primary" data-enchanter="next">Next</button>
              <button type="submit" class="btn btn-primary" data-enchanter="finish">Finish</button>
            </div>
          </div> --}}
            </form>
        </div>
    </div>
@endsection
