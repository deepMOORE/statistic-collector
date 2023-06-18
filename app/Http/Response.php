<?php declare(strict_types=1);

namespace App\Http;

use Illuminate\Http\JsonResponse;

class Response
{
    public static function success($data, string $message = null): JsonResponse
    {
        return response()->json(
            [
                'success' => true,
                'message' => $message,
                'data' => $data,
            ]
        );
    }

    public static function failure(string $message = null, $data = null): JsonResponse
    {
        return response()->json(
            [
                'success' => false,
                'message' => $message,
                'data' => $data,
            ],
            400
        );
    }
}
