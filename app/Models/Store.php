<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function city_branch()
    {
        return $this->belongsTo(CityBranch::class);
    }

    public function sales()
    {
        return $this->belongsTo(Sales::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'store_id', 'id');
    }

    public function scopeFilterCity($query, $user, $city, $city_branch)
    {
        return $query->when(!empty($city), function ($query) use ($user, $city) {
            $query->when($user->role == 'owner', function ($query) use ($city) {
                $query->where('city_id', $city);
            });
        })->when($user->role == 'admin', function ($query) use ($user) {
            $query->where('city_id', $user->city_id);
        })->when(!empty($city_branch), function ($query) use ($city_branch) {
            $query->where('city_branch_id', $city_branch);
        });
    }
}
