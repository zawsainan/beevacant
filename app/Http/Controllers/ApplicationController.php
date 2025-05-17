<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Job;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Job $job)
    {
        return view("applications.create", ['job' => $job]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Job $job)
    {
        $request->validate([
            'cover_letter' => ['nullable', 'string'],
            'resume' => ['required', 'mimes:pdf,doc,docx', 'max:2048']
        ]);
        $resume_path = null;
        if ($request->hasFile('resume')) {
            $resume_path = $request->file('resume')->store('resumes', 'public');
        }
        Application::create([
            'cover_letter' => $request['cover_letter'],
            'resume_path' => $resume_path,
            'job_id' => $job->id,
            'user_id' => auth()->user()->id
        ]);
        return redirect("/")->with('message', 'Your application has been submitted successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Job $job)
    {
        return view("applications.detail", ["job" => $job]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Application $application)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Application $application)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Application $application)
    {
        //
    }
}
