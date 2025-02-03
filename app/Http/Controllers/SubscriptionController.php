<?php

namespace App\Http\Controllers;

use App\Interfaces\SubscriptionServiceInterface;
use Illuminate\Http\Request;
use App\Models\Website;
use Illuminate\Http\JsonResponse;

class SubscriptionController extends Controller
{
    protected SubscriptionServiceInterface $subscriptionService;

    public function __construct(SubscriptionServiceInterface $subscriptionService)
    {
        $this->subscriptionService = $subscriptionService;
    }

    public function subscribe(Request $request): JsonResponse
    {
        $request->validate([
            'website_id' => ['required', 'integer', 'exists:websites,id'],
        ]);
        return $this->subscriptionService->subscribe($request->user(), (int) $request->website_id);
    }
}
