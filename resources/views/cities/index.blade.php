@extends('layouts.app')

@section('content')
    <h1 class="h3 mb-3 text-gray-800">Data Cabang</h1>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible" id="flash_data" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            {{ session('success') }}
        </div>
    @endif

    @error('city')
        <div class="alert alert-danger alert-dismissible" id="flash_data" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            {{ $message }}
        </div>
    @enderror
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Tabel Cabang</h6>

            <button type="button" class="btn btcolor text-white" data-toggle="modal" data-target="#exampleModal">
                Tambah Cabang
            </button>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Cabang</th>
                            <th>Opsi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @php
                            $i = 1;
                        @endphp
                        @foreach ($city as $c)
                            <tr>

                                <th scope="row">{{ $i++ }} </th>
                                <td>{{ $c->city }}</td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <button class="btn btn-sm btn-success" data-toggle="modal"
                                            data-target="#editModal{{ $c->id }}">
                                            Edit
                                        </button>
                                        <form action="{{ route('city.destroy', $c->id) }}" method="post">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-sm btn-danger ml-3">
                                                <span class="text">Hapus</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>

                            <!-- Data Modal -->
                            <div class="modal fade" id="editModal{{ $c->id }}" tabindex="-1"
                                aria-labelledby="editModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editModalLabel">Edit Cabang</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="{{ route('city.update', $c->id) }}" method="post">
                                            @csrf
                                            @method('put')
                                            <div class="modal-body">
                                                <label for="city">Nama Cabang</label>
                                                <input class="form-control" type="text" name="city" id="city"
                                                    placeholder="Masukkan Nama Cabang" value="{{ $c->city }}">
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
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Cabang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('city.store') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <label for="city">Nama Cabang</label>
                        <input class="form-control" type="text" name="city" id="city"
                            placeholder="Masukkan Nama Cabang">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
