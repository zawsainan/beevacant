<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

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
        $skillsList = ['Laravel', 'React', 'Vue', 'PHP', 'JavaScript', 'Tailwind', 'Node.js', 'Docker', 'MySQL', 'Git'];

        return [
            'user_id' => User::factory()->state(['role' => 'job_seeker'])->create()->id,
            'experience_level' => fake()->randomElement(['Entry', 'Mid', 'Senior']),
            'expected_salary' => rand(1, 9) * 100000,
            'overview' => fake()->text(),
            'skills' => json_encode(Arr::random($skillsList, rand(2, 5))),
            'profile_picture' => fake()->imageUrl(),
            'birthday' => fake()->date(),
            'phone_number' => '+959'.fake()->numerify('#########'),
            'profession' => fake()->word()
        ];
    }
}
