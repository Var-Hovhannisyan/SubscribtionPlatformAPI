<?php

namespace App\Interfaces\Custom;

use Illuminate\Http\JsonResponse;

interface ResponseInterface
{
    public function responseJson($data, int $statusCode, ?string $message = null): JsonResponse;
}
