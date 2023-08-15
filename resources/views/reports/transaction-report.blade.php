@php
    use Carbon\Carbon;
    
    Carbon::setLocale('id');
@endphp
@extends('layouts.app')
@push('datatables')
    "ordering": false,
    "dom": 'Bfrtip',
    "paging": false,
    "searching": false
@endpush
@section('content')
    <div class="row">
        <div class="col-lg-12 mt-3 mb-5">
            <div class="col-xl-12 col-lg-6">
                <div class="card shadow mb-4 crd-edit">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Laporan Transaksi</h6>
                    </div>
                    <div class="card-body">
                        <div class="row-lg-12">
                            <form action="" method="get">
                                <div class="col-md-12">
                                    <div class="col-xl-12 col-lg-6">
                                        <div class="form-group row mb-4">
                                            <div class="col">
                                                <label for="start_date">Tanggal Awal</label>
                                                <input type="date" name="start_date" id="start_date" class="form-control"
                                                    value="{{ request('start_date') ?: now()->format('Y-m-d') }}" />
                                            </div>

                                            <div class="col">
                                                <label for="end_date">Tanggal Akhir</label>
                                                <input type="date" name="end_date" id="end_date" class="form-control"
                                                    value="{{ request('end_date') ?: now()->format('Y-m-d') }}" />
                                            </div>

                                            <div class="col">
                                                <label for="status">Pilih Status</label>
                                                <select name="status" id="status" class="form-control">
                                                    <option value="" {{ request('status') === '' ? 'selected' : '' }}>
                                                        Semua
                                                    </option>
                                                    <option value="unsent"
                                                        {{ request('status') === 'unsent' ? 'selected' : '' }}>
                                                        Pre-Order
                                                    </option>
                                                    <option
                                                        value="process"{{ request('status') === 'process' ? 'selected' : '' }}>
                                                        Proses
                                                    </option>
                                                    <option value="sent"
                                                        {{ request('status') === 'sent' ? 'selected' : '' }}>
                                                        Dikirim
                                                    </option>
                                                    <option value="partial"
                                                        {{ request('status') === 'partial' ? 'selected' : '' }}>
                                                        Dicicil
                                                    </option>
                                                    <option value="paid"
                                                        {{ request('status') === 'paid' ? 'selected' : '' }}>
                                                        Selesai
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="col">
                                                <label for="store_id">Pilih Toko</label>
                                                <select name="store_id" id="store_id" class="form-control">
                                                    <option value=""
                                                        {{ request('store_id') == '' ? 'selected' : '' }}>
                                                        Semua Toko
                                                    </option>
                                                    @foreach ($stores as $store)
                                                        <option value="{{ $store->id }}"
                                                            {{ request('store_id') == $store->id ? 'selected' : '' }}>
                                                            {{ $store->store_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-1 mt-3">
                                                <button class="btn btn-primary mt-3">Filter</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="table-responsive">
                                    <a href="{{ route('report.transaction', array_merge(request()->all(), ['excel' => true])) }}"
                                        class="btn btn-success btn-sm">
                                        <i class="far fa-file-excel mr-1"></i> Excel
                                    </a>
                                    <a href="{{ route('report.transaction', array_merge(request()->all(), ['pdf' => true])) }}"
                                        class="btn btn-danger btn-sm" target="_blank">
                                        <i class="far fa-file-pdf mr-1"></i> PDF
                                    </a>
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <th class="text-center align-middle">No</th>
                                            <th class="text-center align-middle">Invoice Code</th>
                                            <th class="text-center align-middle">Nama Toko</th>
                                            <th class="text-center align-middle">Nama Sales</th>
                                            <th class="text-center align-middle">Metode Pembayaran</th>
                                            <th class="text-center align-middle">Status Pembayaran</th>
                                            <th class="text-center align-middle">Status Pengiriman</th>
                                            <th class="text-center align-middle">Tanggal Transaksi</th>
                                            <th class="text-center align-middle">Total Transaksi</th>
                                        </thead>
                                        <tbody>
                                            @php
                                                $i = 1;
                                            @endphp
                                            @foreach ($transactions as $transaction)
                                                <tr>
                                                    <td class="text-center align-middle">
                                                        {{ $i++ }}
                                                    </td>
                                                    <td class="text-center align-middle">
                                                        {{ $transaction->invoice_code }}
                                                    </td>
                                                    <td class="text-center align-middle">
                                                        {{ $transaction->stores->store_name }}
                                                    </td>
                                                    <td class="text-center align-middle">
                                                        {{ $transaction->sales->sales_name }}
                                                    </td>
                                                    <td class="text-center align-middle">
                                                        {{ $transaction->payment_method != null ? $transaction->payment_method : '-' }}
                                                    </td>
                                                    <td class="text-center align-middle">
                                                        @if ($transaction->status === 'paid')
                                                            Dibayar
                                                        @elseif ($transaction->status === 'unpaid')
                                                            Belum Dibayar
                                                        @elseif ($transaction->status === 'partial')
                                                            Dicicil
                                                        @endif
                                                    </td>
                                                    <td class="text-center align-middle">
                                                        @if ($transaction->delivery_status === 'unsent')
                                                            Belum Dikirim
                                                        @elseif($transaction->delivery_status === 'proccess')
                                                            Proses
                                                        @else
                                                            Dikirim
                                                        @endif
                                                    </td>
                                                    <td class="text-center align-middle">
                                                        {{ Carbon::parse($transaction->created_at)->isoFormat('D MMMM Y') }}
                                                    </td>
                                                    <td class="text-center align-middle">
                                                        Rp {{ number_format($transaction->grand_total) }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
