<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function scopeUserId($query, $user_id)
    {
        return $query->where('user_id', $user_id);
    }
}
