<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        return response([
            'status' => true,
            'orders' => OrderResource::collection(Order::with('orderItems')->paginate(10)),
        ]);
    }
}
