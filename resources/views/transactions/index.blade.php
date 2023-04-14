@extends('layouts.app')

@section('content')
    <!-- DataTales Example -->
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

                @error('transaction_name')
                    <div class="d-flex justify-content-center">
                        <div class="alert alert-danger text-center col-sm-4 text-dark">
                            {{ $message }}
                        </div>
                    </div>
                @enderror
                @error('address')
                    <div class="d-flex justify-content-center">
                        <div class="alert alert-danger text-center col-sm-4 text-dark">
                            {{ $message }}
                        </div>
                    </div>
                @enderror
                @error('phone_number')
                    <div class="d-flex justify-content-center">
                        <div class="alert alert-danger text-center col-sm-4 text-dark">
                            {{ $message }}
                        </div>
                    </div>
                @enderror
                @error('sales_id')
                    <div class="d-flex justify-content-center">
                        <div class="alert alert-danger text-center col-sm-4 text-dark">
                            {{ $message }}
                        </div>
                    </div>
                @enderror
                @error('city_branch')
                    <div class="d-flex justify-content-center">
                        <div class="alert alert-danger text-center col-sm-4 text-dark">
                            {{ $message }}
                        </div>
                    </div>
                @enderror

                <table class="table table-bordered text-center text-center" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Toko</th>
                            <th>Alamat</th>
                            <th>Nomer Hp</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transactions as $transaction)
                            <tr>
                                <td>{{ $transaction->invoice_code }}</td>
                                <td>{{ $transaction->grand_total }}</td>
                                <td>{{ $transaction->store_id }}</td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        {{-- <a href="{{ route('transaction.edit', $transaction->id) }}"
                                            class="btn btn-sm btn-warning btn-icon-split">
                                            <span class="icon text-white-50">
                                                <i class="fas fa-pencil-alt"></i>
                                            </span>
                                        </a> --}}
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
