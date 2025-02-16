<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TasklistFactory extends Factory
{

    public function definition(): array
    {
        return [
            'name' => $this->faker->word() . ' List',
            'user_id' => User::factory(),
        ];
    }
}
