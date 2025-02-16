<?php

namespace Database\Factories;

use App\Models\TaskList;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(3),
            'completed' => $this->faker->boolean(30),
            'task_list_id' => TaskList::factory(),
        ];
    }
}
