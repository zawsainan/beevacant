<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\WorkProfile>
 */
class WorkProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->state(['role' => 'job_seeker'])->create()->id,
            'experience_level' => fake()->randomElement(['Entry', 'Mid', 'Senior']),
            'expected_salary' => rand(1, 9) * 100000,
            'overview' => fake()->text(),
            'skills' => fake()->words(5),
            'profile_picture' => fake()->imageUrl(),
            'birthday' => fake()->date(),
            'phone_number' => fake()->phoneNumber(),
            'profession' => fake()->word()
        ];
    }
}
