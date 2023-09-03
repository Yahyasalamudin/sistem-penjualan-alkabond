@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-center">
        <div class="card shadow mb-3 crd-edit col-10">
            <div class="card-header btcolor text-white mb-0">
                <h6 class="font-weight-bold">Edit Toko</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('store.update', $store->id) }}" method="post">
                    @csrf
                    @method('put')
                    <div class="form-group ">
                        <label for="store_name">Nama Toko</label>
                        <input type="text" class="form-control @error('store_name') is-invalid @enderror"
                            name="store_name" id="store_name" value="{{ old('store_name', $store->store_name ?? '') }}">

                        @error('store_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group ">
                        <label for="address">Alamat</label>
                        <input type="text" class="form-control @error('address') is-invalid @enderror" name="address"
                            id="address" value="{{ old('address', $store->address ?? '') }}">

                        @error('address')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                    </div>
                    <div class="form-group ">
                        <label for="store_number">Nomer Toko</label>
                        <input type="text" class="form-control @error('store_number') is-invalid @enderror"
                            name="store_number" id="store_number"
                            value="{{ old('store_number', $store->store_number ?? '') }}">

                        @error('store_number')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group ">
                        <label for="sales_id">Sales Pengelola Toko</label>
                        <select class="form-control mb-3" name="sales_id" id="sales_id">
                            <option value="{{ $store->sales_id }}">{{ $store->sales->sales_name }}</option>
                            @foreach ($sales as $s)
                                <option value="{{ $s->id }}">{{ $s->sales_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('sales_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <div class="form-group ">
                        <label for="city_branch">Kota Toko</label>
                        <select class="form-control mb-3" name="city_branch" id="city_branch" disabled>
                            <option>{{ $store->city->city }}</option>
                        </select>
                    </div>
                    <div class="form-group ">
                        <label for="city_branch">Cabang Kota</label>
                        <select class="form-control mb-3" name="city_branch" id="city_branch" disabled>
                            <option>{{ $store->city_branch->branch }}</option>
                        </select>
                    </div>
                    <div class="form-group" style="text-align:right;">
                        <a href="{{ route('store.index') }}" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btcolor ml-2 text-white">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
