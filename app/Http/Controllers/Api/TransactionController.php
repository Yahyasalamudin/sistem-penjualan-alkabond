<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TransactionResource;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    public function index()
    {
        $transaction = Transaction::latest()->get();

        return response()->json([
            'data' => TransactionResource::collection($transaction),
            'message' => 'Fetch all Transaction',
            'success' => true
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required',
            'quantity' => 'required',
            'price' => 'required',
            'total' => 'required',
            'store_id' => 'required',
            'payment_method' => 'required',
            'status' => 'required',
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
            $code = 10000001;
            $invoice_code = 'INV' . $date . $code;
        } else {
            $query = Transaction::all()->last();

            $check_date = substr($query->invoice_code, 0, -8);
            $int_date = (int)substr($check_date, 3);

            if ($date != $int_date) {
                $code = 10000001;
                $invoice_code = 'INV' . $date . $code;
            } else {
                $code = (int)substr($query->invoice_code, -8) + 1;
                $invoice_code = 'INV' . $date . $code;
            }
        }

        $transaction = Transaction::create([
            'invoice_code' => $invoice_code,
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'price' => $request->price,
            'total' => $request->total,
            'store_id' => $request->store_id,
            'payment_method' => $request->payment_method,
            'status' => $request->status,
        ]);

        return response()->json([
            'data' => new TransactionResource($transaction),
            'message' => 'Transaction Created successfully',
            'success' => true
        ]);
    }

    public function show(Transaction $transaction)
    {
        return response()->json([
            'data' => new TransactionResource($transaction),
            'message' => 'Data Transaction found',
            'success' => true
        ]);
    }

    public function update(Request $request, Transaction $transaction)
    {
        $validator = Validator::make($request->all(), [
            'quantity' => 'required',
            'price' => 'required',
            'total' => 'required',
            'payment_method' => 'required',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => [],
                'message' => $validator->errors(),
                'success' => false
            ]);
        }

        $transaction->update([
            'quantity' => $request->quantity,
            'price' => $request->price,
            'total' => $request->total,
            'payment_method' => $request->payment_method,
            'status' => $request->status,
        ]);

        return response()->json([
            'data' => new TransactionResource($transaction),
            'message' => 'Transaction Updated successfully',
            'success' => true
        ]);
    }

    public function destroy(Transaction $transaction)
    {
        $transaction->delete();

        return response()->json([
            'data' => new TransactionResource($transaction),
            'message' => 'Transaction Deleted successfully',
            'success' => true
        ]);
    }
}
