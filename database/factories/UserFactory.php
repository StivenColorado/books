<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    protected $model =  User::class;
    public function definition()
    {
        return [
            'number_id' => $this->faker->randomNumber(9,true),
            'name' => fake()->name(),
            'last_name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'password' => bcrypt(12345789), // password
            'remember_token' => Str::random(10),
        ];
    }
}
