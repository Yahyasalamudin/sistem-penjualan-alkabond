@extends('layouts.app')

@section('content')
    <h1 class="h3 mb-3 text-gray-800"> Data Pengguna</h1>
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
            <h6 class="m-0 font-weight-bold text-primary">Tabel Pengguna</h6>

            @if (auth()->user()->role == 'owner')
                <a href="{{ route('admin.create') }}" class="btn btcolor text-white">
                    Registrasi Pengguna
                </a>
            @endif
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
                            <th>Status</th>
                            @if (auth()->user()->role == 'owner')
                                <th>Opsi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = 1;
                        @endphp
                        @foreach ($users as $user)
                            <tr>
                                <th scope="row">{{ $i++ }} </th>
                                <td class="col-lg-7">{{ $user->name }}</td>
                                <td class="col-lg-7">{{ $user->username }}</td>
                                <td class="col-lg-7">{{ $user->email }}</td>
                                <td class="col-lg-7">{{ $user->phone_number }}</td>
                                <td class="col-lg-7">{{ $user->city->city }}</td>
                                <td class="col-lg-7">
                                    @if ($user->active == 1)
                                        <span class="badge badge-primary">Aktif</span>
                                    @else
                                        <span class="badge badge-secondary">Nonaktif</span>
                                    @endif
                                </td>
                                @if (auth()->user()->role == 'owner')
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <a href="{{ route('admin.edit', $user->id) }}" class="btn btn-sm btn-success">
                                                Edit
                                            </a>
                                            <form action="{{ route('admin.destroy', $user->id) }}" method="post">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="btn btn-sm btn-danger ml-2">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
