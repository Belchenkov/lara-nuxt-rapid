<?php

namespace App\Http\Controllers;

use App\Models\User;

class AmbassadorController extends Controller
{
    public function index()
    {
        return response([
            'status' => true,
            'users' => User::ambassadors()->get(),
        ]);
    }
}
