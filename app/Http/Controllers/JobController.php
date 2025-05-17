<?php

namespace App\Http\Controllers;

use App\Models\Industry;
use App\Models\Job;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class JobController extends Controller
{
    public function home()
    {
        $featureJobs = Job::where('is_featured', true)->get();
        $recentJobs = Job::latest()->take(4)->get();
        $tags = Tag::all();
        return view('home', [
            'featuredJobs' => $featureJobs,
            'recentJobs' => $recentJobs,
            'tags' => $tags
        ]);
    }

    public function index()
    {
        $jobs = Job::latest()->paginate(5);
        return view('jobs.index', ['jobs' => $jobs]);
    }

    public function show(Job $job)
    {
        $similarJobs = Job::where('industry_id', $job->industry->id)->where('id', "!=", $job->id)->latest()->take(5)->get();

        return view('jobs.detail', [
            'job' => $job->load(['tags', 'company']),
            'similarJobs' => $similarJobs
        ]);
    }

    public function create()
    {
        $industries = Industry::all();
        return view('jobs.create', ['industries' => $industries]);
    }

    public function store(Request $request)
    {
        $jobAttributes = $request->validate([
            'title' => ['required', 'string'],
            'salary_range' => ['required'],
            'schedule' => ['required', Rule::in(['Part Time', 'Full Time'])],
            'location' => ['required'],
            'is_featured' => ['nullable', 'boolean'],
            'description' => ['required'],
            'requirements' => ['required'],
            'deadline' => ['required'],
            'experience_level' => ['required', Rule::in(['Entry', 'Mid', 'Senior'])],
            'is_remote' => ['nullable', 'boolean'],
            'industry_id' => ['required'],
        ]);
        $tagAttribute =  $request->validate([
            'tags' => ['required']
        ]);

        $tagsArray = array_map("trim", explode(",", $tagAttribute['tags']));
        $tags = array_map(function ($tag) {
            return Tag::firstOrCreate(['name' => $tag]);
        }, $tagsArray);
        $job = Job::create([
            'company_id' => Auth::user()->company->id,
            ...$jobAttributes
        ]);
        $job->tags()->attach(array_column($tags, 'id'));

        return redirect("/");
    }

    public function edit(Job $job)
    {
        $industries = Industry::all();
        return view('jobs.edit', ['job' => $job, 'industries' => $industries]);
    }

    public function update(Request $request, Job $job)
    {
        $jobAttributes = $request->validate([
            'title' => ['required', 'string'],
            'salary_range' => ['required'],
            'schedule' => ['required', Rule::in(['Part Time', 'Full Time'])],
            'location' => ['required'],
            'is_featured' => ['nullable', 'boolean'],
            'description' => ['required'],
            'requirements' => ['required'],
            'deadline' => ['required'],
            'experience_level' => ['required', Rule::in(['Entry', 'Mid', 'Senior'])],
            'is_remote' => ['nullable', 'boolean'],
            'industry_id' => ['required'],
        ]);
        $tagAttribute =  $request->validate([
            'tags' => ['required']
        ]);

        $tagsArray = array_map("trim", explode(",", $tagAttribute['tags']));
        $tags = array_map(function ($tag) {
            return Tag::firstOrCreate(['name' => $tag]);
        }, $tagsArray);
        $job->update($jobAttributes);
        $job->tags()->syncWithoutDetaching(array_column($tags, 'id'));

        return redirect("/");
    }
    public function destroy(Job $job)
    {
        $job->delete();
        return redirect()->back();
    }
}
