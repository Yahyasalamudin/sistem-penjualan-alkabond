<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SalesResource extends JsonResource
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
            'sales_name' => $this->sales_name,
            'username' => $this->username,
            'phone_number' => $this->phone_number,
            'password' => $this->password,
            'city_branch' => $this->city_branch,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
