<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;
use Illuminate\Support\Facades\Redis;

class VerifyApiToken
{
    public function handle(Request $request, Closure $next)
    {
        $headerToken = $request->header('Authorization');

        if (!$headerToken || !str_starts_with($headerToken, 'Bearer ')) {
            return ApiResponse::error('Invalid token format', 401);
        }

        $token = substr($headerToken, 7); // Menghapus 'Bearer ' dari awal string

        // Periksa apakah token ada di Redis
        try {
            if (!Redis::exists($token)) {
                return ApiResponse::error('Token not found or expired', 401);
            }
        } catch (\Exception $e) {
            // Handle error koneksi Redis jika diperlukan
            return ApiResponse::error('Service unavailable', 503);
        }

        return $next($request);
    }
}
