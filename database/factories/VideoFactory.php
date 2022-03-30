<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Video>
 */
class VideoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $tags = collect(['php', 'ruby', 'java', 'javascript', 'bash'])
            ->random(2)
            ->values()
            ->all();

        return [
            'chanel_id' => 1,
            'title' => $this->faker->sentence(),
            'description' => $this->faker->text(800),
            'seconds' => random_int(1, 600),
            'tags' => $tags,
        ];
    }
}
