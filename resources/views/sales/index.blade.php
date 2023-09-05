@extends('layouts.app')

@section('content')
    <h1 class="h3 mb-3 text-gray-800"> Data Sales</h1>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible" id="flash_data" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible" id="flash_data" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            {{ session('error') }}
        </div>
    @endif

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Tabel Sales</h6>

            <a href="{{ route('sales.create') }}" class="btn btcolor text-white">
                Registrasi Sales
            </a>
        </div>

        <div class="card-body">
            <div class="mb-3">
                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#importModal">
                    <i class="fas fa-file-upload"></i> Import
                </button>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered text-center" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Nomer Hp</th>
                            <th>Kota</th>
                            <th>Cabang Kota</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = 1;
                        @endphp
                        @foreach ($sales as $s)
                            <tr>
                                <th scope="row">{{ $i++ }} </th>

                                <td class="col-lg-7">{{ $s->sales_name }}</td>
                                <td class="col-lg-7">{{ $s->username }}</td>
                                <td class="col-lg-7">{{ !empty($s->email) ? $s->email : '-' }}</td>
                                <td class="col-lg-7">{{ $s->phone_number }}</td>
                                <td class="col-lg-7">{{ $s->city->city }}</td>
                                <td class="col-lg-7">{{ $s->city_branch->branch }}</td>
                                <td class="col-lg-7">
                                    @if ($s->active == 1)
                                        <span class="badge badge-primary">Aktif</span>
                                    @else
                                        <span class="badge badge-secondary">Nonaktif</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <a href="{{ route('sales.edit', $s->id) }}" class="btn btn-sm btn-success">
                                            Edit
                                        </a>
                                        <form action="{{ route('sales.destroy', $s->id) }}" method="post">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-sm btn-danger ml-2">
                                                Hapus
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

        <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="importModalLabel">Import Sales</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="post" action="{{ route('import.sales') }}" enctype="multipart/form-data">
                        <div class="modal-body">
                            @csrf
                            <div class="card card-outline card-primary mb-3">
                                <div class="card-header">
                                    <h5 class="modal-title">Petunjuk :</h5>
                                </div>
                                <div class="card-body">
                                    <ul>
                                        <li>Kolom 1 = Nama Sales</li>
                                        <li>Kolom 2 = Username</li>
                                        <li>Kolom 3 = Email (opsional)</li>
                                        <li>Kolom 4 = Nomer HP</li>
                                        <li>Kolom 5 = Password</li>
                                        <li>Kolom 6 = Kota</li>
                                        <li>Kolom 7 = Cabang Kota</li>
                                    </ul>
                                </div>
                            </div>
                            <label>Pilih File</label>
                            <div class="form-group">
                                <input type="file" name="file" required="required">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Import</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection
