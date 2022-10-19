<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UpdateInfoRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(RegisterRequest $request): Response
    {
        $user = User::create(
            $request->only('first_name', 'last_name', 'email') + [
                'password' => Hash::make($request->input('password')),
                'is_admin' => $request->path() === 'api/admin/register'
            ]
        );

        return response([
            'status' => true,
            'user' =>$user
        ], Response::HTTP_CREATED);
    }

    public function login(Request $request): Response
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response([
                'error' => 'invalid credentials',
            ], Response::HTTP_UNAUTHORIZED);
        }

        $admin_login = $request->path() === 'api/admin/login';

        if ($admin_login && !auth()->user()->is_admin) {
            return response([
                'error' => 'Access Denied!',
            ], Response::HTTP_UNAUTHORIZED);
        }

        $scope = $admin_login ? 'admin' : 'ambassador';
        $jwt = auth()->user()?->createToken('token', [$scope])->plainTextToken;

        return response([
            'status' => true,
            'token' => $jwt,
            'user' => auth()->user(),
        ])->withCookie(cookie(
            'jwt',
            $jwt,
            60 * 24
        ));
    }

    public function user(Request $request): Response
    {
        return response([
            'status' => true,
            'user' => $request->user(),
        ]);
    }

    public function logout(): Response
    {
        $cookie = Cookie::forget('jwt');

        return response([
            'status' => true,
            'message' => 'Logout success!'
        ])->withCookie($cookie);
    }

    public function updateInfo(UpdateInfoRequest $request): Response
    {
        $user = $request->user();

        $user->update($request->only('first_name', 'last_name', 'email'));

        return response([
            'status' => true,
            'user' => $user,
        ], Response::HTTP_ACCEPTED);
    }

    public function updatePassword(UpdatePasswordRequest $request): Response
    {
        $user = $request->user();

        $user->update([
            'password' => Hash::make($request->input('password'))
        ]);

        return response([
            'status' => true,
            'user' => $user,
        ], Response::HTTP_ACCEPTED);
    }
}
