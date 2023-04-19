<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductReturn extends Model
{
    use HasFactory;

    protected $fillable = ['return', 'description_return'];

    public function transaction_detail()
    {
        return $this->hasOne(TransactionDetail::class, 'return_id', 'id');
    }
}
