<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['product_code', 'product_name', 'product_brand', 'unit_weight'];

    public function transaction_details()
    {
        return $this->hashMany(TransactionDetail::class, 'product_id', 'id');
    }
}
