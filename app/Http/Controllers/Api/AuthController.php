<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SalesResource;
use App\Models\Device;
use App\Models\Sales;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Nonstandard\Uuid;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required|min:5'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => [],
                'message' => $validator->errors(),
                'status_code' => 403
            ]);
        }

        $email = $request->email;
        $password = $request->password;
        $fieldType = filter_var($email, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $cek_active = Sales::where($fieldType, $email)->first();

        if (isset($cek_active->active) && $cek_active->active == 0) {
            return response()->json([
                'message' => 'I have you deactivated please contact admin',
                'status_code' => 401
            ]);
        }

        $user = Sales::where($fieldType, $email)->firstOrFail();
        $device_token = Uuid::uuid4()->toString();

        if($user->device == 0) {
            if (Auth::guard('sales')->attempt([$fieldType => $email, 'password' => $password])) {
                $user = Sales::where($fieldType, $email)->firstOrFail();
            } else {
                return response()->json([
                    'message' => 'username or password is incorrect',
                    'status_code' => 400
                ]);
            }

            $token = $user->createToken('auth_token')->plainTextToken;
        } elseif ($user->device < 3) {
            $device = Device::userId($user->id)->first();
            $token = $device->access_token;
        } elseif ($user->device == 3) {
            $device = Device::userId($user->id)->orderBy('last_used_at', 'asc')->first();
            $token = $device->access_token;
            $device->delete();
        }

        $device = Device::create([
            'user_id' => $user->id,
            'device_token' => $device_token,
            'access_token' => $token,
            'last_used_at' => now()
        ]);

        $user->update([
            'device' => Device::where('user_id', $user->id)->count()
        ]);

        return response()->json([
            'data' => new SalesResource($user->refresh()),
            'device_token' => $device_token,
            'access_token' => $token, 'token_type' => 'Bearer',
            'status_code' => 200
        ]);
    }

    public function getMyData(Request $request)
    {
        $device = Device::where('device_token', $request->device_token)->first();

        $device->update([
            'last_used_at' => now()
        ]);

        if($device) {
            return response()->json([
                'data' => $device,
                'message' => 'success',
                'status_code' => 200
            ]);
        } else {
            return response()->json([
                'message' => 'failed',
                'status_code' => 400
            ]);
        }
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
