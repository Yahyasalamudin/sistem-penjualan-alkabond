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
            ->select('transactions.*', 'stores.*', 'sales.sales_name', 'sales.username', 'sales.email', 'sales.phone_number')
            ->orderByDesc('transactions.created_at')
            ->get();

        // dd($transactions);
        // 'sales.city_branch'
        // foreach ($transactions as $transaction) {
        //     $transactionDetail = TransactionDetail::where('invoice_code', $transaction->invoice_code)->get();
        // }
        // 'subdata' => new TransactionDetail($transactionDetail),

        return response()->json([
            'data' => TransactionResource::collection($transactions),
            'message' => 'Fetch all Transaction',
            'success' => true
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'store_id' => 'required',
            'status' => 'required',
            'details.*.product_id' => 'required',
            'details.*.quantity' => 'required',
            'details.*.price' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => [],
                'message' => $validator->errors(),
                'success' => false
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

        // $requests = $request->only('name');
        $check = Transaction::where('store_id', $request->store_id)
            ->where('sales_id', auth()->user()->id)
            ->where('delivery_status', 'unsent')
            ->first();
        if (empty($check)) {
            $transaction = Transaction::create([
                'invoice_code' => $invoice_code,
                'grand_total' => $request->grand_total,
                'store_id' => $request->store_id,
                'sales_id' => auth()->user()->id,
                'status' => $request->status,
            ]);
        }

        $invoice_last = Transaction::where('store_id', $request->store_id)
            ->where('sales_id', auth()->user()->id)
            ->where('delivery_status', 'unsent')
            ->first();

        foreach ($request->detail as $detail) {
            // var_dump($invoice_code);
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
            'success' => true
        ]);
    }

    public function show($invoice_code)
    {
        $transaction = Transaction::where('invoice_code', $invoice_code)->first();

        $transactionDetail = TransactionDetail::where('invoice_code', $transaction->invoice_code)->get();

        return response()->json([
            'data' => new TransactionResource($transaction),
            'subdata' => TransactionDetailResource::collection($transactionDetail),
            'message' => 'Data Transaction found',
            'success' => true
        ]);
    }

    public function payment(Request $request, $invoice_code)
    {
        $payment = Payment::create([
            'total_pay' => $request->total_pay,
            'invoice_code' => $invoice_code
        ]);

        $transaction = Transaction::where('invoice_code', $invoice_code)->first();
        $sum_check = Payment::where('invoice_code', $transaction->invoice_code)->sum('total_pay');

        if ((int)$sum_check < $transaction->grand_total) {
            Transaction::where('invoice_code', $invoice_code)->update([
                'status' => 'partial'
            ]);
        } else if ((int)$sum_check == $transaction->grand_total) {
            Transaction::where('invoice_code', $invoice_code)->update([
                'status' => 'paid'
            ]);
        }

        return response()->json([
            'data' => new PaymentResource($payment),
            'message' => 'Payment Transaction Successfully',
            'success' => true
        ]);
    }
}
