<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index($status)
    {
        $transactions = Transaction::latest()->get();

        switch ($status) {
            case 'unsent':
                $transactions = $transactions
                    ->where('status', 'unpaid')
                    ->where('delivery_status', 'unsent');
                break;
            case 'proccess':
                $transactions = $transactions
                    ->where('status', 'unpaid')
                    ->where('delivery_status', 'proccess');
                break;
            case 'sent':
                $transactions = $transactions
                    ->where('status', 'unpaid')
                    ->where('delivery_status', 'sent');
                break;
            case 'partial':
                $transactions = $transactions
                    ->where('payment_method', 'tempo')
                    ->where('status', 'partial');
                break;
            case 'paid':
                $transactions = $transactions
                    ->where('status', 'paid')
                    ->where('delivery_status', 'sent');
                break;
        }

        return view('transactions.index', compact('transactions'));
    }

    public function archive()
    {
        $transactions = Transaction::onlyTrashed()->get();

        return view('transactions.index', compact('transactions'));
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

    public function show($status, $id)
    {
        $transaction = Transaction::with('transaction_details')
            ->with('transaction_details.product_return')
            ->with([
                'payments' => function ($query) {
                    $query->orderBy('created_at', 'desc')->orderBy('id', 'desc');
                }
            ])->find($id);

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
                'delivery_status' => 'sent'
            ]);

            return back()->with('success', 'Pesanan telah sampai kepada penerima.');
        }
    }

    public function destroy($id)
    {
        Transaction::find($id)->delete();

        return back()->with('success', 'Data Transaksi berhasil dihapus');
    }
}
