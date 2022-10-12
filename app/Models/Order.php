<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
