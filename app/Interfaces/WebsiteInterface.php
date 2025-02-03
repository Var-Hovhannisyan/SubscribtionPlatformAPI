<?php

namespace App\Interfaces;

use App\Models\User;
use Illuminate\Http\JsonResponse;

interface WebsiteInterface
{
    public function createWebsite(array $websiteData): JsonResponse;
}
