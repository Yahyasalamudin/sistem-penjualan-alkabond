<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $primary = 'invoice_code';
    protected $guarded = [];

    public function sales()
    {
        return $this->belongsTo(Sales::class, 'sales_id', 'id');
    }

    public function stores()
    {
        return $this->belongsTo(Store::class, 'store_id', 'id');
    }

    public function transactionDetail()
    {
        return $this->hashMany(TransactionDetail::class, 'invoice_code', 'invoice_code');
    }

    public function payments()
    {
        return $this->hashMany(Payment::class, 'invoice_code', 'invoice_code');
    }
}
