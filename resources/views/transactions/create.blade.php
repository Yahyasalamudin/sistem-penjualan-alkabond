@extends('layouts.app')
@push('css')
    @livewireStyles
    <style>
        .hover-pointer {
            cursor: pointer;
        }

        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type=number] {
            -moz-appearance: textfield;
        }
    </style>
@endpush
@push('js')
    @livewireScripts()
    <script type="text/javascript">
        document.addEventListener("livewire:load", function() {
            Livewire.on('componentLoaded', function() {
                applyFormatRupiah();
            });

            applyFormatRupiah();
        });

        function applyFormatRupiah() {
            var rupiahInputs = document.querySelectorAll('[data-format="rupiah"]');

            rupiahInputs.forEach(function(input) {
                var inputValue = input.value;
                var formattedValue = formatRupiah(inputValue, 'Rp. ');
                input.value = formattedValue;

                input.addEventListener('input', function(event) {
                    var inputValue = event.target.value;
                    var formattedValue = formatRupiah(inputValue, 'Rp. ');
                    event.target.value = formattedValue;
                });
            });
        }

        function formatRupiah(angka, prefix) {
            var number_string = angka.replace(/[^,\d]/g, '').toString();
            var split = number_string.split(',');
            var sisa = split[0].length % 3;
            var rupiah = split[0].substr(0, sisa);
            var ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                var separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
        }
    </script>
@endpush
@section('content')
    <div class="content-header">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="h3 mb-3 text-gray-800">Tambah Transaksi</h1>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 mt-3 mb-5">
            <div class="col-xl-12 col-lg-6">
                <form action="{{ route('transaction.store') }}" method="post">
                    @csrf
                    <div class="card shadow mb-4 crd-edit">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between btcolor">
                            <div class="col-sm-3">
                                <select class="form-control  @error('store_id') is-invalid @enderror" name="store_id"
                                    id="store_id">
                                    <option value="">- Pilih Toko -</option>
                                    @foreach ($stores as $store)
                                        <option value="{{ $store->id }}"
                                            {{ session('store_id') == $store->id ? 'selected' : '' }}>
                                            {{ $store->store_name }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('store_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <button type="button" class="btn btn-light ml-2" data-toggle="modal"
                                data-target="#modal-cart">Tambah Barang</button>
                        </div>

                        <div class="row-lg-12">
                            <div class="col-md-12">
                                <div style="margin-top: 30px;" class="col-xl-12 col-lg-6">
                                    @if (session('error'))
                                        <div class="alert alert-danger alert-dismissible mb-4" id="flash_data"
                                            role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                            {{ session('error') }}
                                        </div>
                                    @endif
                                    @livewire('product-cart')
                                    <div class="form-group" style="text-align:right;">
                                        <a href="{{ route('transaction.index', 'unsent') }}"
                                            class="btn btn-secondary ">Batal</a>
                                        <button type="submit" class="btn btcolor ml-2 text-white">Pre-Order</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
