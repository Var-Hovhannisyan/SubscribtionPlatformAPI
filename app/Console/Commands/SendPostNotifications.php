<?php

namespace App\Console\Commands;

use App\Models\Post;
use App\Models\Website;
use App\Jobs\SendEmailToSubscribers;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SendPostNotifications extends Command
{
    protected $signature = 'notifications:send';
    protected $description = 'Send email notifications to all subscribers for all posts';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        try {
            // Fetch all posts with their associated website and subscribers
            $posts = Post::with('website.subscribers')->get();

            if ($posts->isEmpty()) {
                $this->info('No posts found.');
                return 0;
            }

            foreach ($posts as $post) {
                if ($post->website) {
                    $website = $post->website;

                    // Fetch existing subscribers for the post to prevent duplicates
                    $existingSubscribers = DB::table('post_subscriber')
                        ->where('post_id', $post->id)
                        ->pluck('user_id')
                        ->toArray();

                    // Get subscribers who have not yet been notified
                    $subscribersToNotify = $website->subscribers->filter(function ($subscriber) use ($existingSubscribers) {
                        return !in_array($subscriber->id, $existingSubscribers);
                    });

                    if ($subscribersToNotify->isEmpty()) {
                        $this->info('No new subscribers to notify for post: ' . $post->title);
                        continue;
                    }

                    // Dispatch email jobs for each subscriber in chunks
                    $subscribersToNotify->chunk(50)->each(function ($chunk) use ($post) {
                        foreach ($chunk as $subscriber) {
                            dispatch(new SendEmailToSubscribers($post, $subscriber->id));

                            // Log email dispatch action
                            Log::info("Email queued for post: {$post->title} to subscriber: {$subscriber->id}");
                        }
                    });

                    $this->info("Notification emails have been queued for post: {$post->title}");
                } else {
                    $this->warning("No website associated with post: {$post->title}");
                }
            }

            return 0;

        } catch (\Throwable $exception) {
            Log::error('Error sending post notifications', [
                'error' => $exception->getMessage()
            ]);

            $this->error('Something went wrong while sending notifications.');
            return 1;
        }
    }
}
