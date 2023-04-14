<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = ['total_pay', 'invoice_code'];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'invoice_code', 'invoice_code');
    }
}
