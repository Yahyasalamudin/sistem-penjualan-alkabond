@extends('layouts.app')

@push('js')
    <script>
        let handleProcess = (id) => {
            let processForm = document.getElementById(`processForm-${id}`);
            processForm.submit();
        }

        let handleSend = (id) => {
            let sendForm = document.getElementById(`sendForm-${id}`);
            sendForm.submit();
        }

        let handleCancelTransaction = (id) => {
            let cancelTransactionForm = document.getElementById(`cancelTransactionForm-${id}`);
            cancelTransactionForm.submit();
        }

        let handleRestore = (id) => {
            let restoreForm = document.getElementById(`restoreForm-${id}`);
            restoreForm.submit();
        }

        let handleKill = (id) => {
            let killForm = document.getElementById(`killForm-${id}`);
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
    <h1 class="h3 mb-3 text-gray-800">{{ $title }}</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Table Transaksi</h6>

            @if ($status === 'unsent')
                <a href="{{ route('transaction.create', $status) }}" class="btn btcolor text-white">
                    <i class="fas fa-plus"></i>
                    Pre-Order
                </a>
            @endif
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
                        @foreach ($transactions as $key => $transaction)
                            <tr>
                                <th scope="row" class="position-relative">
                                    @if ($transaction['tenggatWaktu'] != '' && $transaction['tenggatWaktu'] <= 10 && $status === 'partial')
                                        <button type="button" class="btn p-0"
                                            style="position: absolute; top: 2px; right: 7px;" data-toggle="tooltip"
                                            data-placement="top"
                                            title="{{ $transaction['tenggatWaktu'] == 0 ? 'Transaksi ini telah mencapai batas waktu pembayaran' : 'Sisa Waktu Pembayaran Untuk Transaksi ini ' . $transaction['tenggatWaktu'] . ' Hari' }}">
                                            <i
                                                class="fas fa-exclamation-circle text-{{ $transaction['tenggatWaktu'] == 0 ? 'danger' : 'warning' }}"></i>
                                        </button>
                                    @endif
                                    {{ $key + 1 }}
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
                                            <form id="restoreForm-{{ $transaction->id }}"
                                                action="{{ route('transaction.restore', ['id' => $transaction->id]) }}"
                                                method="post">
                                                @csrf
                                                @method('put')
                                                <button type="button" class="btn btcolor ml-2 text-white"
                                                    onclick="showConfirmAlert('Apakah yakin ingin melanjutkan transaksi?', 'Restore', 'Transaksi dilanjutkan.', () => handleRestore({{ $transaction->id }}))">
                                                    Kembalikan Transaksi
                                                </button>
                                            </form>
                                            <form id="killForm-{{ $transaction->id }}"
                                                action="{{ route('transaction.kill', ['id' => $transaction->id]) }}"
                                                method="post">
                                                @csrf
                                                @method('delete')
                                                <button type="button" class="btn btn-danger ml-2 text-white"
                                                    onclick="showConfirmAlert('Apakah yakin ingin menghapus transaksi?', 'Hapus', 'Transaksi berhasil dihapus.', () => handleKill({{ $transaction->id }}))">
                                                    Hapus Transaksi
                                                </button>
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
                                                <form id="processForm-{{ $transaction->id }}"
                                                    action="{{ route('transaction.update', ['delivery_status' => 'proccess', 'id' => $transaction->id]) }}"
                                                    method="post">
                                                    @csrf
                                                    @method('put')
                                                    <button type="button" class="btn btcolor ml-2 text-white"
                                                        onclick="showConfirmAlert('Apakah yakin ingin memproses transaksi?', 'Lanjut', 'Transaksi berhasil diproses.', () => handleProcess({{ $transaction->id }}))">Proses</button>
                                                </form>
                                                <form id="cancelTransactionForm-{{ $transaction->id }}"
                                                    action="{{ route('transaction.destroy', ['delivery_status' => 'proccess', 'id' => $transaction->id]) }}"
                                                    method="post">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="button" class="btn btn-danger ml-2 text-white"
                                                        onclick="showConfirmAlert('Apakah yakin ingin membatal transaksi?', 'Lanjut', 'Transaksi berhasil dibatalkan.', () => handleCancelTransaction({{ $transaction->id }}))">
                                                        Batalkan
                                                    </button>
                                                </form>
                                            @elseif($transaction->delivery_status == 'proccess')
                                                <form id="sendForm-{{ $transaction->id }}"
                                                    action="{{ route('transaction.update', ['delivery_status' => 'sent', 'id' => $transaction->id]) }}"
                                                    method="post">
                                                    @csrf
                                                    @method('put')
                                                    <button type="button" class="btn btcolor ml-2 text-white"
                                                        onclick="showConfirmAlert('Apakah yakin transaksi sudah terkirim?', 'Lanjut', 'Transaksi berhasil terkirim.', () => handleSend({{ $transaction->id }}))">
                                                        Dikirim
                                                    </button>
                                                </form>
                                                <form id="cancelTransactionForm-{{ $transaction->id }}"
                                                    action="{{ route('transaction.destroy', ['delivery_status' => 'proccess', 'id' => $transaction->id]) }}"
                                                    method="post">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="button" class="btn btn-danger ml-2 text-white"
                                                        onclick="showConfirmAlert('Apakah yakin ingin membatal transaksi?', 'Lanjut', 'Transaksi berhasil dibatalkan.', () => handleCancelTransaction({{ $transaction->id }}))">Batalkan</button>
                                                </form>
                                            @endif
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
