@extends('layouts.app')

@section('content')
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Table Product</h6>

            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                Tambah Product
            </button>
        </div>

        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('product.store') }}" method="post">
                        @csrf
                        <div class="modal-body">
                            <label for="product_name">Nama Produk</label>
                            <select class="form-control mb-3" name="product_name" id="product_name">
                                <option value="">- Pilih Nama/Jenis Produk -</option>
                                @foreach ($type as $t)
                                    <option value="{{ $t->type }}">{{ $t->type }}</option>
                                @endforeach
                            </select>

                            <label for="product_brand">Merk Produk</label>
                            <input class="form-control mb-3" type="text" name="product_brand" id="product_brand"
                                placeholder="Masukkan Nama Merk">

                            <label for="unit_weight">Satuan Berat</label>
                            <input type="text" class="form-control" name="unit_weight" id="unit_weight"
                                placeholder="Masukkan Berat dan Satuan Berat">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
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

                @error('product_name')
                    <div class="d-flex justify-content-center">
                        <div class="alert alert-danger text-center col-sm-4 text-dark">
                            {{ $message }}
                        </div>
                    </div>
                @enderror
                @error('product_brand')
                    <div class="d-flex justify-content-center">
                        <div class="alert alert-danger text-center col-sm-4 text-dark">
                            {{ $message }}
                        </div>
                    </div>
                @enderror
                @error('unit_id')
                    <div class="d-flex justify-content-center">
                        <div class="alert alert-danger text-center col-sm-4 text-dark">
                            {{ $message }}
                        </div>
                    </div>
                @enderror
                @error('unit_weight')
                    <div class="d-flex justify-content-center">
                        <div class="alert alert-danger text-center col-sm-4 text-dark">
                            {{ $message }}
                        </div>
                    </div>
                @enderror
                <table class="table table-bordered text-center text-center" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Kode Produk</th>
                            <th>Nama Produk</th>
                            <th>Merk Produk</th>
                            <th>Satuan Berat</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $p)
                            <tr>
                                <td>{{ $p->product_code }}</td>
                                <td>{{ $p->product_name }}</td>
                                <td>{{ $p->product_brand }}</td>
                                <td>{{ $p->unit_weight }}</td>
                                <td>
                                    {{-- <div class="d-flex justify-content-center"> --}}
                                    {{-- <a href="{{ route('product.edit', $p->id) }}" class="btn btn-warning btn-icon-split">
                                            <span class="icon text-white-50">
                                                <i class="fas fa-pencil-alt"></i>
                                            </span>
                                            <span class="text">Edit Product</span>
                                        </a> --}}
                                    <form action="{{ route('product.destroy', $p->id) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-sm btn-danger btn-icon-split">
                                            <span class="icon text-white-50">
                                                <i class="fas fa-trash"></i>
                                            </span>
                                            {{-- <span class="text">Hapus Product</span> --}}
                                        </button>
                                    </form>
                                    {{-- </div> --}}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
