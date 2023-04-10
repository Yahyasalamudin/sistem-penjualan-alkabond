@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-center">
        <div class="card shadow mb-4 col-5">
            <div class="card-body">
                <form action="{{ route('units.update', $unit->id) }}" method="post">
                    @csrf
                    @method('put')
                    <div class="form-group">
                        <label for="unit_name">Edit Unit</label>
                        <input type="text" class="form-control @error('unit_name') is-invalid @enderror" name="unit_name"
                            id="unit_name" value="{{ old('unit_name', $unit->unit_name ?? '') }}">

                        @error('unit_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                        <label for="amount">Edit Unit</label>
                        <input type="text" class="form-control @error('amount') is-invalid @enderror" name="amount"
                            id="amount" value="{{ old('amount', $unit->amount ?? '') }}">

                        @error('amount')
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
