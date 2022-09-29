<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $user = User::create(
            $request->only('first_name', 'last_name', 'email') + [
                'password' => Hash::make($request->input('password')),
                'is_admin' => true
            ]
        );

        return response([
            'status' => true,
            'user' =>$user
        ], Response::HTTP_CREATED);
    }

    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response([
                'error' => 'invalid credentials',
            ], Response::HTTP_UNAUTHORIZED);
        }

        return response([
            'status' => true,
            'user' => auth()->user()
        ])->withCookie(cookie(
            'jwt',
            auth()->user()?->createToken('token')->plainTextToken,
            60 * 24
        ));
    }
}
