<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'post_id' => rand(2,30),
            'user_id' => rand(2,10),
            'comment' => $this->faker->text($maxNbChars = 500),
        ];
    }
}
