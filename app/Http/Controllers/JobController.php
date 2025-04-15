<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class JobController extends Controller
{

    // show all jobs
    public function index()
    {
        return response()->json([
            'jobs' => Job::with(['tags'])->latest()->paginate()
        ], 200);
    }

    // show single job with tags
    public function show(Job $job)
    {
        return response()->json([
            'job' => $job->load('tags')
        ], 200);
    }

    // create a new job
    public function store(Request $request)
    {

        DB::beginTransaction();
        try {
            $attributes = $request->validate([
                'category_id' => ['required', 'integer', 'exists:categories,id'],
                'title' => ['required', 'string', 'max:255'],
                'salary_range' => ['nullable', 'string', 'max:255'],
                'schedule' => ['required', Rule::in(['Part Time', 'Full Time'])],
                'location' => ['required', 'string'],
                'url' => ['required', 'url'],
                'featured' => ['required', 'boolean']
            ]);

            $tagValidation = $request->validate(['tags' => ['required', 'string']]);

            $attributes['company_id'] = $request->user()->company->id;
            $job = Job::create($attributes);

            $tagNames = collect(explode(',', $tagValidation['tags']))->map(fn($tag) => trim($tag))->filter()->unique();
            $tags = $tagNames->map(fn($tagName) => Tag::firstOrCreate(['name' => $tagName]));
            $job->tags()->sync($tags->pluck('id'));

            DB::commit();

            return response()->json([
                'message' => 'Job posted successfully.',
                'job' => $job->load('tags')
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    // update a job
    public function update(Request $request, Job $job)
    {
        if ($request->user()->id != $job->company->user->id) {
            return response()->json(["message" => "Unauthorized Action! You do not have permission to modify this job listing."], 403);
        }

        try {
            DB::beginTransaction();
            $attributes = $request->validate([
                'category_id' => ['required', 'integer', 'exists:categories,id'],
                'title' => ['required', 'string', 'max:255'],
                'salary_range' => ['nullable', 'string', 'max:255'],
                'schedule' => ['required', Rule::in(['Part Time', 'Full Time'])],
                'location' => ['required', 'string'],
                'url' => ['required', 'url'],
                'featured' => ['required', 'boolean'],
                'tags' => ['required', 'string']
            ]);

            $tagValidation = $attributes['tags'];
            unset($attributes['tags']);

            $job->update($attributes);

            $tagNames = collect(explode(',', $tagValidation))->map(fn($tagName) => trim($tagName))->filter()->unique();
            $tags = $tagNames->map(fn($tagName) => Tag::firstOrCreate(['name' => $tagName]));
            $job->tags()->sync($tags->pluck('id'));

            DB::commit();

            return response()->json([
                'message' => 'Job updated successfully.',
                'job' => $job
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    // soft delete a job
    public function destroy(Request $request, Job $job)
    {

        if ($request->user()->id != $job->company->user->id) {
            return response()->json(["message" => "Unauthorized Action! You do not have permission to delete this job listing."], 403);
        }

        $job->delete();

        return response()->json([
            'message' => 'Job deleted successfully.',
            'job' => $job
        ], 200);
    }

    // get recruiter's active jobs
    public function myJobs(Request $request)
    {
        $jobs = $request->user()->company->jobs;
        if ($jobs->isEmpty()) {
            return response()->json(['message' => "You haven't posted a job yet."], 200);
        }

        return response()->json(['jobs' => $jobs], 200);
    }

}
