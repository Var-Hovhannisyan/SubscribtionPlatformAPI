<?php

namespace App\Jobs;

use App\Interfaces\PostSubscriberInterface;
use App\Interfaces\SendMailInterface;
use App\Mail\SubscriberMail;
use App\Models\Post;
use App\Services\SendMailService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendEmailToSubscribers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $post;
    protected $subscriberId;

    /**
     * Create a new job instance.
     */
    public function __construct(Post $post, $subscriberId)
    {
        $this->post = $post;
        $this->subscriberId = $subscriberId;
    }

    /**
     * Execute the job.
     */
    public function handle(SendMailInterface $sendMailService, PostSubscriberInterface $postSubscriberService): void
    {
        Log::info('Job started: Sending email for post ID ' . $this->post->id . ' to subscriber ID ' . $this->subscriberId);

        try {
            // Call the sendMail method from the SendMailService to send the email
            $response = $sendMailService->sendMail($this->post, $this->subscriberId);
            // Check if the email was sent successfully
            if ($response->status() === 200) {
                Log::info('Job completed: Email sent successfully to subscriber ' . $this->subscriberId);
            } else {
                Log::error('Job failed: Unable to send email to subscriber ' . $this->subscriberId . '. ' . $response->getContent());
            }
        } catch (\Exception $exception) {
            Log::error('Error sending email for post ID ' . $this->post->id . ' to subscriber ID ' . $this->subscriberId, [
                'error' => $exception->getMessage(),
            ]);
            throw $exception;
        }
    }

    /**
     * Handle the job failure.
     */
    public function failed(\Throwable $exception)
    {
        Log::error('SendEmailToSubscribers job failed', [
            'error' => $exception->getMessage(),
            'post_id' => $this->post->id,
            'subscriber_id' => $this->subscriberId
        ]);
    }
}
