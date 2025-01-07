<?php

namespace App\Http\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function login($request) {
        if (Auth::attempt($request->only('username', 'password'))) {
            $user = Auth::user()->load('permissions');
            $token = $user->createToken('token')->plainTextToken;
            $user["token"] = $token;
            $cookie = cookie('sanctum', $token, 3600);

            return response()->json([
                'user' => $user
            ])->withCookie($cookie);
        }

        return response()->json([
            'message' => 'Invalid login details'
        ], 401);
    }

    public function logout() {
        Auth::user()->tokens()->delete();

        return response()->json([
            'message' => 'Logged out'
        ]);
    }

}
