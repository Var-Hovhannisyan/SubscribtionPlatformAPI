<?php

namespace App\Providers;

use App\Interfaces\Custom\ResponseInterface;
use App\Interfaces\PostInterface;
use App\Interfaces\PostSubscriberInterface;
use App\Interfaces\SendMailInterface;
use App\Interfaces\SubscriptionServiceInterface;
use App\Interfaces\UserInterface;
use App\Interfaces\WebsiteInterface;
use App\Services\Custom\Response;
use App\Services\PostService;
use App\Services\PostSubscriberService;
use App\Services\SendMailService;
use App\Services\SubscriptionService;
use App\Services\UserService;
use App\Services\WebsiteService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserInterface::class, UserService::class);
        $this->app->bind(ResponseInterface::class, Response::class);
        $this->app->bind(SubscriptionServiceInterface::class, SubscriptionService::class);
        $this->app->bind(PostInterface::class, PostService::class);
        $this->app->bind(WebsiteInterface::class, WebsiteService::class);
        $this->app->bind(SendMailInterface::class, SendMailService::class);
        $this->app->bind(PostSubscriberInterface::class, PostSubscriberService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
