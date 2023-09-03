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
                                <td class="col-lg-7">{{ $s->email }}</td>
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
    </div>
@endsection
