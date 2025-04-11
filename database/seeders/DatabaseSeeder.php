<?php

namespace Database\Seeders;

use App\Models\Job;
use App\Models\Tag;
use App\Models\User;
use App\Models\WorkProfile;
use Illuminate\Database\Eloquent\Factories\Sequence;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $tags = Tag::factory(3)->create();
        Job::factory(10)->hasAttached($tags)->create(new Sequence(
            [
                'featured' => true,
                'schedule' => 'Full Time'
            ],
            [
                'featured' => false,
                'schedule' => 'Part Time'
            ]
        ));
        WorkProfile::factory(2)->create();
    }
}
