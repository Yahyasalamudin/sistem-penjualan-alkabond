<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TransactionDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'transaction_id' => $this->transaction_id,
            'product_id' => $this->product_id,
            'quantity' => $this->quantity,
            'price' => $this->price,
            'subtotal' => $this->subtotal,
            'product_code' => $this->product_code,
            'product_name' => $this->product_name,
            'product_brand' => $this->product_brand,
            'unit_weight' => $this->unit_weight,
            'return' => $this->return,
            'description_return' => $this->description_return,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
