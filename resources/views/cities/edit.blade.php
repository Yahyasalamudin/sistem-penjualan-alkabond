@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-center">
        <div class="card shadow mb-4 col-5">
            <div class="card-body">
                <form action="{{ route('city.update', $city->id) }}" method="post">
                    @csrf
                    @method('put')
                    <div class="form-group">
                        <label for="city">Edit Kota</label>
                        <input type="text" class="form-control @error('city') is-invalid @enderror" name="city"
                            id="city" value="{{ old('city', $city->city ?? '') }}">

                        @error('city')
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
