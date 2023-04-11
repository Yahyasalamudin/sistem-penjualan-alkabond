@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-center">
        <div class="card shadow mb-3 col-5">
            <div class="card-header mb-0">
                <h6>Edit Toko</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('store.update', $store->id) }}" method="post">
                    @csrf
                    @method('put')
                    <div class="form-group">
                        <label for="store_name">Nama Toko</label>
                        <input type="text" class="form-control @error('store_name') is-invalid @enderror" name="store_name"
                            id="store_name" value="{{ old('store_name', $store->store_name ?? '') }}">

                        @error('store_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                        <label for="address">Alamat</label>
                        <input type="text" class="form-control @error('address') is-invalid @enderror" name="address"
                            id="address" value="{{ old('address', $store->address ?? '') }}">

                        @error('address')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                        <label for="phone_number">Nomer Toko</label>
                        <input type="text" class="form-control @error('phone_number') is-invalid @enderror" name="phone_number"
                            id="phone_number" value="{{ old('phone_number', $store->phone_number ?? '') }}">

                        @error('phone_number')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Edit</button>
                </form>
            </div>
        </div>
    </div>
@endsection
