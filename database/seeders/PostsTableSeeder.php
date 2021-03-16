<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::query()->each(function (User $user) {
            $user->posts()->saveMany(Post::factory(rand(5, 10))->published()->hasFeaturedImage()->make());
        });

        $categories = Category::all();

        Post::query()->each(function (Post $post) use ($categories) {
            $post->categories()->attach($categories->shuffle()->pluck('id')->take(rand(1, 2)));
        });
    }
}
