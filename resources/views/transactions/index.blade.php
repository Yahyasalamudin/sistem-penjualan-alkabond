@extends('layouts.app')

@section('content')
<h1 class="h3 mb-3 text-gray-800"> Transaksi</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Table Transaksi</h6>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                @if (session('success'))
                <div class="alert alert-success alert-dismissible" id="flash_data" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    {{ session('success') }}
                </div>
                @endif

                <table class="table table-bordered text-center text-center" id="dataTable" width="100%" cellspacing="0">
                    <div class="table-responsive">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Kode Transaksi</th>
                                <th>Toko</th>
                                <th>Alamat Toko</th>
                                <th>Nomer Toko</th>
                                <th>Kota</th>
                                <th>Harga Transaksi</th>
                                <th>Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $i = 1;
                        @endphp
                            @foreach ($transactions as $transaction)
                                <tr>
                                    <th scope="row">{{ $i++ }} </th>
                                    <td>{{ $transaction->invoice_code }}</td>
                                    <td>{{ $transaction->store_name }}</td>
                                    <td>{{ $transaction->address }}</td>
                                    <td>{{ $transaction->store_number }}</td>
                                    <td>{{ $transaction->city_branch }}</td>
                                    <td>{{ $transaction->grand_total }}</td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <a href="{{ route('transaction.show', $transaction->invoice_code) }}"
                                                class="btn btn-sm btn-success ">
                                                Detail
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
