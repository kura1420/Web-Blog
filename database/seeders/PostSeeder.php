<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Post::factory()
            ->count(50)
            ->sequence(fn($sequence) => ['title' => 'Post ' . ($sequence->index + 1)])
            ->has(
                \App\Models\PostTag::factory()
                    ->count(rand(1, 5)),
                'tags'
            )
            ->has(
                \App\Models\Comment::factory()
                    ->count(rand(0, 10)),
                'comments'
            )
            ->create();
    }
}
