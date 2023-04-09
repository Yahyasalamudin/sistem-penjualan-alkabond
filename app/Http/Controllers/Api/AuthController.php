<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Sales;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'username' => 'required|string|min:5|max:255|unique:users|unique:sales',
            'email' => 'required|string|email|max:255|unique:users|unique:sales',
            'phone_number' => 'required|numeric|digits_between:10,14',
            'password' => 'required|string|min:8',
            'role' => 'required'
        ]);

        if($request->role != 'sales') {
            if($validator->fails()){
                return response()->json([
                    'data' => [],
                    'message' => $validator->errors(),
                    'success' => false
                ]);
            }

            $user = User::create([
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'password' => Hash::make($request->password),
                'role' => $request->role
             ]);
        } else {
            if($validator->fails()){
                return response()->json([
                    'data' => [],
                    'message' => $validator->errors(),
                    'success' => false
                ]);
            }

            $user = Sales::create([
                'sales_name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'password' => Hash::make($request->password),
             ]);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()
            ->json(['data' => $user,'access_token' => $token, 'token_type' => 'Bearer', ]);
    }

    public function login(Request $request)
    {
        if (Auth::attempt($request->only('email', 'password')))
        {
            $user = User::where('email', $request['email'])->firstOrFail();

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()
                ->json(['message' => 'Hi '.$user->name.', welcome to '.$user->role.' home','access_token' => $token, 'token_type' => 'Bearer', ]);
        } else if (Auth::guard('sales')->attempt($request->only('email', 'password')))
        {
            $user = Sales::where('email', $request['email'])->firstOrFail();

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()
                ->json(['message' => 'Hi '.$user->sales_name.', welcome to Sales home','access_token' => $token, 'token_type' => 'Bearer', ]);
        } else {
            dd('gagal');
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
