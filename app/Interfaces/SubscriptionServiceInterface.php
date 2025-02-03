<?php

namespace App\Interfaces;
use App\Models\User;
use App\Models\Website;
use Illuminate\Http\JsonResponse;

interface SubscriptionServiceInterface
{
    public function subscribe(User $user, ?int $websiteId): JsonResponse;
}
