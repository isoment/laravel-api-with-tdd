<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthService
{
    public function tokenStore(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password]))
        {
            return User::where('email', $request->email)
                ->first()
                ->createToken($request->email)
                ->accessToken;
        }
    }
}
