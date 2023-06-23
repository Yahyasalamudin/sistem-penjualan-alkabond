@extends('layouts.app')

@push('js')
    <script>
        let handleProcess = () => {
            let processForm = document.getElementById("processForm");
            processForm.submit();
        }

        let handleSend = () => {
            let sendForm = document.getElementById("sendForm");
            sendForm.submit();
        }

        let handleCancelTransaction = () => {
            let cancelTransactionForm = document.getElementById("cancelTransactionForm");
            cancelTransactionForm.submit();
        }

        let handleRestore = () => {
            let restoreForm = document.getElementById("restoreForm");
            restoreForm.submit();
        }

        let handleKill = () => {
            let killForm = document.getElementById("killForm");
            killForm.submit();
        }

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
                    // Swal.fire(
                    //     'Berhasil!',
                    //     successText,
                    //     'success'
                    // )
                }
            })
        }

        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
@endpush

@section('content')
    <h1 class="h3 mb-3 text-gray-800"> Transaksi</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Table Transaksi</h6>
        </div>

        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible" id="flash_data" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    {{ session('success') }}
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered text-center text-center" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Kode Transaksi</th>
                            <th>Toko</th>
                            <th>Alamat Toko</th>
                            <th>Nomer Toko</th>
                            <th>Kota</th>
                            <th>Total Harga</th>
                            <th>Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = 1;
                        @endphp
                        @foreach ($transactions as $transaction)
                            <tr>
                                <th scope="row" class="position-relative">
                                    @if ($transaction['tenggatWaktu'] <= 10 && $transaction['tenggatWaktu'] != '')
                                        <button type="button" class="btn p-0"
                                            style="position: absolute; top: 2px; right: 7px;" data-toggle="tooltip"
                                            data-placement="top"
                                            title="Sisa Waktu Pembayaran Untuk Transaksi ini {{ $transaction['tenggatWaktu'] }} Hari">
                                            <i class="fas fa-exclamation-circle text-warning"></i>
                                        </button>
                                    @endif
                                    {{ $i++ }}
                                </th>
                                <td>{{ $transaction->invoice_code }}</td>
                                <td>{{ $transaction->stores->store_name }}</td>
                                <td>{{ $transaction->stores->address }}</td>
                                <td>{{ $transaction->stores->store_number }}</td>
                                <td>{{ $transaction->stores->city_branch }}</td>
                                <td class="col-md-2">
                                    Rp {{ number_format($transaction->grand_total) }}
                                </td>
                                <td>
                                    @if (Request::is('transactions/archive*'))
                                        <div class="d-flex justify-content-center align-items-center">
                                            <form id="restoreForm"
                                                action="{{ route('transaction.restore', ['id' => $transaction->id]) }}"
                                                method="post">
                                                @csrf
                                                @method('put')
                                                <button type="button" class="btn btcolor ml-2 text-white"
                                                    onclick="showConfirmAlert('Apakah yakin ingin melanjutkan transaksi?', 'Restore', 'Transaksi dilanjutkan.', handleRestore)">Lanjutkan
                                                    Transaksi</button>
                                            </form>
                                            <form id="killForm"
                                                action="{{ route('transaction.kill', ['id' => $transaction->id]) }}"
                                                method="post">
                                                @csrf
                                                @method('delete')
                                                <button type="button" class="btn btn-danger ml-2 text-white"
                                                    onclick="showConfirmAlert('Apakah yakin ingin menghapus transaksi?', 'Hapus', 'Transaksi berhasil dihapus.', handleKill)">Hapus
                                                    Transaksi</button>
                                            </form>
                                        </div>
                                    @else
                                        <div class="d-flex justify-content-center align-items-center">
                                            @if ($transaction->status == 'unpaid')
                                                <a href="{{ route('transaction.show', ['status' => $transaction->delivery_status, 'id' => $transaction->id]) }}"
                                                    class="btn btn-warning">
                                                    Detail
                                                </a>
                                            @else
                                                <a href="{{ route('transaction.show', ['status' => $transaction->status, 'id' => $transaction->id]) }}"
                                                    class="btn  btn-warning">
                                                    Detail
                                                </a>
                                            @endif

                                            @if ($transaction->delivery_status == 'unsent')
                                                <form
                                                    action="{{ route('transaction.update', ['delivery_status' => 'proccess', 'id' => $transaction->id]) }}"
                                                    method="post">
                                                    @csrf
                                                    @method('put')
                                                    <button type="submit" class="btn btcolor ml-2 text-white"
                                                        onclick>Proses</button>
                                                </form>
                                            @elseif($transaction->delivery_status == 'proccess')
                                                <form
                                                    action="{{ route('transaction.update', ['delivery_status' => 'sent', 'id' => $transaction->id]) }}"
                                                    method="post">
                                                    @csrf
                                                    @method('put')
                                                    <button type="submit"
                                                        class="btn btcolor ml-2 text-white">Dikirim</button>
                                                </form>
                                            @endif
                                        </div>
                                    @endif
                                    >>>>>>>>> Temporary merge branch 2
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
