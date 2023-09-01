<?php

namespace App\Http\Traits;

use App\Models\ProductCart;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Carbon\Carbon;

trait TransactionTrait
{
    public function deadline($transactions)
    {
        $tenggatWaktu = "";
        foreach ($transactions as $transaction) {
            if (isset($transaction->sent_at)) {
                $sent_at = Carbon::createFromFormat('Y-m-d H:i:s', $transaction->sent_at);
                $tenggatWaktu = $sent_at->diffInDays(Carbon::now());
                $selisih = 30 - $tenggatWaktu;
                $transaction['tenggatWaktu'] = ($selisih >= 0) ? $selisih : 0;
            }
        }
    }

    public function invoiceCode()
    {
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

        return $invoice_code;
    }

    public function checkProductCart($request)
    {
        $product_carts = ProductCart::where('user_id', auth()->user()->id)->get();

        if ($product_carts->count() === 0) {
            return ['error' => 'Maaf, produk tidak boleh kosong. Mohon tambahkan produk terlebih dahulu.', 'store_id' => $request->store_id];
        }

        foreach ($product_carts as $product_cart) {
            if (empty($product_cart->quantity) || empty($product_cart->price)) {
                return ['error' => 'Mohon isi jumlah atau harga barang.', 'store_id' => $request->store_id];
            }
        }

        return ['success' => true, 'product_carts' => $product_carts];
    }

    public function createUpdateTransaction($product_carts, $check_transaction)
    {
        foreach ($product_carts as $pc) {
            $check_detail = TransactionDetail::where('transaction_id', $check_transaction['id'])->where('product_id', $pc->product_id)->first();
            if (empty($check_detail)) {
                TransactionDetail::create([
                    'transaction_id' => $check_transaction['id'],
                    'product_id' => $pc->product_id,
                    'quantity' => $pc->quantity,
                    'price' => $pc->price,
                    'subtotal' => $pc->quantity * $pc->price,
                ]);
            } else {
                $quantity_new = $pc->quantity + $check_detail['quantity'];
                $check_detail->update([
                    'quantity' => $quantity_new,
                    'subtotal' => $quantity_new * $check_detail['price']
                ]);
            }

            ProductCart::find($pc->id)->delete();
        }

        $grand_total = TransactionDetail::where('transaction_id', $check_transaction->id)->sum('subtotal');

        Transaction::where('id', $check_transaction->id)->update([
            'grand_total' => $grand_total,
            'remaining_pay' => $grand_total
        ]);
    }

    public function updatePayment($sum_totalpay, $transaction)
    {
        if ($sum_totalpay < $transaction->grand_total) {
            $transaction->update([
                'status' => 'partial'
            ]);

            if ($transaction->payments->count() == 0) {
                $transaction->update([
                    'payment_method' => null,
                    'status' => 'unpaid'
                ]);
            } else {
                $transaction->update([
                    'payment_method' => 'tempo'
                ]);
            }
        } elseif ($sum_totalpay == $transaction->grand_total) {
            $transaction->update([
                'status' => 'paid'
            ]);

            if ($transaction->payments->count() == 1) {
                $transaction->update([
                    'payment_method' => 'cash'
                ]);
            }
        }
    }
}
