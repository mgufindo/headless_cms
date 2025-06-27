<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use App\Helpers\ApiResponse;

class AuthCheckMiddleware
{
    public function handle(Request $request, Closure $next, ...$permissions)
    {
        $headerToken = $request->header('Authorization');

        if (!$headerToken || !str_starts_with($headerToken, 'Bearer ')) {
            return ApiResponse::error('Invalid token format', 401);
        }

        $token = substr($headerToken, 7);

        try {
            if (!Redis::exists($token)) {
                return ApiResponse::error('Token not found or expired', 401);
            }

            $userData = json_decode(Redis::get($token), true);

            if (!$userData || !isset($userData['permissions'])) {
                return ApiResponse::error('Unauthorized', 403);
            }

            // Jika permissions diberikan sebagai parameter middleware
            if (!empty($permissions)) {
                $userPermissions = array_column($userData['permissions'], 'name');
                $hasPermission = !empty(array_intersect($permissions, $userPermissions));

                if (!$hasPermission) {
                    return ApiResponse::error('Forbidden - Insufficient permissions', 403);
                }
            }
        } catch (\Exception $e) {
            return ApiResponse::error('Service unavailable', 503);
        }

        return $next($request);
    }
}
