<?php

namespace App\Services;

use App\Interfaces\PostInterface;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class PostService implements PostInterface
{
    public function createPost(User $user, array $postData): JsonResponse
    {
        try {
            // Attach post to websites if provided
            if (!empty($postData['website_ids'])) {
                //User's subscribed website ids
                $subscribedWebsiteIds = $user->websites()->pluck('websites.id')->toArray();

                //Filter and Get Only subscribed website IDs
                $validWebsiteIds = array_intersect($postData['website_ids'], $subscribedWebsiteIds);

                if (!empty($validWebsiteIds)) {
                    $post = $user->posts()->create([
                        'title' => $postData['title'],
                        'description' => $postData['description'],
                    ]);

                    $post->websites()->attach($validWebsiteIds);
                }else {
                    throw new \Exception('Please subscribe to website for adding post');
                }
            }

            return response()->json([
                'message' => 'Post created successfully.',
                'post' => $post
            ], 201);
        } catch (\Throwable $exception) {
            Log::error('Post creation failed', [
                'user_id' => $user->id,
                'error' => $exception->getMessage()
            ]);

            return response()->json([
                'error' => 'Something went wrong. Please try again.',
                'message' => $exception->getMessage()
            ], 500);
        }
    }
}
