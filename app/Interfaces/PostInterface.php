<?php

namespace App\Interfaces;

use App\Models\User;
use Illuminate\Http\JsonResponse;

interface PostInterface
{
    public function createPost(array $postData): JsonResponse;
}
