@extends('layouts.app')

@section('content')
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Table Kota</h6>

            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                Tambah Kota
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
                    <form action="{{ route('cities.store') }}" method="post">
                        @csrf
                        <div class="modal-body">
                            <label for="city">Nama Kota</label>
                            <input class="form-control" type="text" name="city" id="city"
                                placeholder="Masukkan Nama Kota">
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

                @error('city')
                    <div class="d-flex justify-content-center">
                        <div class="alert alert-danger text-center col-sm-4 text-dark">
                            {{ $message }}
                        </div>
                    </div>
                @enderror
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Kota</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($city as $c)
                            <tr>
                                <td class="col-lg-7">{{ $c->city }}</td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <a href="{{ route('cities.edit', $c->id) }}" class="btn btn-warning btn-icon-split">
                                            <span class="icon text-white-50">
                                                <i class="fas fa-pencil-alt"></i>
                                            </span>
                                            <span class="text">Edit Kota</span>
                                        </a>
                                        <form action="{{ route('cities.destroy', $c->id) }}" method="post">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-danger btn-icon-split ml-5">
                                                <span class="icon text-white-50">
                                                    <i class="fas fa-trash"></i>
                                                </span>
                                                <span class="text">Hapus Kota</span>
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
