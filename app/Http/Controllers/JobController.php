<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Validation\Rule;

/**
 * Class JobController
 *
 * Controller for handling job postings.
 * Only authenticated users with the "recruiter" role can create, update, delete, restore, or permanently delete jobs.
 */
class JobController extends Controller implements HasMiddleware
{
    /**
     * Define middleware for the controller.
     *
     * @return array
     */
    public static function middleware()
    {
        return [
            new Middleware('auth:sanctum', except: ['index', 'show'])
        ];
    }

    /**
     * Display a listing of all jobs.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function index()
    {
        return Job::all();
    }

    /**
     * Display the specified job.
     *
     * @param Job $job
     * @return Job
     */
    public function show(Job $job)
    {
        return $job;
    }

    /**
     * Store a newly created job in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|array
     */
    public function store(Request $request)
    {
        if ($request->user()->role != "recruiter") {
            return response()->json([
                'message' => 'Unauthorized. Only recruiters can post jobs.'
            ], 403);
        }

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

        $attributes['company_id'] = $request->user()->company->id;
        $job = Job::create($attributes);

        $tagNames = collect(explode(',', $request['tags']))->map(fn($tag) => trim($tag))->filter()->unique();
        $tags = $tagNames->map(fn($tagName) => Tag::firstOrCreate(['name' => $tagName]));
        $job->tags()->sync($tags->pluck('id'));
        return [
            'message' => 'Job posted successfully.',
            'job' => $job->load('tags')
        ];
    }

    /**
     * Update the specified job.
     *
     * @param Request $request
     * @param Job $job
     * @return \Illuminate\Http\JsonResponse|array
     */
    public function update(Request $request, Job $job)
    {
        if ($request->user()->role != "recruiter") {
            return response()->json([
                'message' => 'Unauthorized. Only recruiters can update jobs.'
            ], 403);
        }

        if ($request->user()->id != $job->company->user->id) {
            return response()->json([
                'message' => 'Unauthoried. You can edit only your own jobs.'
            ], 403);
        }

        $attributes = $request->validate([
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'title' => ['required', 'string', 'max:255'],
            'salary_range' => ['nullable', 'string', 'max:255'],
            'schedule' => ['required', Rule::in(['Part Time', 'Full Time'])],
            'location' => ['required', 'string'],
            'url' => ['required', 'url'],
            'featured' => ['required', 'boolean']
        ]);

        $job->update($attributes);

        return [
            'message' => 'Job updated successfully.',
            'job' => $job
        ];
    }

    /**
     * Soft delete the specified job.
     *
     * @param Request $request
     * @param Job $job
     * @return \Illuminate\Http\JsonResponse|array
     */
    public function destroy(Request $request, Job $job)
    {
        if ($request->user()->role != "recruiter") {
            return response()->json([
                'message' => 'Unauthorized. Only recruiters can delete jobs.'
            ], 403);
        }

        if ($request->user()->id != $job->company->user->id) {
            return response()->json([
                'message' => 'Unauthoried. You can delete only your own jobs.'
            ], 403);
        }

        $job->delete();

        return [
            'message' => 'Job deleted successfully.',
            'job' => $job
        ];
    }

    /**
     * Restore a soft-deleted job.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function restore(Request $request, $id)
    {
        if ($request->user()->role != "recruiter") {
            return response()->json([
                'message' => 'Unauthorized. Only recruiters can restore jobs.'
            ], 403);
        }

        $job = Job::withTrashed()->find($id);

        if (!$job) {
            return response([
                'message' => 'Job Not found'
            ], 404);
        }

        if ($request->user()->id != $job->company->user->id) {
            return response()->json([
                'message' => 'Unauthoried. You can restore only your own jobs.'
            ], 403);
        }

        $job->restore();

        return response([
            'message' => 'Job restored successfully.',
            'job' => $job
        ], 200);
    }

    /**
     * Permanently delete the specified soft-deleted job.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function forceDelete(Request $request, $id)
    {
        if ($request->user()->role != "recruiter") {
            return response()->json([
                'message' => 'Unauthorized. Only recruiters can delete jobs.'
            ], 403);
        }

        $job = Job::withTrashed()->find($id);

        if (!$job) {
            return response([
                'message' => 'Job Not found'
            ], 404);
        }

        if ($request->user()->id != $job->company->user->id) {
            return response()->json([
                'message' => 'Unauthoried. You can delete only your own jobs.'
            ], 403);
        }

        $job->forceDelete();

        return response([
            'message' => 'Job restored successfully.',
            'job' => $job
        ], 200);
    }
    //getting a recruiter's posted jobs
    public function myJobs(Request $request)
    {
        $jobs = $request->user()->company->jobs;
        if ($jobs->isEmpty()) return response()->json([
            'message' => "You haven't posted a job yet."
        ], 200);
        return response()->json([
            'jobs' => $jobs
        ], 200);
    }
    //getting a recruiter's soft deleted jobs
    public function myDeletedJobs(Request $request)
    {
        $jobs = $request->user()->company->jobs()->onlyTrashed()->get();
        if ($jobs->isEmpty()) return response()->json([
            'message' => "You haven't posted a job yet."
        ], 200);
        return response()->json([
            'jobs' => $jobs
        ], 200);
    }
}
