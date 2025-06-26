<?php

namespace App\Helpers;

class ApiResponse
{
    public static function success($data = null, $message = 'Success', $code = 200)
    {
        $respons = [
            'success' => true,
            'message' => $message,

        ];

        if (!is_null($data)) {
            $respons['data'] = $data;
        }
        return response()->json($respons, $code);
    }

    public static function error($message = 'Error', $code = 400, $errors = null)
    {
        $respons = [
            'success' => false,
            'message' => $message,

        ];

        if (!is_null($errors)) {
            $respons['errors'] = $errors;
        }
        return response()->json($respons, $code);
    }
}
