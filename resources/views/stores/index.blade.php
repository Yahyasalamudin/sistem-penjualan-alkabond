@extends('layouts.app')

@section('content')
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Table Toko</h6>

            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                Tambah Toko
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
                    <form action="{{ route('store.store') }}" method="post">
                        @csrf
                        <div class="modal-body">
                            <label for="store_name">Nama Toko</label>
                            <input class="form-control mb-3" type="text" name="store_name" id="store_name"
                                placeholder="Masukkan Nama Toko">

                            <label for="address">Alamat Toko</label>
                            <input class="form-control mb-3" type="text" name="address" id="address"
                                placeholder="Masukkan Alamat Toko">

                            <label for="store_number">Nomer Hp</label>
                            <input class="form-control mb-3" type="text" name="store_number" id="store_number"
                                placeholder="Masukkan Nomer Hp">

                            <label for="sales_id">Sales Pengelola Toko</label>
                            <select class="form-control mb-3" name="sales_id" id="sales_id">
                                <option value=""> - Pilih Sales - </option>
                                @foreach ($sales as $s)
                                    <option value="{{ $s->id }}">{{ $s->sales_name }}</option>
                                @endforeach
                            </select>

                            <label for="city_branch">Kota Toko</label>
                            <select class="form-control mb-3" name="city_branch" id="city_branch">
                                <option value=""> - Pilih Kota - </option>
                                @foreach ($city as $t)
                                    <option value="{{ $t->city }}">{{ $t->city }}</option>
                                @endforeach
                            </select>
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

                @error('store_name')
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
                @error('store_number')
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
                        @foreach ($stores as $store)
                            <tr>
                                <td>{{ $store->store_name }}</td>
                                <td>{{ $store->address }}</td>
                                <td>{{ $store->store_number }}</td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <a href="{{ route('store.edit', Crypt::encrypt($store->id)) }}"
                                            class="btn btn-sm btn-warning btn-icon-split">
                                            <span class="icon text-white-50">
                                                <i class="fas fa-pencil-alt"></i>
                                            </span>
                                        </a>

                                        <form action="{{ route('store.destroy', $store->id) }}" method="post">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-sm btn-danger btn-icon-split ml-3">
                                                <span class="icon text-white-50">
                                                    <i class="fas fa-trash"></i>
                                                </span>
                                            </button>
                                        </form>
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
