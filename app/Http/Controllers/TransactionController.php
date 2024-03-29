<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Store;
use App\Models\Transaction;
use App\Http\Traits\TransactionTrait;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    use TransactionTrait;

    public function index($status)
    {
        $title = 'Daftar Transaksi';
        $user = auth()->user();
        $city = session('filter-city');
        $city_branch = session('filter-city-branch');

        $transactions = Transaction::filterCity($user, $city, $city_branch)->status($status)->get();

        $this->deadline($transactions);

        return view('transactions.index', compact('title', 'transactions', 'status'));
    }

    public function create()
    {
        $title = 'Tambah Transaksi';

        $user = auth()->user();
        $city = session('filter-city');
        $city_branch = session('filter-city-branch');

        $stores = Store::filterCity($user, $city, $city_branch)->get();

        return view('transactions.create', compact('stores'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'store_id' => 'required'
        ]);

        $invoice_code = $this->invoiceCode();
        $store = Store::find($request->store_id);
        $check = Transaction::findUnpaidTransaction($store)->first();
        $result = $this->checkProductCart($request);

        if (isset($result['error'])) {
            return redirect()->back()->with($result);
        }

        $product_carts = $result['product_carts'];

        if (empty($check)) {
            Transaction::create([
                'invoice_code' => $invoice_code,
                'store_id' => $request->store_id,
                'sales_id' => $store->sales_id
            ]);
        }

        $check_transaction = Transaction::findUnpaidTransaction($store)->first();
        $this->createUpdateTransaction($product_carts, $check_transaction);

        return redirect('/transactions/unsent')->with('success', 'Transaksi Berhasil ditambahkan!');
    }

    public function archive()
    {
        $title = 'Daftar Arsip Transaksi';
        $user = auth()->user();
        $city = session('filter-city');
        $city_branch = session('filter-city-branch');
        $status = 'archive';

        $transactions = Transaction::onlyTrashed()->filterCity($user, $city, $city_branch)->get();

        return view('transactions.index', compact('title', 'status', 'transactions'));
    }

    public function restore($id)
    {
        $transactions = Transaction::onlyTrashed()->find($id);
        $transactions->restore();

        return back()->with('success', 'Berhasil melanjutkan transaksi.');
    }

    public function kill($id)
    {
        $transactions = Transaction::onlyTrashed()->find($id);
        $transactions->forceDelete();

        return back()->with('success', 'Berhasil menghapus transaksi.');
    }

    public function show($status, Transaction $transaction)
    {
        return view('transactions.detail', compact('transaction'));
    }

    public function update_delivery($delivery_status, $id)
    {
        if ($delivery_status == 'proccess') {
            Transaction::find($id)->update([
                'delivery_status' => 'proccess'
            ]);

            return back()->with('success', 'Pesanan dalam pengiriman.');
        } else {
            Transaction::find($id)->update([
                'delivery_status' => 'sent',
                'sent_at' => Carbon::now()
            ]);

            return back()->with('success', 'Pesanan telah sampai kepada penerima.');
        }
    }

    public function destroy($id)
    {
        Transaction::find($id)->delete();

        return back()->with('success', 'Data Transaksi berhasil dibatalkan');
    }

    public function payment(Request $request, $id)
    {
        $request->validate([
            'total_pay' => 'required'
        ]);

        $check = Transaction::find($id);

        if ($check->status == 'paid') {
            return redirect()->back()->with(['step' => 'step2', 'error' => 'Transaksi sudah lunas']);
        }

        $transaction = Transaction::find($id);
        $sum_totalpay = Payment::where('transaction_id', $id)->sum('total_pay');

        $total_pay = str_replace(['Rp. ', '.', ','], '', $request->total_pay);
        $check_pay = $sum_totalpay + $total_pay;

        if ((int) $total_pay > $transaction->remaining_pay) {
            return redirect()->back()->with(['step' => 'step2', 'error' => 'Pembayaran tidak boleh melebihi sisa hutang']);
        }

        $lastPayment = Payment::where('transaction_id', $id)
            ->where('total_pay', $total_pay)
            ->where('created_at', '>', Carbon::now()->subSeconds(5))
            ->first();

        if ($lastPayment) {
            return redirect()->back()->with(['step' => 'step2', 'success' => 'Pembayaran berhasil']);
        }

        Payment::create([
            'total_pay' => $total_pay,
            'transaction_id' => $id
        ]);

        $remaining_pay = $transaction->remaining_pay - $total_pay;

        if ((int) $check_pay < $transaction->grand_total) {
            Transaction::find($id)->update([
                'status' => 'partial',
                'remaining_pay' => $remaining_pay
            ]);

            if ($transaction->payment_method == null) {
                Transaction::find($id)->update([
                    'payment_method' => 'tempo'
                ]);
            }
        } else if ((int) $check_pay == $transaction->grand_total) {
            Transaction::find($id)->update([
                'status' => 'paid',
                'remaining_pay' => $remaining_pay
            ]);

            if ($transaction->payment_method == null) {
                Transaction::find($id)->update([
                    'payment_method' => 'cash'
                ]);
            }
        }

        return redirect()->back()->with(['step' => 'step2', 'success' => 'Pembayaran berhasil']);
    }

    public function edit_payment(Request $request, $id)
    {
        $payment = Payment::find($id);
        $transaction = Transaction::find($payment->transaction_id);
        $total_pay = $request->total_pay ? str_replace(['Rp. ', '.', ','], '', $request->total_pay) : 0;

        if ($payment->total_pay > $total_pay) {
            $pay = $payment->total_pay - $total_pay;

            $transaction->update([
                'remaining_pay' => $transaction->remaining_pay + $pay
            ]);
        } else {
            $pay = $total_pay - $payment->total_pay;

            if ($pay > $transaction->remaining_pay) {
                return redirect()->back()->with(['step' => 'step2', 'error' => 'Pembayaran tidak boleh melebihi sisa hutang']);
            }

            $transaction->update([
                'remaining_pay' => $transaction->remaining_pay - $pay
            ]);
        }

        if ($total_pay == 0) {
            $payment->delete();
        } else {
            $payment->update([
                'total_pay' => $total_pay
            ]);
        }

        $sum_totalpay = Payment::where('transaction_id', $transaction->id)->sum('total_pay');
        $this->updatePayment($sum_totalpay, $transaction);

        return redirect()->back()->with(['step' => 'step2', 'success' => 'Pembayaran berhasil diubah']);
    }
}
