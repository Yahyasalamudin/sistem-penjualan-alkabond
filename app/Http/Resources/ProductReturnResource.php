<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductReturnResource extends JsonResource
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
            'detail_id' => $this->detail_id,
            'return' => $this->return,
            'description_return' => $this->description_return,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
