<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasApiTokens;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'is_admin',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

    public function scopeAmbassadors($query)
    {
        return $query->where('is_admin', 0);
    }

    public function scopeAdmins($query)
    {
        return $query->where('is_admin', 1);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class)->where('complete', 1);
    }

    public function getRevenueAttribute()
    {
        return $this->orders->sum(fn(Order $order) => $order->ambassador_revenue);
    }

    public function getNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}
