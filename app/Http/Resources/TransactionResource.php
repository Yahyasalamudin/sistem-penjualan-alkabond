<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'invoice_code' => $this->invoice_code,
            'grand_total' => (int)$this->grand_total,
            'remaining_pay' => (int)$this->remaining_pay,
            'store_id' => (int)$this->store_id,
            'sales_id' => (int)$this->sales_id,
            'payment_method' => $this->payment_method,
            'status' => $this->status,
            'delivery_status' => $this->delivery_status,
            'city' => $this->sales->city->city,
            'store_name' => $this->stores->store_name,
            'address' => $this->stores->address,
            'store_number' => $this->stores->store_number,
            'city_branch_store' => $this->stores->city_branch->branch,
            'sales_name' => $this->sales->sales_name,
            'username' => $this->sales->username,
            'email' => $this->sales->email,
            'phone_number' => $this->sales->phone_number,
            'city' => $this->sales->city->city,
            'city_branch_sales' => $this->sales->city_branch->branch,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'payments' => $this->payments->map(function ($payment) {
                return [
                    'id' => $payment->id,
                    'total_pay' => (int)$payment->total_pay,
                    'transaction_id' => (int)$payment->transaction_id,
                    'created_at' => $payment->created_at,
                    'updated_at' => $payment->updated_at,
                ];
            }),
            'transaction_details' => $this->transaction_details->map(function ($detail) {
                return [
                    'id' => $detail->id,
                    'transaction_id' => (int)$detail->transaction_id,
                    'product_id' => (int)$detail->product_id,
                    'quantity' => (int)$detail->quantity,
                    'price' => (int)$detail->price,
                    'subtotal' => (int)$detail->subtotal,
                    'product_code' => $detail->product->product_code,
                    'product_name' => $detail->product->product_name,
                    'product_brand' => $detail->product->product_brand,
                    'unit_weight' => $detail->product->unit_weight,
                    'created_at' => $detail->created_at,
                    'updated_at' => $detail->updated_at,
                    'returns' => $detail->product_return,
                ];
            }),
        ];
    }
}
