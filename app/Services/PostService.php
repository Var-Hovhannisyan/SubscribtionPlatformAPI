<?php

namespace App\Services;

use App\Interfaces\PostInterface;
use App\Interfaces\SendMailInterface;
use App\Models\Post;
use App\Models\Website;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class PostService implements PostInterface
{
    protected $mailService;

    public function __construct(SendMailInterface $mailService)
    {
        $this->mailService = $mailService;
    }

    public function createPost(array $postData): JsonResponse
    {
        try {
            $post = Post::create($postData);

            if (isset($postData['website_id'])) {
                $website = Website::find($postData['website_id']);
                if ($website) {
                    $post->website()->associate($website);
                    $post->save();

                    // Dispatch email sending via queue
                    dispatch(function () use ($post) {
                        foreach ($post->website->subscribers as $subscriber) {
                            $this->mailService->sendMail($post, $subscriber->id);
                        }
                    });
                }
            }

            return response()->json([
                'message' => 'Post created & notification queued',
                'post' => $post
            ], 201);
        } catch (\Throwable $exception) {
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
