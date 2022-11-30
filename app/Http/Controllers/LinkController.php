<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Http\Response;

class LinkController extends Controller
{
    public function index(int $user_id): Response
    {
        return response([
            'status' => true,
            'products' => Link::where('user_id', $user_id)->paginate(10),
        ]);
    }
}
