<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Job;
use Illuminate\Http\Request;


class JobController extends Controller
{
    //get all jobs including soft-deleted ones
    public function index()
    {
        $jobs = Job::withTrashed()->groupBy('deleted_at')->get();

        return response()->json(['jobs' => $jobs], 200);
    }

    // restore a soft-deleted job
    public function restore($id)
    {

        $job = Job::withTrashed()->find($id);

        if (!$job) {
            return response(['message' => 'Job not found'], 404);
        }



        $job->restore();

        return response()->json([
            'message' => 'Job restored successfully.',
            'job' => $job
        ], 200);
    }

    // permanently delete a soft-deleted job
    public function forceDelete($id)
    {

        $job = Job::withTrashed()->find($id);

        if (!$job) {
            return response(['message' => 'Job not found'], 404);
        }

        $job->forceDelete();

        return response()->json([
            'message' => 'Job deleted permanently.'
        ], 204);
    }
}
