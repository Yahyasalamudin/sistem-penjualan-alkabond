<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PaymentResource;
use App\Http\Resources\TransactionDetailResource;
use App\Http\Resources\TransactionResource;
use App\Models\Payment;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = DB::table('transactions')
            ->join('stores', 'transactions.store_id', 'stores.id')
            ->join('sales', 'transactions.sales_id', 'sales.id')
            ->select('transactions.*', 'stores.*', 'sales.sales_name', 'sales.username', 'sales.email', 'sales.phone_number', 'sales.city')
            ->orderByDesc('transactions.created_at')
            ->get();

        return response()->json([
            'data' => TransactionResource::collection($transactions),
            'message' => 'Fetch all Transaction',
            'status_code' => 200
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'store_id' => 'required',
            'grand_total' => 'required',
            'details' => 'requiered|array',
            'details.*.product_id' => 'required',
            'details.*.quantity' => 'required',
            'details.*.price' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => [],
                'message' => $validator->errors(),
                'status_code' => 403
            ]);
        }

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
            ->where('delivery_status', 'unsent')
            ->first();

        if (empty($check)) {
            $transaction = Transaction::create([
                'invoice_code' => $invoice_code,
                'grand_total' => $request->grand_total,
                'store_id' => $request->store_id,
                'sales_id' => auth()->user()->id
            ]);
        }

        $invoice_last = Transaction::where('store_id', $request->store_id)
            ->where('sales_id', auth()->user()->id)
            ->where('delivery_status', 'unsent')
            ->first();

        foreach ($request->detail as $detail) {
            $transaction = TransactionDetail::create([
                'invoice_code' => $invoice_last['invoice_code'],
                'product_id' => $detail['product_id'],
                'quantity' => $detail['quantity'],
                'price' => $detail['price'],
                'subtotal' => $detail['quantity'] * $detail['price'],
            ]);
        }

        return response()->json([
            'data' => new TransactionResource($transaction),
            'message' => 'Transaction Created successfully',
            'status_code' => 200
        ]);
    }

    public function show($invoice_code)
    {
        $transaction = DB::table('transactions')
            ->where('invoice_code', $invoice_code)
            ->join('stores', 'transactions.store_id', 'stores.id')
            ->join('sales', 'transactions.sales_id', 'sales.id')
            ->select('transactions.*', 'stores.*', 'sales.sales_name', 'sales.username', 'sales.email', 'sales.phone_number', 'sales.city')
            ->orderByDesc('transactions.created_at')
            ->first();

        $transactionDetail = DB::table('transaction_details')
            ->where('invoice_code', $transaction->invoice_code)
            ->join('products', 'transaction_details.product_id', 'products.id')
            ->select('transaction_details.*', 'products.product_code', 'products.product_code', 'products.product_name', 'products.product_brand', 'products.unit_weight')
            ->get();

        return response()->json([
            'data' => new TransactionResource($transaction),
            'subdata' => TransactionDetailResource::collection($transactionDetail),
            'message' => 'Data Transaction found',
            'status_code' => 200
        ]);
    }

    public function payment(Request $request, $invoice_code)
    {
        $check = Transaction::where('invoice_code', $invoice_code)->first();

        if ($check->status == 'paid') {
            return response()->json([
                'message' => 'Transaction has been paid',
                'status_code' => 401
            ]);
        }

        $transaction = Transaction::where('invoice_code', $invoice_code)->first();
        $sum_totalpay = Payment::where('invoice_code', $transaction->invoice_code)->sum('total_pay');

        $check_pay = $sum_totalpay + $request->total_pay;

        if ((int)$check_pay > $transaction->grand_total) {
            return response()->json([
                'message' => 'Transaction may not exceed the grand total',
                'status_code' => 401
            ]);
        }

        $payment = Payment::create([
            'total_pay' => $request->total_pay,
            'invoice_code' => $invoice_code
        ]);

        if ((int)$check_pay < $transaction->grand_total) {
            Transaction::where('invoice_code', $invoice_code)->update([
                'status' => 'partial'
            ]);

            Transaction::where('invoice_code', $invoice_code)->where('payment_method', null)->update([
                'payment_method' => 'tempo'
            ]);
        } else if ((int)$check_pay == $transaction->grand_total) {
            Transaction::where('invoice_code', $invoice_code)->update([
                'status' => 'paid'
            ]);

            Transaction::where('invoice_code', $invoice_code)->where('payment_method', null)->update([
                'payment_method' => 'cash'
            ]);
        }

        return response()->json([
            'data' => new PaymentResource($payment),
            'message' => 'Payment Transaction Successfully',
            'status_code' => 200
        ]);
    }

    public function return($id)
    {
        //
    }
}
