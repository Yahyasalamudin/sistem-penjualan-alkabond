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
        document.addEventListener("DOMContentLoaded", function() {
            var rupiah = document.getElementById('rupiah');
            rupiah.value = formatRupiah(rupiah.value, 'Rp. ');
        });

        var rupiah = document.getElementById('rupiah');
        rupiah.addEventListener('keyup', function(e) {
            // tambahkan 'Rp.' pada saat form di ketik
            // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
            rupiah.value = formatRupiah(this.value, 'Rp. ');
        });

        /* Fungsi formatRupiah */
        function formatRupiah(angka, prefix) {
            var number_string = angka.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            // tambahkan titik jika yang di input sudah menjadi angka ribuan
            if (ribuan) {
                separator = sisa ? '.' : '';
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
                                            {{ old('store_id') == $store->id ? 'selected' : '' }}>{{ $store->store_name }}
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
