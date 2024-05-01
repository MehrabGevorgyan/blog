<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class Post_TagFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'post_id' => rand(1,30),
            'tag_id' => rand(1,5),
  
        ];
    }
}
