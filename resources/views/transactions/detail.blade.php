@php
    use Carbon\Carbon;
    
    Carbon::setLocale('id');
@endphp

@extends('layouts.app')

@push('css')
    <style>
        .lunas-rotate {
            font-size: 32px;
            transform: rotate(-15deg);
            color: #3d8080;
            display: inline-block;
        }
    </style>
@endpush

@push('js')
    <script>
        function showConfirmAlert(
            text,
            confirmBtnText,
            successText,
            callback,
        ) {
            Swal.fire({
                title: text,
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Kembali',
                confirmButtonText: confirmBtnText,
                reverseButtons: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    callback();
                }
            })
        }

        let handleSend = () => {
            let sendForm = document.getElementById("sendForm");
            sendForm.submit();
        }

        var activeInputId = null;

        function toggleEdit(paymentId) {
            var textElement = document.getElementById(`payment-amount-${paymentId}`);
            var inputElement = document.getElementById(`payment-input-${paymentId}`);
            var editButton = document.getElementById(`edit-button-${paymentId}`);
            var cancelButton = document.getElementById(`cancel-button-${paymentId}`);
            var saveButton = document.getElementById(`save-button-${paymentId}`);

            if (activeInputId !== null && activeInputId !== paymentId) {
                var previousInputElement = document.getElementById(`payment-input-${activeInputId}`);
                var previousTextElement = document.getElementById(`payment-amount-${activeInputId}`);
                var previousEditButton = document.getElementById(`edit-button-${activeInputId}`);
                var previousCancelButton = document.getElementById(`cancel-button-${activeInputId}`);
                var previousSaveButton = document.getElementById(`save-button-${activeInputId}`);
                previousInputElement.classList.add('d-none');
                previousCancelButton.classList.add('d-none');
                previousSaveButton.classList.add('d-none');
                previousTextElement.classList.remove('d-none');
                previousEditButton.classList.remove('d-none');
                previousInputElement.setAttribute('readonly', 'readonly');
            }

            if (textElement.classList.contains('d-none')) {
                textElement.classList.remove('d-none');
                editButton.classList.remove('d-none')
                inputElement.classList.add('d-none');
                cancelButton.classList.add('d-none')
                saveButton.classList.add('d-none')
                inputElement.setAttribute('readonly', 'readonly');
                activeInputId = null;
            } else {
                textElement.classList.add('d-none');
                editButton.classList.add('d-none')
                inputElement.classList.remove('d-none');
                cancelButton.classList.remove('d-none')
                saveButton.classList.remove('d-none')
                inputElement.removeAttribute('readonly');
                inputElement.focus();
                activeInputId = paymentId;

                var rupiah = document.getElementById(`payment-input-${paymentId}`);
                applyFormatRupiah(rupiah);
            }
        }

        function applyFormatRupiah(input) {
            input.value = formatRupiah(input.value, 'Rp. ');

            input.addEventListener('keyup', function(e) {
                input.value = formatRupiah(input.value, 'Rp. ');
            });
        }

        function formatRupiah(angka, prefix) {
            var number_string = angka.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
        }

        document.getElementById('paymentForm').addEventListener('submit', function() {
            var payButton = document.getElementById('payButton');
            payButton.disabled = true;

            setTimeout(function() {
                payButton.disabled = false;
            }, 5000);
        });
    </script>

    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function() {
            var rupiah = document.getElementById('total_pay');
            rupiah.value = formatRupiah(rupiah.value, 'Rp. ');
        });

        var rupiah = document.getElementById('total_pay');
        rupiah.addEventListener('keyup', function(e) {
            rupiah.value = formatRupiah(this.value, 'Rp. ');
        });

        function formatRupiah(angka, prefix) {
            var number_string = angka.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

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
    @if ($transaction->delivery_status != 'proccess' && $transaction->delivery_status != 'sent')
        <div class="row py-4">
            <div class="col">
                <h1 class="h3 mb-2 text-gray-800">Detail Pesanan</h1>
            </div>
        </div>
    @endif

    @if ($transaction->delivery_status == 'proccess' || $transaction->delivery_status == 'sent')
        <div class="row py-4 mx-1 d-flex flex-row justify-content-between">
            <h1 class="h3 mb-2 text-gray-800">Detail Pesanan</h1>
            {{-- <h1 class="h3 mb-2 text-gray-800">{{ $transaction->invoice_code }}</h1> --}}
            <div class="row mx-1 d-flex flex-row justify-content-right">
                @if ($transaction->delivery_status == 'proccess')
                    <form id="sendForm"
                        action="{{ route('transaction.update', ['delivery_status' => 'sent', 'id' => $transaction->id]) }}"
                        method="post">
                        @csrf
                        @method('put')
                        <button type="button" class="btn btcolor text-white"
                            onclick="showConfirmAlert('Apakah yakin transaksi sudah terkirim?', 'Lanjut', 'Transaksi berhasil terkirim.', handleSend)">Dikirim</button>
                    </form>
                @endif
                <a href="{{ route('delivery-letter', $transaction->invoice_code) }}" class="btn btn-info mb-1 mx-2"
                    target="_blank">
                    Cetak Surat Jalan
                </a>
                @if ($transaction->delivery_status == 'sent' && $transaction->status == 'paid')
                    <a href="{{ route('struk', $transaction->invoice_code) }}" class="btn btn-primary mb-1" target="_blank">
                        Cetak Struk Transaksi
                    </a>
                @endif
            </div>
        </div>
    @endif

    {{-- <div class="py-3 d-flex flex-row justify-content-between">
        <h1 class="h3 mb-2 text-gray-800"> Pembayaran</h1>
        <h1 class="h3 mb-2 text-gray-800">{{ $transaction->invoice_code }}</h1>
    </div> --}}

    <div class="row">
        <div class="col-md-8 col-lg-12">
            {{-- <form action="" method="post" id="registration"> --}}
            <nav>
                <hr>
                <div class="nav nav-pills nav-fill mb-4 " id="nav-tab" role="tablist">
                    <a class="nav-link active" id="step1-tab" data-bs-toggle="tab" href="#step1">Detail Pesanan</a>

                    <a class="nav-link" id="step2-tab" data-bs-toggle="tab" href="#step2">Pembayaran</a>

                    {{-- @if (isset($transaction->payment_method))
                        <a class="nav-link" id="step3-tab" data-bs-toggle="tab" href="#step3">Retur Pesanan</a>
                    @endif --}}
                </div>
                <hr>
            </nav>
            <div class="tab-content py-4">
                <div class="tab-pane fade show active" id="step1">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="card shadow-tabl mb-4 crddet mx-2 col">
                                <div class="card-header btcolor py-3 ">
                                    <h6 class="m-0 font-weight-bold text-white">Detail Transaksi</h6>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped text-capitalize" width="100%" cellspacing="0">
                                            <tbody>
                                                <tr>
                                                    <td>Kode Transaksi</td>
                                                    <td>{{ $transaction->invoice_code }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Nama Sales</td>
                                                    <td>{{ $transaction->sales->sales_name }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Payment Method</td>
                                                    <td>
                                                        @if (empty($transaction->payment_method))
                                                            -
                                                        @else
                                                            {{ $transaction->payment_method }}
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Status</td>
                                                    <td>
                                                        @if ($transaction->status == 'unpaid')
                                                            Belum Dibayar
                                                        @elseif ($transaction->status == 'partial')
                                                            Dicicil
                                                        @else
                                                            Lunas
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Pengiriman</td>
                                                    <td>
                                                        @if ($transaction->delivery_status == 'unsent')
                                                            Belum Dikirim
                                                        @elseif ($transaction->delivery_status == 'proccess')
                                                            Dalam Perjalanan
                                                        @else
                                                            Telah Terkirim
                                                        @endif
                                                    </td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="card shadow  mb-4 crddet col">
                                <div class="card-header btcolor py-3 ">
                                    <h6 class="m-0 font-weight-bold text-white">Detail Toko</h6>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped" width="100%" cellspacing="0">
                                            <tbody>
                                                <tr>
                                                    <td>Nama Toko</td>
                                                    <td>{{ $transaction->stores->store_name }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Alamat</td>
                                                    <td>{{ $transaction->stores->address }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Nomor Toko</td>
                                                    <td>{{ $transaction->stores->store_number }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Kota</td>
                                                    <td>{{ $transaction->stores->city->city }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Cabang Kota</td>
                                                    <td>{{ $transaction->stores->city_branch->branch }}</td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="card shadow mb-4 crddet col">
                            <div class="card-header btcolor py-3 ">
                                <h6 class="m-0 font-weight-bold text-white">Detail Pesanan</h6>
                            </div>

                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Kode Barang</th>
                                                <th>Nama Barang </th>
                                                <th>Berat </th>
                                                <th>Harga per PCS</th>
                                                <th>Jumlah</th>
                                                <th>SubTotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($transaction->transaction_details as $detail)
                                                <tr>
                                                    <td>{{ $detail->product->product_code }}</td>
                                                    <td>{{ $detail->product->product_name }}</td>
                                                    <td>{{ $detail->product->unit_weight }}</td>
                                                    <td>Rp {{ number_format($detail->price) }}</td>
                                                    <td>{{ $detail->quantity }}</td>
                                                    <td>Rp {{ number_format($detail->subtotal) }}</td>
                                                </tr>
                                            @endforeach
                                            <tr>
                                                <td scope="row" colspan="5" class="grnd">Grand Total
                                                </td>
                                                <td class="grnd1">
                                                    Rp {{ number_format($transaction->grand_total) }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Pembayaran --}}
                <div class="tab-pane fade" id="step2">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="card shadow-tabl mb-4 crddet mx-2 col-md-6">
                                <div class="card-header btcolor py-3 d-flex flex-row justify-content-between">
                                    <h6 class="mt-0 font-weight-bold text-white"> Riwayat Pembayaran</h6>
                                    <h6 class=" mt-0 font-weight-bold text-white">{{ $transaction->invoice_code }}</h6>
                                </div>

                                <div class="card-body">
                                    @if (session('success'))
                                        <div class="alert alert-success alert-dismissible" id="flash_data" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                            {{ session('success') }}
                                        </div>
                                    @elseif (session('error'))
                                        <div class="alert alert-danger alert-dismissible" id="flash_data" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                            {{ session('error') }}
                                        </div>
                                    @endif
                                    @error('total_pay')
                                        <div class="alert alert-danger alert-dismissible" id="flash_data" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered" width="100%" cellspacing="0">
                                            <thead class="text-center align-middle">
                                                <tr>
                                                    <th>No.</th>
                                                    <th>Tanggal Bayar</th>
                                                    <th>Pembayaran</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            @php
                                                $i = 1;
                                            @endphp
                                            <tbody>
                                                @foreach ($transaction->payments->sortBy('created_at') as $payment)
                                                    <form action="{{ route('transaction.pay.edit', $payment->id) }}"
                                                        method="post">
                                                        @csrf
                                                        @method('put')
                                                        <tr>
                                                            <th class="text-center align-middle" scope="row">
                                                                {{ $i++ }}
                                                            </th>
                                                            <td class=" text-center align-middle">
                                                                {{ Carbon::parse($payment->created_at)->isoFormat('D MMMM Y HH:mm') }}
                                                            </td>
                                                            <td class="text-center align-middle col-4">
                                                                <span id="payment-amount-{{ $payment->id }}">
                                                                    -Rp {{ number_format($payment->total_pay) }}
                                                                </span>
                                                                <input type="text" name="total_pay"
                                                                    id="payment-input-{{ $payment->id }}"
                                                                    class="form-control d-none"
                                                                    value="{{ $payment->total_pay }}">
                                                            </td>
                                                            <td class="text-center align-middle">
                                                                <button type="button" class="btn btn-sm btn-success"
                                                                    onclick="toggleEdit({{ $payment->id }})"
                                                                    id="edit-button-{{ $payment->id }}">
                                                                    Edit
                                                                </button>
                                                                <div class="btn-group-vertical">
                                                                    <button type="button"
                                                                        class="btn btn-sm btn-danger d-none"
                                                                        onclick="toggleEdit({{ $payment->id }})"
                                                                        id="cancel-button-{{ $payment->id }}">
                                                                        Batal
                                                                    </button>
                                                                    <button type="submit"
                                                                        class="btn btn-sm btn-primary d-none"
                                                                        id="save-button-{{ $payment->id }}">
                                                                        Simpan
                                                                    </button>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </form>
                                                @endforeach

                                                @if ($transaction->delivery_status == 'sent' && $transaction->remaining_pay !== 0)
                                                    <form action="{{ route('transaction.pay', $transaction->id) }}"
                                                        method="post">
                                                        @csrf
                                                        <tr>
                                                            <td scope="row" class="text-center align-middle">
                                                                Bayar Cicilan
                                                            </td>
                                                            <td colspan="2" class="text-center align-middle">
                                                                <input class="form-control" type="text"
                                                                    name="total_pay" id="total_pay"
                                                                    placeholder="Masukkan Jumlah Cicilan">
                                                            </td>
                                                            <td class="text-center align-middle">
                                                                <button type="submit" id="payButton"
                                                                    class="btn btn-secondary mt-1"
                                                                    data-dismiss="modal">Bayar</button>
                                                            </td>
                                                        </tr>
                                                    </form>
                                                @endif

                                                <tr>
                                                    <td class="text-center align-middle" scope="row" colspan="2"
                                                        class="grnd">Total
                                                    </td>
                                                    <td class="grnd1 text-center">
                                                        -Rp
                                                        {{ number_format($transaction->payments->sum('total_pay')) }}
                                                    </td>
                                                    <td class="text-center align-middle">
                                                        <h3>-</h3>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-5 mb-4 hcb">
                                <div class="card border-success shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs text-center font-weight-bold mb-5">
                                                    <p class="jumlh">
                                                        Sisa Hutang
                                                    </p>
                                                    @if ($transaction->remaining_pay == 0)
                                                        <p class="total">
                                                            <span class="font-italic lunas-rotate">Lunas</span>
                                                        </p>
                                                    @else
                                                        <h2 class="total">
                                                            Rp {{ number_format($transaction->remaining_pay) }}
                                                        </h2>
                                                    @endif
                                                </div>
                                                <h6 class="mb-0 text-center font-weight-bold text-gray-800">
                                                    Total Hutang :
                                                    @if ($transaction->remaining_pay == 0)
                                                        <del> Rp {{ number_format($transaction->grand_total) }} </del>
                                                    @else
                                                        Rp {{ number_format($transaction->grand_total) }}
                                                    @endif
                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @if (isset($transaction->payment_method))
                    <div class="tab-pane fade" id="step3">
                        <div class="row justify-content-center">
                            <div class="card shadow-tabl mb-4 crddet mx-2 col-md-12">
                                <div class="card-header btcolor py-3 d-flex flex-row justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-white">Return Pesanan</h6>
                                    <h6 class=" mt-0 font-weight-bold text-white">
                                        {{ $transaction->invoice_code }}</h6>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered text-center" widht="100"
                                            cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>Kode Produk</th>
                                                    <th>Nama Produk</th>
                                                    <th>Product Saat Ini</th>
                                                    <th>Jumlah Return</th>
                                                    <th>Keterangan Return</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                @foreach ($transaction->transaction_details as $detail)
                                                    @if (isset($detail->return_id))
                                                        <tr>
                                                            <td>{{ $detail->product->product_code }}</td>
                                                            <td>{{ $detail->product->product_name }}</td>
                                                            <td>{{ $detail->quantity }}</td>
                                                            <td>{{ $detail->product_return->return }}</td>
                                                            <td>{{ $detail->product_return->description_return }}</td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        var id = @json(session('step', null));
        var triggerEl = document.querySelector(`#${id}-tab`)
        var tab = new bootstrap.Tab(triggerEl)
        tab.show()
    </script>
@endpush
