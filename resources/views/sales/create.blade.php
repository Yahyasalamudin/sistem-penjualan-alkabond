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
                    option.text = " - Pilih Cabang Kota - ";
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
                <h1 class="h3 mb-3 text-gray-800">Registrasi Sales</h1>
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
                        <form action="{{ route('sales.create') }}" method="post">
                            @csrf
                            <div class="col-md-12">
                                <div style="margin-top: 30px;" class="col-xl-12 col-lg-6">
                                    <div class="form-group row mb-4">
                                        <label for="sales_name" class="col-sm-2 col-form-label">Nama</label>
                                        <div class="col-sm-4">
                                            <input type="text"
                                                class="form-control @error('sales_name') is-invalid @enderror "
                                                name="sales_name" id="sales_name" value="{{ old('sales_name') }}"
                                                placeholder="Masukkan Nama Pengguna">

                                            @error('sales_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <label for="username" class="col-sm-2 col-form-label">Username</label>
                                        <div class="col">
                                            <input type="text"
                                                class="form-control @error('username') is-invalid @enderror "
                                                name="username" id="username" value="{{ old('username') }}"
                                                placeholder="Masukkan Username">

                                            @error('username')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row mb-4">
                                        <label for="email" class="col-sm-2 col-form-label">Email</label>
                                        <div class="col-sm-4">
                                            <input type="email" class="form-control @error('email') is-invalid @enderror "
                                                name="email" id="email" value="{{ old('email') }}"
                                                placeholder="Masukkan Email. Contoh : user@gmail.com">

                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <label for="phone_number" class="col-sm-2 col-form-label">Nomor Hp</label>
                                        <div class="col">
                                            <input type="text"
                                                class="form-control @error('phone_number') is-invalid @enderror "
                                                name="phone_number" id="phone_number" value="{{ old('phone_number') }}"
                                                placeholder="Masukkan Nomer Hp">

                                            @error('phone_number')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row mb-4">
                                        <label for="city_id" class="col-sm-2 col-form-label">Pilih Kota</label>
                                        <div class="col-sm-4">
                                            <select class="form-control  @error('city_id') is-invalid @enderror"
                                                name="city_id" id="city_id">
                                                <option value="">- Pilih Kota -</option>
                                                @foreach ($cities as $city)
                                                    <option value="{{ $city->id }}">{{ $city->city }}</option>
                                                @endforeach
                                            </select>

                                            @error('city_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <label for="city_branch_id" class="col-sm-2 col-form-label" hidden>Kota
                                            Cabang</label>
                                        <div class="col-sm">
                                            <select class="form-control @error('city_branch_id') is-invalid @enderror"
                                                name="city_branch_id" id="city_branch_id" hidden>
                                                <option value=""> - Pilih Cabang Kota - </option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row mb-4">
                                        <label for="password" class="col-sm-2 col-form-label">Password</label>
                                        <div class="col-sm-4">
                                            <input type="password"
                                                class="form-control @error('password') is-invalid @enderror "
                                                name="password" id="password" value="{{ old('password') }}"
                                                placeholder="Masukkan Password">

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
                                                class="form-control @error('current_password') is-invalid @enderror "
                                                name="current_password" id="current_password"
                                                value="{{ old('current_password') }}"
                                                placeholder="Masukkan kembali password!! ">
                                            @error('current_password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                            <p class="mt-2">NB:Harus sama dengan password disamping!!</p>
                                        </div>
                                    </div>

                                    <div class="form-group" style="text-align:right;">
                                        <a href="{{ route('sales.index') }}" class="btn btn-secondary ">Batal</a>
                                        <button type="submit" class="btn btcolor ml-2 text-white">Tambah Sales</button>
                                    </div>
                                </div>
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
