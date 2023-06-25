<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Sales extends User
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = ['sales_name', 'username', 'email', 'phone_number', 'password', 'city', 'active'];

    public function transactions()
    {
        return $this->hashMany(Transaction::class, 'sales_id', 'id');
    }
}
