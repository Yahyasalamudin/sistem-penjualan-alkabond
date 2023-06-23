<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = ['id'];
    protected $dates = ['deleted_at'];

    public function sales()
    {
        return $this->belongsTo(Sales::class, 'sales_id', 'id');
    }

    public function stores()
    {
        return $this->belongsTo(Store::class, 'store_id', 'id');
    }

    public function transaction_details()
    {
        return $this->hasMany(TransactionDetail::class, 'transaction_id', 'id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'transaction_id', 'id');
    }
}
