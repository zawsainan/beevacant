<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Industry;
use App\Models\Job;
use App\Models\Tag;
use App\Models\User;
use App\Models\WorkProfile;
use Illuminate\Database\Eloquent\Factories\Sequence;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $jobIndustries = [
            'Information Technology',
            'Healthcare & Medical',
            'Construction',
            'Education & Training',
            'Finance & Accounting',
            'Sales & Marketing',
            'Hospitality & Tourism',
            'Manufacturing & Logistics'
        ];
        foreach ($jobIndustries as $jobIndustry) {
            Industry::create(['name' => $jobIndustry]);
        }
        $tags = Tag::factory(3)->create();
        $recruiter = User::factory()->create([
            'role' => 'recruiter',
            'email' => 'recruiter@gmail.com'
        ]);

        $jobSeeker = User::factory()->create([
            'role' => 'job_seeker',
            'email' => 'jobseeker@gmail.com'
        ]);
        $company = Company::factory()->create([
            'user_id' => $recruiter->id
        ]);
        WorkProfile::factory()->create([
            'user_id' => $jobSeeker->id
        ]);

        Job::factory(20)->hasAttached($tags)->create(new Sequence(
            [
                'schedule' => 'Part Time',
                'is_remote' => true,
                'is_featured' => true,
                'company_id' => $company->id
            ],
            [
                'schedule' => 'Full Time',
                'is_remote' => false,
                'is_featured' => false,
                'company_id' => $company->id
            ]
        ));
    }
}
