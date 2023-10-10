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
        Post::factory()->create([
            'user_id' => 1,
            'video' => 'files/tiktok-video.mp4'
        ]);
        Post::factory(10)->create([
            'video' => 'files/tiktok-video.mp4'
        ]);
    }
}
