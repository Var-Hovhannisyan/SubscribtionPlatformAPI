<?php

namespace App\Services;

use App\Interfaces\SendMailInterface;
use App\Mail\SubscriberMail;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

class SendMailService implements SendMailInterface
{
    public function sendMail(Post $post, int $subscriberId): JsonResponse
    {
        try {
            $subscriber = User::find($subscriberId);
            if (!$subscriber) {
                return response()->json(['message' => 'Subscriber not found.'], 404);
            }

            // Send Email
            Mail::to($subscriber->email)->send(new SubscriberMail($post));

            // Insert into post_subscriber table to track sent emails
            DB::table('post_subscriber')->insert([
                'post_id' => $post->id,
                'subscriber_id' => $subscriberId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return response()->json(['message' => 'Email sent successfully!'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to send email.', 'error' => $e->getMessage()], 500);
        }
    }
}
