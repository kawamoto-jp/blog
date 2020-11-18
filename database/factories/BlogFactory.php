<?php

namespace Database\Factories;

use App\Models\Blog;
use Illuminate\Database\Eloquent\Factories\Factory;

class BlogFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Blog::class;

    /**
     * Define themodel's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            // 'title' => $faker->word,
            // 'content' => $faker->trealText

            'title' => $this->faker->word,
            'content' => $this->faker->realText
        ];
    }
}

