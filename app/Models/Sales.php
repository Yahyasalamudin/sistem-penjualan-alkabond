<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Sales extends User
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = ['sales_name', 'username','email' ,'phone_number', 'password', 'city_branch'];
}
