<x-layout>
    <div class="max-w-5xl mx-auto px-4 py-8 bg-white/5">
        <div class="flex items-center gap-6 mb-8">
            <img
                src="{{$company->logo}}"
                alt="Company Logo"
                class="w-20 h-20 rounded-full object-cover border" />
            <div>
                <h1 class="text-3xl font-bold text-white/80">{{$company->name}}</h1>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-white/70 mb-10">
            <div>
                <p>
                    <span class="font-medium">Founded:</span> {{$company->founded}}
                </p>
            </div>
            <div>
                <p>
                    <span class="font-medium">Location:</span> {{$company->city}}, {{$company->state}}
                </p>
                <p>
                    <span class="font-medium">Website:</span>
                    <a href="{{$company->website}}" class="text-blue-600 hover:underline">
                        {{$company->website}}
                    </a>
                </p>
            </div>
        </div>

        <div class="mb-10">
            <h2 class="text-xl font-semibold text-white/80 mb-2">About Us</h2>
            <p class="text-white/70 leading-relaxed">{{$company->profile}}</p>
        </div>

        @if(count($company->jobs) > 0)
        <div>
            <h2 class="text-xl font-semibold text-white/80 mb-4">
                Currently Hiring
            </h2>
            <div class="space-y-4">
                @foreach($company->jobs as $job)
                <div
                    class="border p-4 rounded-lg hover:shadow-md hover:border-blue-800 transition duration-300">
                    <h3 class="text-lg font-semibold text-white/80">
                        {{$job->title}}
                    </h3>

                    @if($job->is_remote)
                    <p class="text-white/70">Remote • {{$job->schedule}}</p>

                    @else
                    <p class="text-white/70">{{$job->schedule}}</p>

                    @endif
                    <a
                        href="/jobs/{{$job->id}}"
                        class="text-indigo-600 hover:underline text-sm mt-2 inline-block">
                        View job details →
                    </a>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <div class="mt-10">
            <a
                href="{{$company->website}}"
                target="_blank"
                class="inline-block bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition">
                Visit Company Website
            </a>
        </div>
    </div>
</x-layout>