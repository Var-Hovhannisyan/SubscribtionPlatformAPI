<?php

namespace App\Services;

use App\Interfaces\WebsiteInterface;
use App\Models\User;
use App\Models\Website;
use Illuminate\Http\JsonResponse;

class WebsiteService implements WebsiteInterface
{
    public function createWebsite(array $websiteData): JsonResponse {
        try {
            Website::create([
                'name' => $websiteData['name'],
                'url' => $websiteData['url'],
            ]);
            return response()->json([
                'message' => 'Website created successfully.',
                'website' => $websiteData
            ], 201);
        } catch (\Throwable $exception) {
            Log::error('Website creation failed', [
                'error' => $exception->getMessage()
            ]);

            return response()->json([
                'error' => 'Something went wrong. Please try again.',
                'message' => 'Internal Server Error'
            ], 500);
        }
    }
}
