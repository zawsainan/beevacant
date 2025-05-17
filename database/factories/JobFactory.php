<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Industry;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Job>
 */
class JobFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'industry_id' => rand(1, 8),
            'title' => fake()->jobTitle(),
            'salary_range' => fake()->randomElement(['500000 - 700000 MMk', '800000 - 1200000 MMk', '400000 - 600000 MMk']),
            'location' => fake()->address(),
            'description' => fake()->paragraph(),
            'requirements' => collect(range(1, 5))
                ->map(fn() => fake()->sentence())
                ->implode("-"),
            'deadline' => fake()->date(),
            'experience_level' => fake()->randomElement(['Entry', 'Mid', 'Senior']),
            'is_remote' => fake()->randomElement([true, false])

        ];
    }
}
