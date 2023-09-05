<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = ['id', 'created_at', 'updated_at'];
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

    public function scopeFilterCity($query, $user, $city, $city_branch)
    {
        return $query->when(!empty($city), function ($query) use ($user, $city) {
            $query->when($user->role == 'owner', function ($query) use ($city) {
                $query->whereHas('sales', function ($query) use ($city) {
                    $query->where('city_id', $city);
                });
            });
        })->when($user->role == 'admin', function ($query) use ($user) {
            $query->whereHas('sales', function ($query) use ($user) {
                $query->where('city_id', $user->city_id);
            });
        })->when(!empty($city_branch), function ($query) use ($city_branch) {
            $query->whereHas('sales', function ($query) use ($city_branch) {
                $query->where('city_branch_id', $city_branch);
            });
        });
    }

    public function scopeStatus($query, $status)
    {
        switch ($status) {
            case 'unsent':
                $transactions = $query
                    ->where('status', 'unpaid')
                    ->where('delivery_status', 'unsent');
                break;
            case 'proccess':
                $transactions = $query
                    ->where('status', 'unpaid')
                    ->where('delivery_status', 'proccess');
                break;
                // case 'sent':
                //     $transactions = $query
                //         ->where('status', 'unpaid')
                //         ->where('delivery_status', 'sent');
                //     break;
            case 'partial':
                $transactions = $query
                    ->where('delivery_status', 'sent')
                    ->whereIn('status', ['partial', 'unpaid'])
                    ->where(function ($query) {
                        $query->whereIn('payment_method', ['tempo'])
                            ->orWhereNull('payment_method');
                    })
                    ->orderBy('sent_at', 'asc');
                break;
            case 'paid':
                $transactions = $query
                    ->where('status', 'paid')
                    ->where('delivery_status', 'sent');
                break;
        }

        return $transactions;
    }

    public function scopeFindUnpaidTransaction($query, $store)
    {
        return $query->where('store_id', $store->id)
            ->where('sales_id', $store->sales_id)
            ->where('status', 'unpaid')
            ->where('delivery_status', 'unsent');
    }

    public function scopeFindTransaction($query, $id)
    {
        return $query->with('transaction_details')
            ->with('transaction_details.product_return')
            ->with([
                'payments' => function ($query) {
                    $query->orderBy('created_at', 'desc')->orderBy('id', 'desc');
                }
            ])->find($id);
    }
}
