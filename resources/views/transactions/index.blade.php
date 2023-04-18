@extends('layouts.app')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Table Transaksi</h6>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                @if (session('success'))
                    <div class="d-flex justify-content-center">
                        <div class="alert alert-success text-center col-sm-4 text-dark">
                            {{ session('success') }}
                        </div>
                    </div>
                @endif

                <table class="table table-bordered text-center text-center" id="dataTable" width="100%" cellspacing="0">
                    <div class="table-responsive">
                        <thead>
                            <tr>
                                <th>Kode Transaksi</th>
                                <th>Toko</th>
                                <th>Alamat Toko</th>
                                <th>Nomer Toko</th>
                                <th>Kota</th>
                                <th>Harga Transaksi</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transactions as $transaction)
                                <tr>
                                    <td>{{ $transaction->invoice_code }}</td>
                                    <td>{{ $transaction->store_name }}</td>
                                    <td>{{ $transaction->address }}</td>
                                    <td>{{ $transaction->store_number }}</td>
                                    <td>{{ $transaction->city_branch }}</td>
                                    <td>{{ $transaction->grand_total }}</td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <a href="{{ route('transaction.show', $transaction->invoice_code) }}"
                                                class="btn btn-sm btn-warning btn-icon-split">
                                                <span class="icon text-white-50">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </span>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </div>
                </table>
            </div>
        </div>
    </div>
@endsection
