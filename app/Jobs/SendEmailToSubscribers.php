<?php

namespace App\Jobs;

use App\Interfaces\SendMailInterface;
use App\Mail\SubscriberMail;
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

    protected $details;

    /**
     * Create a new job instance.
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Execute the job.
     */
    public function handle(SendMailInterface $sendMailService): void
    {
        Log::info('Job started: Sending email to ' . $this->details['email']);
        $sendMailService->sendMail($this->details);
        Log::info('Job completed: Email sent successfully!');
    }
}
