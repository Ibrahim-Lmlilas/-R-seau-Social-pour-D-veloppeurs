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
        $type = $this->faker->randomElement(['line', 'code', 'image']);
        $content = null;
        $line = null;
        $code = null;
        $image = null;

        if ($type === 'line') {
            $line = $this->faker->sentence();
        } elseif ($type === 'code') {
            $code = $this->faker->paragraph();
        } else {
            $image = $this->faker->imageUrl();
            $content = $image;
        }

        return [
            'user_id' => $this->faker->numberBetween(1, 10),
            'title' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'type' => $type,
            'content' => $content,
            'line' => $line,
            'code' => $code,
            'image' => $image,
        ];
    }
}
