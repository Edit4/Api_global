<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

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
            'content'=>$this->faker->text(150),
            'title'=>$this->faker->name,
            'img'=>$this->faker->name,
            'Users_id'=>User::inRandomOrder()->first()->id,

        ];
    }
}
