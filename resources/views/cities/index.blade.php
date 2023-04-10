@extends('layouts.app')

@section('content')
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Table Kota</h6>

            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                Launch demo modal
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
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submin" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                @if (session('success'))
                    <div class="d-flex justify-content-center">
                        <div class="alert alert-success text-center col-sm-4 text-dark font-weight-bold">
                            {{ session('success') }}
                        </div>
                    </div>
                @endif
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Kota</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Kota</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach ($city as $c)
                            <tr>
                                <td>{{ $c->city }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
