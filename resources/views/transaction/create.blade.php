@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-start">
        <div class="shadow mb-3 col-md-10">
            <div class="card-header mb-0">
                <h6>Edit Toko</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('transaction.store') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="product_name">Nama Toko</label>
                        <select class="form-control mb-3" name="product_name" id="product_name">
                            <option value="">- Pilih Toko -</option>
                            @foreach ($store as $s)
                                <option value="{{ $s->id }}">{{ $s->store_name }}</option>
                            @endforeach
                        </select>
                        {{-- <input type="text" class="form-control @error('store_name') is-invalid @enderror" name="store_name"
                            id="store_name" value="{{ old('store_name') }}"> --}}

                        @error('store_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </form>
            </div>
        </div>
    </div>
@endsection
