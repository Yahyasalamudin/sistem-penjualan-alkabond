<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SalesResource;
use App\Models\Sales;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|min:5',
            'password' => 'required|min:6'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => [],
                'message' => $validator->errors(),
                'status_code' => 403
            ]);
        }

        $credentials = $request->only('email', 'password');

        if (Auth::guard('sales')->attempt(['email' => $credentials['email'], 'password' => $credentials['password']])) {
            $user = Sales::where('email', $request['email'])->firstOrFail();
        } else if (Auth::guard('sales')->attempt(['username' => $credentials['email'], 'password' => $credentials['password']])) {
            $user = Sales::where('username', $request['email'])->firstOrFail();
        } else {
            return response()->json([
                'message' => 'Unauthorized',
                'status_code' => 401
            ]);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'data' => new SalesResource($user),
            'access_token' => $token, 'token_type' => 'Bearer',
            'status_code' => 200
        ]);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'You have successfully logged out and the token was successfully deleted',
            'status_code' => 200
        ];
    }
}
