<?php

namespace App\Services;

use App\Interfaces\SendMailInterface;
use App\Mail\SubscriberMail;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

class SendMailService implements SendMailInterface
{

    protected PostSubscriberService $postSubscriberService;

    // Constructor to inject the PostSubscriberService
    public function __construct(PostSubscriberService $postSubscriberService)
    {
        $this->postSubscriberService = $postSubscriberService;
    }

    public function sendMail(Post $post, int $subscriberId): JsonResponse
    {
        try {            // Find the subscriber
            $subscriber = User::find($subscriberId);
            if (!$subscriber) {
                return response()->json(['message' => 'Subscriber not found.'], 404);
            }
            $dbResponse = $this->postSubscriberService->insert($post['id'], $subscriber->id);
            if ($dbResponse->status() === 200) {
                Log::info($dbResponse->getContent());
            }
            // Send the email
            Mail::to($subscriber->email)->send(new SubscriberMail($post, $subscriber));

            return response()->json(['message' => 'Email sent successfully!'], 200);
        } catch (\Exception $e) {
            // Catch any exception and return a response
            return response()->json(['message' => 'Failed to send email.', 'error' => $e->getMessage()], 500);
        }
    }
}
