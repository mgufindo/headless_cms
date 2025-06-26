<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use App\Http\Controllers\Controller;
use App\Models\User;

class AuthControllerApi extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where("email", $request->email)->first();
        if (is_null(($user))) {
            return ApiResponse::error('User not found', 404);
        }
        $token = $this->token();

        // Simpan token di Redis dengan expiry time (contoh: 1 jam)
        Redis::setex($token, 3600 * 7, json_encode([
            'user_id' => $user->id,
            'email' => $user->email,
            'issued_at' => now()->toDateTimeString(),
        ]));

        $data = [
            'user' => $user,
            'token' => $token
        ];
        return ApiResponse::success($data);
    }

    public function logout(Request $request)
    {
        $token = $request->header('Authorization');
        $token = str_replace('Bearer ', '', $token);

        $redis = Redis::exists($token);

        if (!$redis) {
            return ApiResponse::error('Error logout key not found', 404);
        }
        // Hapus token dari Redis
        Redis::del($token);

        return ApiResponse::success(null, 'Success logout');
    }

    private function token()
    {
        return bin2hex(random_bytes(32));
    }
}
