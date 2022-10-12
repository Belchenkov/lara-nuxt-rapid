<?php

namespace App\Http\Controllers;

use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        return response([
            'status' => true,
            'orders' => Order::paginate(10),
        ]);
    }
}
