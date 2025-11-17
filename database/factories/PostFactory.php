<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status = rand(0, 2);

        return [
            //
            'cover' => 'posts/sample.png',
            'content' => $this->faker->paragraphs(5, true),
            'status' => $status,
            'published_at' => $status === 0 ? null : $this->faker->dateTimeBetween('-1 years', 'now'),
            'user_id_author' => \App\Models\User::inRandomOrder()->first()->id,
            'category_id' => \App\Models\Category::inRandomOrder()->first()->id,
            'slug' => $this->faker->unique()->slug(),
        ];
    }
}
