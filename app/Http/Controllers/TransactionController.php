<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\ProductCart;
use App\Models\Store;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    public function index($status)
    {
        $title = 'Daftar Transaksi';
        $user = auth()->user();
        $city = session('filterKota');

        $transactions = Transaction::when($user->role == 'owner', function ($query) use ($city) {
            $query->whereHas('sales', function ($query) use ($city) {
                $query->where('city', $city);
            });
        })
            ->when($user->role == 'admin', function ($query) use ($user) {
                $query->whereHas('sales', function ($query) use ($user) {
                    $query->where('city', $user->city);
                });
            });

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
                // case 'sent':
                //     $transactions = $transactions
                //         ->where('status', 'unpaid')
                //         ->where('delivery_status', 'sent');
                //     break;
            case 'partial':
                $transactions = $transactions
                    ->where('delivery_status', 'sent')
                    ->whereIn('status', ['partial', 'unpaid'])
                    ->where(function ($query) {
                        $query->whereIn('payment_method', ['tempo'])
                            ->orWhereNull('payment_method');
                    })
                    ->orderBy('sent_at', 'asc');
                break;
            case 'paid':
                $transactions = $transactions
                    ->where('status', 'paid')
                    ->where('delivery_status', 'sent');
                break;
        }

        $transactions = $transactions->get();

        $tenggatWaktu = "";
        foreach ($transactions as $transaction) {
            if (isset($transaction->sent_at)) {
                $sent_at = Carbon::createFromFormat('Y-m-d H:i:s', $transaction->sent_at);
                $tenggatWaktu = $sent_at->diffInDays(Carbon::now());
                $selisih = 30 - $tenggatWaktu;
                $transaction['tenggatWaktu'] = ($selisih >= 0) ? $selisih : 0;
            }
        }

        return view('transactions.index', compact('title', 'transactions', 'status'));
    }

    public function create()
    {
        $title = 'Tambah Transaksi';

        $city = session('filterKota');
        $role = auth()->user()->role;
        $cityFilter = ($role == 'owner') ? $city : auth()->user()->city;

        $stores = Store::where('city_branch', $cityFilter)->latest()->get();

        return view('transactions.create', compact('stores'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'store_id' => 'required',
            'details' => 'requiered|array',
            'details.*.product_id' => 'required',
            // 'details.*.quantity' => 'required',
            'details.*.price' => 'required',
        ], [], [
            'store_id' => 'Toko'
        ]);

        $now = Carbon::now();
        $date = date('Ym', strtotime($now));
        $check = Transaction::count();
        if ($check == 0) {
            $code = 100001;
            $invoice_code = 'INV' . $date . $code;
        } else {
            $query = Transaction::all()->last();

            $check_date = substr($query->invoice_code, 0, -6);
            $int_date = (int) substr($check_date, 3);

            if ($date != $int_date) {
                $code = 100001;
                $invoice_code = 'INV' . $date . $code;
            } else {
                $code = (int) substr($query->invoice_code, -6) + 1;
                $invoice_code = 'INV' . $date . $code;
            }
        }

        $check = Transaction::where('store_id', $request->store_id)
            ->where('sales_id', auth()->user()->id)
            ->where('status', 'unpaid')
            ->where('delivery_status', 'unsent')
            ->first();

        if (empty($check)) {
            $transaction = Transaction::create([
                'invoice_code' => $invoice_code,
                'store_id' => $request->store_id,
                'sales_id' => auth()->user()->id
            ]);
        }

        $check_transactions = Transaction::where('store_id', $request->store_id)
            ->where('sales_id', auth()->user()->id)
            ->where('status', 'unpaid')
            ->where('delivery_status', 'unsent')
            ->first();

        $product_cart = ProductCart::where('user_id', auth()->user()->id)->get();

        foreach ($product_cart as $pc) {
            $check_detail = TransactionDetail::where('transaction_id', $check_transactions['id'])->where('product_id', $pc->product_id)->first();
            if (empty($check_detail)) {
                $transaction = TransactionDetail::create([
                    'transaction_id' => $check_transactions['id'],
                    'product_id' => $pc->product_id,
                    'quantity' => $pc->quantity,
                    'price' => $pc->price,
                    'subtotal' => $pc->quantity * $pc->price,
                ]);
            } else {
                $quantity_new = $pc->quantity + $check_detail['quantity'];
                $transaction = $check_detail->update([
                    'quantity' => $quantity_new,
                    'subtotal' => $quantity_new * $check_detail['price']
                ]);
            }

            ProductCart::find($pc->id)->delete();
        }

        $grand_total = TransactionDetail::where('transaction_id', $check_transactions->id)->sum('subtotal');

        Transaction::where('id', $check_transactions->id)->update([
            'grand_total' => $grand_total,
            'remaining_pay' => $grand_total
        ]);

        $transaction = Transaction::with('transaction_details')
            ->with('payments')
            ->find($check_transactions->id);

        return redirect('/transactions/unsent')->with('success', 'Transaksi Berhasil ditambahkan!');
    }

    public function archive()
    {
        $title = 'Daftar Arsip Transaksi';
        $user = auth()->user();
        $city = session('filterKota');
        $status = 'archive';

        $transactions = Transaction::onlyTrashed()
            ->when($user->role == 'owner', function ($query) use ($city) {
                $query->whereHas('sales', function ($query) use ($city) {
                    $query->where('city', $city);
                });
            })
            ->when($user->role == 'admin', function ($query) use ($user) {
                $query->whereHas('sales', function ($query) use ($user) {
                    $query->where('city', $user->city);
                });
            })
            ->get();

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
            return Redirect::to(URL::previous() . "#step2")->with('error', 'Data Transaksi sudah lunas');
        }

        $transaction = Transaction::find($id);
        $sum_totalpay = Payment::where('transaction_id', $id)->sum('total_pay');

        $total_pay = str_replace(['Rp. ', '.', ','], '', $request->total_pay);
        $check_pay = $sum_totalpay + $total_pay;

        if ((int) $total_pay > $transaction->remaining_pay) {
            return Redirect::to(URL::previous() . "#step2")->with('error', 'Pembayaran tidak boleh melebihi sisa hutang');
        }

        $lastPayment = Payment::where('transaction_id', $id)
            ->where('total_pay', $total_pay)
            ->where('created_at', '>', Carbon::now()->subSeconds(5))
            ->first();

        if ($lastPayment) {
            return Redirect::to(URL::previous() . "#step2")->with('error', 'Pembayaran hanya bisa dilakukan sekali dalam 5 detik. Mohon coba lagi jika perlu.');
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

        return Redirect::to(URL::previous() . "#step2")->with('success', 'Pembayaran berhasil');
    }
}
