@extends('layouts.app')

@section('content')
    <h1 class="h3 mb-3 text-gray-800">Data Produk</h1>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible" id="flash_data" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            {{ session('success') }}
        </div>
    @endif

    @error('product_code')
        <div class="alert alert-danger alert-dismissible" id="flash_data" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            {{ $message }}
        </div>
    @enderror
    @error('product_name')
        <div class="alert alert-danger alert-dismissible" id="flash_data" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            {{ $message }}
        </div>
    @enderror
    @error('product_brand')
        <div class="alert alert-danger alert-dismissible" id="flash_data1" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            {{ $message }}
        </div>
    @enderror
    @error('unit_id')
        <div class="alert alert-danger alert-dismissible" id="flash_data2" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            {{ $message }}
        </div>
    @enderror
    @error('unit_weight')
        <div class="alert alert-danger alert-dismissible" id="flash_data3" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            {{ $message }}
        </div>
    @enderror

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Table Produk</h6>
            <button type="button" class="btn btcolor text-white" data-toggle="modal" data-target="#createModal">
                Tambah Produk
            </button>
        </div>

        <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createModalLabel">Tambah Produk</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('product.store') }}" method="post">
                        @csrf
                        <div class="modal-body">
                            <label for="product_code">Kode Produk</label>
                            <input class="form-control mb-3" type="text" name="product_code" id="product_code"
                                placeholder="Masukkan Kode Produk">

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
            <div class="mb-3">
                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#importModal">
                    <i class="fas fa-file-upload"></i> Import
                </button>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered text-center text-center" id="dataTable" width="100%"
                    cellspacing="0">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Kode Produk</th>
                            <th>Nama Produk</th>
                            <th>Merk Produk</th>
                            <th>Satuan Berat</th>
                            <th>Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = 1;
                        @endphp
                        @foreach ($products as $p)
                            <tr>
                                <th scope="row">{{ $i++ }} </th>
                                <td>{{ $p->product_code }}</td>
                                <td>{{ $p->product_name }}</td>
                                <td>{{ $p->product_brand }}</td>
                                <td>{{ $p->unit_weight }}</td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <button class="btn btn-sm btn-success" data-toggle="modal"
                                            data-target="#editModal{{ $p->id }}">Edit
                                        </button>
                                        <form action="{{ route('product.destroy', $p->id) }}" method="post">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-sm btn-danger ml-3">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>

                            <!-- modal edit -->
                            <div class="modal fade" id="editModal{{ $p->id }}" tabindex="-1"
                                aria-labelledby="editModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editModalLabel">Edit Produk</h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="{{ route('product.update', $p->id) }}" method="post">
                                            @csrf
                                            @method('put')
                                            <div class="modal-body">
                                                <label for="product_code">Kode Produk</label>
                                                <input class="form-control mb-3" type="text" name="product_code"
                                                    id="product_code" placeholder="Masukkan Kode Produk"
                                                    value="{{ $p->product_code }}">

                                                <label for="product_name">Nama Produk</label>
                                                <select class="form-control mb-3" name="product_name" id="product_name">
                                                    <option value="">- Pilih Nama/Jenis Produk -</option>
                                                    @foreach ($type as $t)
                                                        <option value="{{ $t->type }}"
                                                            {{ $t->type == $p->product_name ? 'selected' : '' }}>
                                                            {{ $t->type }}
                                                        </option>
                                                    @endforeach
                                                </select>

                                                <label for="product_brand">Merk Produk</label>
                                                <input class="form-control mb-3" type="text" name="product_brand"
                                                    id="product_brand" placeholder="Masukkan Nama Merk"
                                                    value="{{ $p->product_brand }}">

                                                <label for="unit_weight">Satuan Berat</label>
                                                <input type="text" class="form-control" name="unit_weight"
                                                    id="unit_weight" placeholder="Masukkan Berat dan Satuan Berat"
                                                    value="{{ $p->unit_weight }}">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-primary">Simpan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="importModalLabel">Import Produk</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="post" action="{{ route('import.product') }}" enctype="multipart/form-data">
                        <div class="modal-body">
                            @csrf
                            <div class="card card-outline card-primary mb-3">
                                <div class="card-header">
                                    <h5 class="modal-title">Petunjuk :</h5>
                                </div>
                                <div class="card-body">
                                    <ul>
                                        <li>Kolom 1 = Kode Produk</li>
                                        <li>Kolom 2 = Jenis Produk</li>
                                        <li>Kolom 3 = Merk Produk</li>
                                        <li>Kolom 4 = Satuan Berat</li>
                                    </ul>
                                </div>
                            </div>
                            <label>Pilih File</label>
                            <div class="form-group">
                                <input type="file" name="file" required="required">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Import</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
