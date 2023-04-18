@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-center">
        <div class="card shadow mb-4 col">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Edit User</h6>
            </div>

            <div class="card-body">
                <form action="{{ route('user.update', $user->id) }}" method="post">
                    @csrf
                    @method('put')
                    <div class="form-group">
                        <label for="name">Nama</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror mb-3" name="name"
                            id="name" value="{{ old('name', $user->name ?? '') }}"
                            placeholder="Masukkan Nama Pengguna">

                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control mb-3" name="username" id="username"
                            value="{{ old('username', $user->username ?? '') }}" placeholder="Masukkan Username" disabled>
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control mb-3" name="email" id="email"
                            value="{{ $user->email }}" placeholder="Masukkan Email. Contoh : user@gmail.com" disabled>
                    </div>

                    <div class="form-group">
                        <label for="phone_number">Nomor Hp</label>
                        <input type="text" class="form-control @error('phone_number') is-invalid @enderror mb-3"
                            name="phone_number" id="phone_number"
                            value="{{ old('phone_number', $user->phone_number ?? '') }}" placeholder="Masukkan Nomer Hp">

                        @error('phone_number')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="city">Pilih Kota</label>
                        <select class="form-control mb-3 @error('city') is-invalid @enderror" name="city" id="city">
                            <option value="{{ $user->city }}">{{ $user->city }}</option>
                            @foreach ($cities as $city)
                                <option value="{{ $city->city }}">{{ $city->city }}</option>
                            @endforeach
                        </select>

                        @error('city')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="role">Pilih Role</label>
                        <select class="form-control mb-3 @error('role') is-invalid @enderror" name="role" id="role"
                            disabled>
                            <option value="">{{ $user->role }}</option>
                        </select>

                        @error('role')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror mb-3"
                            name="password" id="password" value="{{ old('password') }}" placeholder="Masukkan Password">
                        <span class="font-italic">NB : Kosongkan password jika tidak ingin diganti</span>


                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="current_password">Konfirmasi Password</label>
                        <input type="password" class="form-control @error('current_password') is-invalid @enderror mb-3"
                            name="current_password" id="current_password" value="{{ old('current_password') }}"
                            placeholder="Masukkan kembali password!! NB:Harus sama dengan password diatas!!">

                        @error('current_password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Edit User</button>
                </form>
            </div>
        </div>
    </div>
@endsection
