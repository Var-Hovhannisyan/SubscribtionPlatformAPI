<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait ValidatesSubscription
{
    public function validateSubscriptionRequest(Request $request): array
    {
        return $request->validate([
            'website_id' => ['required', 'integer', 'exists:websites,id'],
        ]);
    }
}
