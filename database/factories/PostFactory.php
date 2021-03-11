<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->words(rand(2, 8), true),
            'body' => $this->faker->paragraph(rand(2, 10)),
        ];
    }

    public function published()
    {
        return $this->state([
            'published_at' => now(),
        ]);
    }

    public function hasFeaturedImage()
    {
        return $this->state([
            'featured_image' => UploadedFile::fake()->image('image.jpg', 640, 480),
        ]);
    }
}
