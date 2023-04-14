<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SalesResource;
use App\Models\Sales;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        if (Auth::guard('sales')->attempt($request->only('email', 'password'))) {
            $user = Sales::where('email', $request['email'])->firstOrFail();

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'data' => new SalesResource($user),
                'message' => 'Hi ' . $user->sales_name . ', welcome to home', 'access_token' => $token, 'token_type' => 'Bearer',
            ]);
        } else {
            return response()
                ->json(['message' => 'Unauthorized'], 401);
        }
    }

    // method for user logout and delete token
    public function logout()
    {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'You have successfully logged out and the token was successfully deleted'
        ];
    }
}
