<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => rand(2,10),
            'likes' => rand(1,9),
            'views' => rand(1,9),
            'dislikes' => rand(1,9),
            'title' => $this->faker->text($maxNbChars = 56),
            'desc' => $this->faker->text($maxNbChars = 1000),
            'post_img' => 'images/post_img/'.rand(1,21).'.jpg',
        ];
    }
}
