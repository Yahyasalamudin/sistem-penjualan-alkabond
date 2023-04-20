<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PaymentResource;
use App\Http\Resources\TransactionDetailResource;
use App\Http\Resources\TransactionResource;
use App\Models\Payment;
use App\Models\ProductReturn;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    public function index($filter)
    {
        $transactions = Transaction::with('transaction_details')->with('payments')->get();

        // filter
        switch ($filter) {
            case 'process':
                $transactions = $transactions->where('delivery_status', 'proccess');
                break;
            case 'onsent':
                $transactions = $transactions->where('delivery_status', 'sent');
                break;
            case 'tempo':
                $transactions = $transactions->where('payment_method', 'tempo');
                break;
            case 'done':
                $transactions = $transactions->where('status', 'paid');
                break;
            default:
                $transactions = $transactions->where('delivery_status', 'unsent');
                break;
        }

        if ($transactions) {
            return response()->json([
                'data' => TransactionResource::collection($transactions),
                'message' => 'Fetch all Transaction',
                'status_code' => 200
            ]);
        } else {
            return response()->json([
                'message' => 'Transaction Not Found',
                'status_code' => 404
            ]);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'store_id' => 'required',
            'details' => 'requiered|array',
            'details.*.product_id' => 'required',
            // 'details.*.quantity' => 'required',
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
                'grand_total' => 0,
                'store_id' => $request->store_id,
                'sales_id' => auth()->user()->id
            ]);
        }

        $check_transactions = Transaction::where('store_id', $request->store_id)
            ->where('sales_id', auth()->user()->id)
            ->where('delivery_status', 'unsent')
            ->first();

        foreach ($request->detail as $detail) {
            $check_detail = TransactionDetail::where('transaction_id', $check_transactions['id'])->where('product_id', $detail['product_id'])->first();
            if (empty($check_detail)) {
                $transaction = TransactionDetail::create([
                    'transaction_id' => $check_transactions['id'],
                    'product_id' => $detail['product_id'],
                    'quantity' => $detail['quantity'],
                    'price' => $detail['price'],
                    'subtotal' => $detail['quantity'] * $detail['price'],
                ]);
            } else {
                $quantity_new = $detail['quantity'] + $check_detail['quantity'];
                $transaction = $check_detail->update([
                    'quantity' => $quantity_new,
                    'subtotal' => $quantity_new * $check_detail['price']
                ]);
            }
        }

        $grand_total = TransactionDetail::where('transaction_id', $check_transactions->id)->sum('subtotal');

        Transaction::where('id', $check_transactions->id)->update([
            'grand_total' => $grand_total
        ]);

        $transaction = Transaction::with('transaction_details')
            ->with('payments')
            ->find($check_transactions->id);

        return response()->json([
            'data' => new TransactionResource($transaction),
            'message' => 'Transaction Created successfully',
            'status_code' => 200
        ]);
    }

    public function show($id)
    {
        $transaction = Transaction::with('transaction_details')
            // ->leftJoin('product_returns', function ($join) {
            //     $join->on('transaction_details.return_id', '=', 'product_returns.id');
            // })
            // $transaction = Transaction::with([
            //     'transaction_details' => function ($query) {
            //         $query->leftJoin('product_returns', 'transaction_details.return_id', '=', 'product_returns.id');
            //     }
            // ])
            // ->whereNull('product_returns.id')
            ->with('transaction_details.product_return')
            ->with('payments')->find($id);

        // dd($transaction);

        return response()->json([
            'data' => new TransactionResource($transaction),
            'message' => 'Data Transaction found',
            'status_code' => 200
        ]);
    }

    public function payment(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'total_pay' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => [],
                'message' => $validator->errors(),
                'status_code' => 403
            ]);
        }

        $check = Transaction::find($id);

        if ($check->status == 'paid') {
            return response()->json([
                'message' => 'Transaction has been paid',
                'status_code' => 401
            ]);
        }

        $transaction = Transaction::find($id);
        $sum_totalpay = Payment::where('transaction_id', $id)->sum('total_pay');

        $check_pay = $sum_totalpay + $request->total_pay;

        if ((int) $check_pay > $transaction->grand_total) {
            return response()->json([
                'message' => 'Transaction may not exceed the grand total',
                'status_code' => 401
            ]);
        }

        $payment = Payment::create([
            'total_pay' => $request->total_pay,
            'transaction_id' => $id
        ]);

        if ((int) $check_pay < $transaction->grand_total) {
            Transaction::find($id)->update([
                'status' => 'partial'
            ]);

            if ($transaction->payment_method == null) {
                Transaction::find($id)->update([
                    'payment_method' => 'tempo'
                ]);
            }
        } else if ((int) $check_pay == $transaction->grand_total) {
            Transaction::find($id)->update([
                'status' => 'paid'
            ]);

            if ($transaction->payment_method == null) {
                Transaction::find($id)->update([
                    'payment_method' => 'cash'
                ]);
            }
        }

        return response()->json([
            'data' => new PaymentResource($payment),
            'message' => 'Payment Transaction Successfully',
            'status_code' => 200
        ]);
    }

    public function storeReturn(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'return' => 'required|numeric',
            'description_return' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => [],
                'message' => $validator->errors(),
                'status_code' => 403
            ]);
        }

        $transactionDetail = TransactionDetail::find($id);

        if ($transactionDetail->quantity < $request->return) {
            return response()->json([
                'message' => 'Product return cannot exceed the purchase limit',
                'status_code' => 401
            ]);
        }

        $productReturn = ProductReturn::create([
            'return' => $request->return,
            'description_return' => $request->description_return
        ]);

        $transactionDetail->update([
            'return_id' => $productReturn->id
        ]);

        $return = ProductReturn::where('id', $transactionDetail->return_id)->first();

        $quantity = $transactionDetail->quantity - $return->return;
        $return_price = $return->return * $transactionDetail->price;
        $subtotal = $transactionDetail->subtotal - $return_price;

        $transaction = Transaction::where('id', $transactionDetail->transaction_id)->first();

        Transaction::where('id', $transactionDetail->transaction_id)->update([
            'grand_total' => $transaction->grand_total - $return_price,
        ]);

        $transactionDetail->update([
            'quantity' => $quantity,
            'subtotal' => $subtotal,
        ]);

        $transaction_detail = DB::table('transaction_details')
            ->where('transaction_details.id', $id)
            ->join('products', 'transaction_details.product_id', 'products.id')
            ->join('product_returns', 'transaction_details.return_id', 'product_returns.id')
            ->select('transaction_details.*', 'products.product_code', 'products.product_code', 'products.product_name', 'products.product_brand', 'products.unit_weight', 'product_returns.return', 'product_returns.description_return')
            ->first();

        return response()->json([
            'data' => new TransactionDetailResource($transaction_detail),
            'message' => 'Data Return has been created successfully ',
            'status_code' => 200
        ]);
    }

    public function destroyReturn($id)
    {
        $transactionDetail = TransactionDetail::find($id);
        $return = ProductReturn::where('id', $transactionDetail->return_id)->first();

        $sum_quantity = $transactionDetail->quantity + $return->return;
        $return_price = $transactionDetail->price * $return->return;
        $subtotal = $transactionDetail->subtotal + $return_price;

        $transaction = Transaction::where('invoice_code', $transactionDetail->invoice_code)->first();

        Transaction::where('invoice_code', $transactionDetail->invoice_code)->update([
            'grand_total' => $transaction->grand_total + $return_price,
        ]);

        $transactionDetail->update([
            'quantity' => $sum_quantity,
            'subtotal' => $subtotal,
        ]);

        $return->delete();

        return response()->json([
            'data' => [],
            'message' => 'Data Return has been deleted successfully ',
            'status_code' => 200
        ]);
    }
}