<?php

namespace App\Services\Custom;

use App\Interfaces\Custom\ResponseInterface;
use Illuminate\Http\JsonResponse;

class Response implements ResponseInterface
{
    public function responseJson($data, int $statusCode, ?string $message = null): JsonResponse
    {
        $response = [
            'data' => $data
        ];

        // Add "message" only if it's not empty
        if (!empty($message)) {
            $response['message'] = $message;
        }

        return response()->json($response, $statusCode);
    }
}
