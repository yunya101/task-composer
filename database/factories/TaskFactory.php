<?php

namespace Database\Factories;

use App\Models\Group;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $group = Group::class;
    protected $executor = User::class;

    public function definition(): array
    {
        return [
            'title' => fake()->title(),
            'deadline' => fake()->dateTime(),
            'description' => fake()->text(),
            'group_id' => Group::factory(),
            'executor' => User::factory(),
        ];
    }
}
