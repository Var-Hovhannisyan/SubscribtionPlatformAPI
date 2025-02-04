<?php

namespace App\Services;

use App\Interfaces\PostInterface;
use App\Interfaces\SendMailInterface;
use App\Jobs\SendEmailToSubscribers;
use App\Models\Post;
use App\Models\Website;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PostService implements PostInterface
{
    protected SendMailInterface $mailService;
    protected PostSubscriberService $postSubscriberService;

    public function __construct(SendMailInterface $mailService, PostSubscriberService $postSubscriberService)
    {
        $this->mailService = $mailService;
        $this->postSubscriberService = $postSubscriberService;
    }

    public function createPost(array $postData): JsonResponse
    {
        try {
            // Check if post with the same title and website already exists
            $existingPost = Post::where('title', $postData['title'])
                ->where('website_id', $postData['website_id'])
                ->first();

            if ($existingPost) {
                // If the post already exists, return a message
                return response()->json(['message' => 'Post already exists for this website.'], 200);
            }

            // Create new post if not exists
            $post = Post::create($postData);

            if (isset($postData['website_id'])) {
                $website = Website::find($postData['website_id']);
                if ($website) {
                    $post->website()->associate($website);
                    $post->save();

                    // Dispatch email sending via queue for subscribers
                    foreach ($post->website->subscribers as $subscriber) {
                        $existingRecord = DB::table('post_subscriber')
                            ->where('post_id', $post->id)
                            ->where('user_id', $subscriber->id)
                            ->first();

                        if ($existingRecord) {
                            // Skip sending email if already sent
                            Log::info('Email already sent to subscriber ' . $subscriber->id . ' for post ' . $post->id);
                        } else {
                            // Dispatch job to send email
                            dispatch(new SendEmailToSubscribers($post, $subscriber->id));
                        }
                    }
                }
            }

            // Clear cache for recent posts
            Cache::forget('recent_posts');

            return response()->json([
                'message' => 'Post created & notification queued',
                'post' => $post
            ], 201);
        } catch (\Throwable $exception) {
            // Log error and return response in case of failure
            Log::error('Error creating post', [
                'error' => $exception->getMessage()
            ]);

            return response()->json([
                'error' => 'Something went wrong. Please try again.',
                'message' => $exception->getMessage()
            ], 500);
        }
    }
}
