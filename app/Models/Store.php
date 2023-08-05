<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;

    protected $fillable = ['store_name', 'address', 'store_number', 'sales_id', 'city_branch'];

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'store_id', 'id');
    }
}
