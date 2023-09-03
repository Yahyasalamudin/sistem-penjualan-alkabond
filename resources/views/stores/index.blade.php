@extends('layouts.app')
@push('js')
    <script>
        const input_sales_id = document.getElementById("sales_id");

        input_sales_id.addEventListener("change", function() {
            let url = "{{ route('city-branch.get-city-branches', ':id') }}";
            url = url.replace(':id', input_sales_id.value) + '?sales=' + 1;
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
    <h1 class="h3 mb-3 text-gray-800"> Data Toko</h1>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible" id="flash_data" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            {{ session('success') }}
        </div>
    @endif

    @error('store_name')
        <div class="alert alert-danger alert-dismissible" id="flash_data" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            {{ $message }}
        </div>
    @enderror
    @error('address')
        <div class="alert alert-danger alert-dismissible" id="flash_data1" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            {{ $message }}
        </div>
    @enderror
    @error('store_number')
        <div class="alert alert-danger alert-dismissible" id="flash_data2" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            {{ $message }}
        </div>
    @enderror
    @error('sales_id')
        <div class="alert alert-danger alert-dismissible" id="flash_data3" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            {{ $message }}
        </div>
    @enderror
    @error('city_branch_id')
        <div class="alert alert-danger alert-dismissible" id="flash_data3" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            {{ $message }}
        </div>
    @enderror

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Table Toko</h6>
            <button type="button" class="btn btcolor text-white" data-toggle="modal" data-target="#exampleModal">
                Tambah Toko
            </button>
        </div>

        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tambah Toko</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('store.store') }}" method="post">
                        @csrf
                        <div class="modal-body">
                            <label for="store_name">Nama Toko</label>
                            <input class="form-control mb-3" type="text" name="store_name" id="store_name"
                                placeholder="Masukkan Nama Toko">

                            <label for="address">Alamat Toko</label>
                            <input class="form-control mb-3" type="text" name="address" id="address"
                                placeholder="Masukkan Alamat Toko">

                            <label for="store_number">Nomer Hp</label>
                            <input class="form-control mb-3" type="number" name="store_number" id="store_number"
                                placeholder="Masukkan Nomer Hp">

                            <label for="sales_id">Sales Pengelola Toko</label>
                            <select class="form-control mb-3" name="sales_id" id="sales_id">
                                <option value=""> - Pilih Sales - </option>
                                @foreach ($sales as $s)
                                    <option value="{{ $s->id }}">{{ $s->sales_name }}</option>
                                @endforeach
                            </select>

                            <label for="city_branch_id" hidden>Cabang Kota</label>
                            <select class="form-control mb-3" name="city_branch_id" id="city_branch_id" hidden>
                                <option value=""> - Pilih Cabang Kota - </option>
                            </select>
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


                <table class="table table-bordered text-center text-center" id="dataTable" width="100%"
                    cellspacing="0">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Toko</th>
                            <th>Alamat</th>
                            <th>Nomer Hp</th>
                            <th>Kota</th>
                            <th>Cabang Kota</th>
                            <th>Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = 1;
                        @endphp
                        @foreach ($stores as $store)
                            <tr class="@if ($store->is_more_than_60_days) bg-warning text-dark @endif">
                                <th scope="row">{{ $i++ }} </th>
                                <td>{{ $store->store_name }}</td>
                                <td>{{ $store->address }}</td>
                                <td>{{ $store->store_number }}</td>
                                <td>{{ $store->city->city }}</td>
                                <td>{{ $store->city_branch->branch }}</td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <a href="{{ route('store.edit', Crypt::encrypt($store->id)) }}"
                                            class="btn btn-sm btn-success ">
                                            Edit
                                        </a>

                                        <form action="{{ route('store.destroy', $store->id) }}" method="post">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-sm btn-danger  ml-2">
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
