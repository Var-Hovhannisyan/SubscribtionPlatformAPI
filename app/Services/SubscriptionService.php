<?php

namespace App\Services;

use App\Interfaces\SubscriptionServiceInterface;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class SubscriptionService implements SubscriptionServiceInterface
{
    public function subscribe(User $user, ?int $websiteId): JsonResponse
    {
        if (!$websiteId) {
            return response()->json(['message' => 'Invalid website ID.'], 400);
        }
        try {
            if ($user->subscriptions()->where('website_id', $websiteId)->exists()) {
                return response()->json(['message' => 'Already subscribed'], 409);
            }
            // Attach only if not already subscribed
            $user->subscriptions()->syncWithoutDetaching([$websiteId => ['created_at' => now(), 'updated_at' => now()]]);

            return response()->json(['message' => 'Subscription successful.'], 200);
        } catch (\Throwable $exception) {
            Log::error('Subscription failed', ['error' => $exception->getMessage()]);

            return response()->json(['message' => 'Internal Server Error.'], 500);
        }
    }
}
