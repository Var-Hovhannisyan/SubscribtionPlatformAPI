<?php

namespace Database\Seeders;

use App\Models\Website;
use Illuminate\Database\Seeder;

class WebsiteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $websites = [
            ['name' => 'Facebook', 'url' => 'https://www.facebook.com'],
            ['name' => 'Instagram', 'url' => 'https://www.instagram.com'],
            ['name' => 'YouTube', 'url' => 'https://www.youtube.com'],
            ['name' => 'LinkedIn', 'url' => 'https://www.linkedin.com'],
        ];

        foreach ($websites as $website) {
            Website::create($website);
        }
    }
}
