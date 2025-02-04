<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\Website;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    protected $model = Post::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'website_id' => Website::inRandomOrder()->first()->id ?? Website::factory(), // Random website
        ];
    }
}
