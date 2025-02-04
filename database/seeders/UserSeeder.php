<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Website;
use App\Services\SubscriptionService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Instantiate the Subscription Service
        $subscriptionService = app(SubscriptionService::class);

        // Create 10 fake users
        User::factory(10)->create()->each(function ($user) use ($subscriptionService) {
            // Select a random website from the database
            $website = Website::inRandomOrder()->first();

            // Subscribe user to the random website
            if ($website) {
                $subscriptionService->subscribe($user, $website->id);
            }
        });
    }
}
