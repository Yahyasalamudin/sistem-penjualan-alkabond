@extends('layouts.app')

@section('content')
    <h1 class="h3 mb-3 text-gray-800">Laporan Barang Terjual</h1>
    @if (session('success'))
        <div class="alert alert-success alert-dismissible" id="flash_data" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible" id="flash_data" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            {{ session('error') }}
        </div>
    @endif

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Laporan Barang Terjual</h6>
        </div>

        <div class="card-body">
            <form action="{{ route('report.bestSellerProductReport') }}">
                <div class="d-inline-flex flex-column">
                    <div class="form-group mr-4">
                        <label for="start_month">Bulan</label>
                        <div class="d-flex">
                            <select class="form-control mb-3 col-md-6" name="start_month" id="start_month">
                                <option value="">- Pilih Bulan -</option>
                                @foreach ($months as $month)
                                    <option @if (request('start_month') == $month) selected @endif value="{{ $month }}">
                                        {{ $month }}</option>
                                @endforeach
                            </select>
                            <span class="mx-3 mt-2">Sampai</span>
                            <select class="form-control mb-3 col-md-6" name="end_month" id="end_month">
                                <option value="">- Pilih Bulan -</option>
                                @foreach ($months as $month)
                                    <option @if (request('end_month') == $month) selected @endif value="{{ $month }}">
                                        {{ $month }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group mr-4">
                        <label for="product_type">Jenis</label>
                        <div class="d-flex">
                            <select class="form-control mr-4" name="product_type" id="product_type">
                                <option value="">- Pilih Jenis -</option>
                                @foreach ($productTypes as $data)
                                    <option @if (request('product_type') == $data->type) selected @endif value="{{ $data->type }}">
                                        {{ $data->type }}</option>
                                @endforeach
                            </select>
                            <button type="submit" class="btn btn-primary align-self-center">Filter</button>
                        </div>
                    </div>
                </div>
            </form>
            <div class="row">
                <div class="col">
                    <div class="table-responsive">
                        <a href="{{ route('report.bestSellerProductReport', array_merge(request()->all(), ['excel' => true])) }}"
                            class="btn btn-success btn-sm my-3">
                            <i class="far fa-file-excel mr-1"></i> Excel
                        </a>
                        <a href="{{ route('report.bestSellerProductReport', array_merge(request()->all(), ['pdf' => true])) }}"
                            class="btn btn-danger btn-sm my-3" target="_blank">
                            <i class="far fa-file-pdf mr-1"></i> PDF
                        </a>
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <th class="text-center align-middle">No</th>
                                <th class="text-center align-middle">Kode Produk</th>
                                <th class="text-center align-middle">Nama Produk</th>
                                <th class="text-center align-middle">Merk Produk</th>
                                <th class="text-center align-middle">Satuan Berat</th>
                                <th class="text-center align-middle">Total Terjual</th>
                            </thead>
                            <tbody>
                                @php
                                    $i = 1;
                                @endphp
                                @foreach ($products as $product)
                                    <tr>
                                        <td class="text-center align-middle">
                                            {{ $i++ }}
                                        </td>
                                        <td class="text-center align-middle">{{ $product->product_code }}</td>
                                        <td class="text-center align-middle">{{ $product->product_name }}</td>
                                        <td class="text-center align-middle">{{ $product->product_brand }}</td>
                                        <td class="text-center align-middle">{{ $product->unit_weight }}</td>
                                        <td class="text-center align-middle">{{ $product->total_quantity }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
