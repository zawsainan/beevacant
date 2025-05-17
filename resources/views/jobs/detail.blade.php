<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pixel Positions</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@400;500;600&display=swap"
        rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-black text-white font-hanken-grotesk pb-20">
    <div class="px-10">
        <main class="mt-10 max-w-[986px] mx-auto">
            <div class="max-w-3xl mx-auto">
                <div class="bg-white/5 p-6 rounded-xl border border-transparent hover:border-blue-800 transition-all">
                    <div class="mb-6">
                        <h1 class="text-3xl font-bold mb-2">{{$job->title}}</h1>
                        <p class="text-blue-400">at {{$job->company->name}}</p>
                        <p class="text-sm text-white/70">
                            Posted {{$job->created_at->diffForHumans()}}
                        </p>
                    </div>

                    <div class="grid sm:grid-cols-2 gap-4 mb-6">
                        <div>
                            <p class="font-semibold text-white/80">Industry</p>
                            <p>{{$job->industry->name}}</p>
                        </div>
                        <div>
                            <p class="font-semibold text-white/80">Location</p>
                            <p>{{$job->location}}</p>
                        </div>
                        <div>
                            <p class="font-semibold text-white/80">Schedule</p>
                            <p>
                                {{$job->schedule}}
                                {{$job->is_remote ? " - Remote" : ""}}
                            </p>
                        </div>
                        <div>
                            <p class="font-semibold text-white/80">Experience Level</p>
                            <p>{{$job->experience_level}}</p>
                        </div>
                        <div>
                            <p class="font-semibold text-white/80">Salary Range</p>
                            <p>{{$job->salary_range}}</p>
                        </div>
                        <div>
                            <p class="font-semibold text-white/80">Deadline</p>
                            <p>{{$job->deadline}}</p>
                        </div>
                    </div>

                    <div class="mb-6">
                        <h2 class="text-xl font-semibold mb-2">Job Description</h2>
                        <p class="text-white/80">{{$job->description}}</p>
                    </div>

                    <div class="mb-6">
                        <h2 class="text-xl font-semibold mb-2">Requirements</h2>
                        <ul class="list-disc pl-5 text-white/80 space-y-1">
                            @foreach(array_filter(array_map('trim',explode("-",$job->requirements))) as $requirement)
                            <li>{{$requirement}}</li>
                            @endforeach
                        </ul>
                    </div>

                    @if(auth()->check())
                        <div class="mt-6">
                        @if(auth()->user()->role == "job_seeker")
                        <a
                            href="/jobs/{{$job->id}}/apply"
                            target="_blank"
                            class="inline-block bg-blue-800 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-lg transition">
                            Apply Now
                        </a>
                        @endif
                        @can("edit-job",$job)
                        <a
                            href="/jobs/{{$job->id}}/edit"
                            class="inline-block bg-blue-800 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-lg transition">
                            Edit
                        </a>
                        @endcan
                    </div>
                    @endif
                    @if(count($similarJobs) > 0)
                    <h2 class="text-xl font-semibold mb-2 mt-4">Similar Jobs</h2>
                    <div class="mt-4 space-y-3">
                        @foreach($similarJobs as $similarJob)
                        <div
                            class="border p-4 rounded-lg hover:shadow-md hover:border-blue-800 transition duration-300">
                            <h3 class="text-lg font-semibold text-white/80">
                                {{$similarJob->title}}
                            </h3>
                            @if($job->is_remote)
                            <p class="text-white/70">Remote • {{$similarJob->schedule}}</p>
                            @else
                            <p class="text-white/70">{{$similarJob->schedule}}</p>
                            @endif

                            <a
                                href="/jobs/{{$similarJob->id}}"
                                class="text-indigo-600 hover:underline text-sm mt-2 inline-block">
                                View job details →
                            </a>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
        </main>
    </div>

</body>

</html>