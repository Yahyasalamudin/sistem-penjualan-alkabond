@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-center">
        <div class="card shadow mb-4 col-5">
            <div class="card-body">
                <form action="{{ route('type.update', $type->id) }}" method="post">
                    @csrf
                    @method('put')
                    <div class="form-group">
                        <label for="type">Edit Kota</label>
                        <input type="text" class="form-control @error('type') is-invalid @enderror" name="type"
                            id="type" value="{{ old('type', $type->type ?? '') }}">

                        @error('type')
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
