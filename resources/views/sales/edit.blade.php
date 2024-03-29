@extends('layouts.app')
@push('js')
    <script>
        const input_city_id = document.getElementById("city_id");

        input_city_id.addEventListener("change", function() {
            let url =
                "{{ route('city-branch.get-city-branches', ':id') }}";
            url = url.replace(':id', input_city_id.value) + '?sales=' + 0;
            $.ajax({
                url: url,
                success: function(result) {
                    $("label[for='city_branch_id']").attr('hidden', false);
                    $("#city_branch_id").attr('hidden', false);
                    $("#city_branch_id").empty();

                    const option = document.createElement('option');
                    option.text = " - Pilih Kota - ";
                    option.value = "";
                    $("#city_branch_id").append(option);

                    result.forEach(item => {
                        const option = document.createElement('option');
                        option.text = item.branch;
                        option.value = item.id;
                        $("#city_branch_id").append(option);
                    });
                }
            })
        })
    </script>
@endpush
@section('content')
    <div class="content-header">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="h3 mb-3 text-gray-800">Edit Sales</h1>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 mt-3 mb-5">
            <div class="col-xl-12 col-lg-6">
                <div class="card shadow mb-4 crd-edit">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between btcolor">
                        <h6 class="m-0 font-weight-bold text-white ">Tambah Sales</h6>
                    </div>
                    <div class="row-lg-12">
                        <form action="{{ route('sales.update', hashid_encode($sales->id)) }}" method="post">
                            @csrf
                            @method('put')
                            <div class="col-md-12">
                                <div style="margin-top: 30px;" class="col-xl-12 col-lg-6">

                                    <div class="form-group row mb-4">
                                        <label for="sales_name" class="col-sm-2 col-form-label">Nama</label>
                                        <div class="col-sm-4">
                                            <input type="text"
                                                class="form-control @error('sales_name') is-invalid @enderror"
                                                name="sales_name" id="sales_name"
                                                value="{{ old('sales_name', $sales->sales_name ?? '') }}"
                                                placeholder="Masukkan Nama Pengguna">

                                            @error('sales_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <label for="username" class="col-sm-2 col-form-label">Username</label>
                                        <div class="col">
                                            <input type="text" class="form-control" name="username" id="username"
                                                value="{{ old('username', $sales->username ?? '') }}"
                                                placeholder="Masukkan Username" disabled>
                                        </div>
                                    </div>

                                    <div class="form-group row mb-4">
                                        <label for="email" class="col-sm-2 col-form-label">Email</label>
                                        <div class="col-sm-4">
                                            <input type="email" class="form-control" name="email" id="email"
                                                value="{{ old('email', $sales->email ?? '') }}"
                                                placeholder="Masukkan Email. Contoh : user@gmail.com">
                                        </div>
                                        <label for="phone_number" class="col-sm-2 col-form-label">Nomor Hp</label>
                                        <div class="col">
                                            <input type="text"
                                                class="form-control @error('phone_number') is-invalid @enderror"
                                                name="phone_number" id="phone_number"
                                                value="{{ old('phone_number', $sales->phone_number ?? '') }}"
                                                placeholder="Masukkan Nomer Hp">

                                            @error('phone_number')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row mb-4">
                                        <label for="city_id" class="col-sm-2 col-form-label">Pilih Cabang Gudang</label>
                                        <div class="col-sm-4">
                                            <select class="form-control @error('city_id') is-invalid @enderror"
                                                name="city_id" id="city_id"
                                                @if ($user->role == 'admin') disabled @endif>
                                                <option value="{{ $sales->city_id }}">{{ $sales->city->city }}</option>
                                                @foreach ($cities as $city)
                                                    @if ($city->id != $sales->city_id)
                                                        <option value="{{ $city->id }}">{{ $city->city }}</option>
                                                    @endif
                                                @endforeach
                                            </select>

                                            @if ($user->role == 'admin')
                                                <input type="hidden" name="city_id" value="{{ $user->city_id }}">
                                            @endif

                                            @error('city_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <label for="city_branch_id" class="col-sm-2 col-form-label">Kota</label>
                                        <div class="col-sm">
                                            <select class="form-control @error('city_branch_id') is-invalid @enderror"
                                                name="city_branch_id" id="city_branch_id">
                                                <option value=""> - Pilih Kota - </option>
                                                <option value="{{ $sales->city_branch_id }}" selected>
                                                    {{ $sales->city_branch->branch }}</option>
                                                @foreach ($city_branches as $item)
                                                    @if ($item->id != $sales->city_branch_id)
                                                        <option value="{{ $item->id }}">{{ $item->branch }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row mb-4">
                                        <label for="active" class="col-sm-2 col-form-label">Status</label>
                                        <div class="col-4">
                                            <select class="form-control  @error('active') is-invalid @enderror"
                                                name="active" id="active">
                                                <option value="1" {{ $sales->active == 1 ? 'selected' : '' }}>Aktif
                                                <option value="0" {{ $sales->active == 0 ? 'selected' : '' }}>
                                                    Nonaktifkan</option>
                                                </option>
                                            </select>

                                            @error('active')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row mb-4">
                                        <label for="password" class="col-sm-2 col-form-label">Password</label>
                                        <div class="col-sm-4">
                                            <input type="password"
                                                class="form-control @error('password') is-invalid @enderror" name="password"
                                                id="password" value="{{ old('password') }}"
                                                placeholder="Masukkan Password">
                                            <span class="font-italic">NB : Kosongkan password jika tidak ingin
                                                diganti</span>

                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <label for="current_password" class="col-sm-2 col-form-label">Konfirmasi
                                            Password</label>
                                        <div class="col">
                                            <input type="password"
                                                class="form-control @error('current_password') is-invalid @enderror"
                                                name="current_password" id="current_password"
                                                value="{{ old('current_password') }}"
                                                placeholder="Masukkan kembali password!!">

                                            @error('current_password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group" style="text-align:right;">
                                        <a href="{{ route('sales.index') }}" class="btn btn-secondary ">Batal</a>
                                        <button type="submit" class="btn btcolor ml-2 text-white">edit Sales</button>
                                    </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
@endsection
