<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class JobController extends Controller
{

    public function index()
    {
        return Job::all();
    }

    public function show(Job $job)
    {
        return $job;
    }

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
            'featured' => ['required', 'boolean']
        ]);


        $attributes['company_id'] = $request->user()->company->id;
        $job = Job::create($attributes);
        return [
            'message' => 'Job posted successfully.',
            'job' => $job
        ];
    }


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

    public function restore($id)
    {
        $job = Job::withTrashed()->find($id);
        if (!$job) {
            return response([
                'message' => 'Job Not found'
            ], 404);
        }
        $job->restore();
        return response([
            'message' => 'Job restored successfully.',
            'job' => $job
        ], 200);
    }

    public function forceDelete($id)
    {
        $job = Job::withTrashed()->find($id);
        if (!$job) {
            return response([
                'message' => 'Job not found'
            ], 404);
        }
        $job->forceDelete();
        return response([
            'message' => 'Job deleted permanently.',
            'job' => $job
        ], 200);
    }
}
