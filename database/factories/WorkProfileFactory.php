<?php

namespace Database\Factories;

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
            'profession' => fake()->jobTitle(),
            'profile_picture' => "profile-pictures/profile.jpg",
            'overview' => fake()->paragraph(),
            'phone_number' => '+959798078944',
            'birthday' => fake()->date(),
            'experience_level' => 'Entry',
            'expected_salary' => '500000 MMK',
            'skills' => ["HTML","CSS","JavaScript","PHP","Laravel"],
        ];
    }
}
