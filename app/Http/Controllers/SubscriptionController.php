<?php

namespace App\Http\Controllers;

use App\Interfaces\SubscriptionServiceInterface;
use App\Traits\ValidatesSubscription;
use Illuminate\Http\Request;
use App\Models\Website;
use Illuminate\Http\JsonResponse;

class SubscriptionController extends Controller
{
    use ValidatesSubscription;
    protected SubscriptionServiceInterface $subscriptionService;

    public function __construct(SubscriptionServiceInterface $subscriptionService)
    {
        $this->subscriptionService = $subscriptionService;
    }

    public function subscribe(Request $request): JsonResponse
    {
        $validated = $this->validateSubscriptionRequest($request);
        return $this->subscriptionService->subscribe($request->user(), (int) $validated['website_id']);
    }
}
