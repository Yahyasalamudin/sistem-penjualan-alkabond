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
            'invoice_code' => $this->invoice_code,
            'grand_total' => $this->grand_total,
            'store_id' => $this->store_id,
            'sales_id' => $this->sales_id,
            'payment_method' => $this->payment_method,
            'status' => $this->status,
            'delivery_status' => $this->delivery_status,
            // 'store_name' => $this->store_name,
            // 'address' => $this->address,
            // 'store_number' => $this->store_number,
            // 'city_branch' => $this->city_branch,
            // 'sales_name' => $this->sales_name,
            // 'username' => $this->username,
            // 'email' => $this->email,
            // 'phone_number' => $this->phone_number,
            // 'city' => $this->city,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'detail_transaction' => $this->transaction_details->map(function ($detail) {
                return [
                    'id' => $detail->id,
                    'invoice_code' => $detail->invoice_code,
                    'product_id' => $detail->product_id,
                    'quantity' => $detail->quantity,
                    'price' => $detail->price,
                    'subtotal' => $detail->subtotal,
                    'product_code' => $detail->product_code,
                    'product_name' => $detail->product_name,
                    'product_brand' => $detail->product_brand,
                    'unit_weight' => $detail->unit_weight,
                    'created_at' => $detail->created_at,
                    'updated_at' => $detail->updated_at,
                ];
            }),
        ];
    }
}
