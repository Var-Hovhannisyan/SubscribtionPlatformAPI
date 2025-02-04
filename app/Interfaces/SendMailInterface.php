<?php

namespace App\Interfaces;

use App\Models\Post;
use Illuminate\Http\JsonResponse;

interface SendMailInterface
{
    public function sendMail(Post $post, int $subscriberId): JsonResponse;
}
