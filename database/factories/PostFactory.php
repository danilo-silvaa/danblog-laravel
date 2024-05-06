<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Support\Str;
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
        $title = fake()->sentence(8);
        return [
            'user_id' => User::pluck('id')->random(),
            'title' => $title,
            'slug' => Str::slug($title),
            'thumbnail' => 'thumbnails/' . $this->faker->image(public_path('storage/thumbnails'), 530, 200, null, false, false),
            'content' => fake()->paragraph(100),
        ];
    }
}
