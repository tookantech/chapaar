<?php

namespace TookanTech\Chapaar\Tests\Database\Factories;

use TookanTech\Chapaar\Tests\Entities\TestUser;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    protected $model = TestUser::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => bcrypt('password'), // Assuming you're hashing passwords
            'cellphone' => $this->faker->phoneNumber,
            // Add any other fields you need for your custom user model
        ];
    }

    public function active()
    {
        return $this->state([
            'is_active' => true,
        ]);
    }

    public function inactive()
    {
        return $this->state([
            'is_active' => false,
        ]);
    }
}
