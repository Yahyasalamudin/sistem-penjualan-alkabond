@extends('layouts.app')

@section('content')
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Table Jenis Produk</h6>

            <a href="{{ route('user.create') }}" class="btn btn-primary">
                Registrasikan Penggunna
            </a>
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

                @if (session('error'))
                    <div class="d-flex justify-content-center">
                        <div class="alert alert-danger text-center col-sm-4 text-dark">
                            {{ session('error') }}
                        </div>
                    </div>
                @endif
                <table class="table table-bordered text-center" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Nomer Hp</th>
                            <th>Kota</th>
                            <th>Lvel User</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td class="col-lg-7">{{ $user->name }}</td>
                                <td class="col-lg-7">{{ $user->username }}</td>
                                <td class="col-lg-7">{{ $user->email }}</td>
                                <td class="col-lg-7">{{ $user->phone_number }}</td>
                                <td class="col-lg-7">{{ $user->city }}</td>
                                <td class="col-lg-7">{{ $user->role }}</td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <a href="{{ route('user.edit', $user->id) }}"
                                            class="btn btn-sm btn-warning btn-icon-split">
                                            <span class="icon text-white-50">
                                                <i class="fas fa-pencil-alt"></i>
                                            </span>
                                        </a>
                                        <form action="{{ route('user.destroy', $user->id) }}" method="post">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-sm btn-danger btn-icon-split ml-2">
                                                <span class="icon text-white-50">
                                                    <i class="fas fa-trash"></i>
                                                </span>
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
