<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'code',
        'ambassador_email',
        'first_name',
        'last_name',
        'email',
        'address',
        'city',
        'country',
        'zip',
        'complete',
        'user_id',
    ];

    public function getNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getAdminRevenueAttribute(): string
    {
        return $this->orderItems->sum(fn(OrderItem $item) => $item->admin_revenue);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
