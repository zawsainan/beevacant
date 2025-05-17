@php
$company = Auth::user()->company;
@endphp

<x-auth-layout>
    <div class="max-w-4xl mx-auto p-6 bg-white/5 text-white rounded-xl shadow-lg mt-10">
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-4">
                <img
                    src="{{asset('storage/'.$company->logo)}}"
                    alt="Company Logo"
                    class="w-20 h-20 rounded-full object-cover" />
                <div>
                    <h1 class="text-3xl font-bold">{{$company->name}}</h1>
                    <p class="text-white/70 text-sm">
                        Founded in {{$company->founded}}
                    </p>
                </div>
            </div>

            <a href="/profile/recruiter/edit" class="px-6 py-2 bg-blue-600 rounded-lg text-sm hover:bg-blue-700">Edit</a>

        </div>

        <p class="mb-2">

            <strong>Website:</strong>{{" "}}
            <a
                href="{{$company->website}}"
                class="text-blue-400 underline"
                target="_blank"
                rel="noreferrer">
                {{$company->website}}
            </a>
        </p>
        <p class="mb-2">
            <strong>Location:</strong> {{$company->city}}, {{$company->state}}
        </p>
        <p class="mb-4">
            <strong>About Company:</strong> {{$company->profile}}
        </p>

        <h2 class="text-2xl font-semibold mt-6 mb-2">My Jobs</h2>
        @if($company->jobs->isEmpty())
        <p class="text-white/60">You haven't posted any jobs yet.</p>
        @else
        <table class="table-auto w-full border border-gray-200 shadow-md rounded-lg overflow-hidden text-sm">
            <thead class="bg-gray-100 text-gray-700 uppercase text-xs tracking-wider">
                <tr>
                    <th class="px-4 py-3 text-left">Title</th>
                    <th class="px-4 py-3 text-left">Salary</th>
                    <th class="px-4 py-3 text-left">Schedule</th>
                    <th class="px-4 py-3 text-left">Remote</th>
                    <th class="px-4 py-3 text-left">Deadline</th>
                    <th class="px-4 py-3 text-left">Applications</th>
                    <th class="px-4 py-3 text-left">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach ($company->jobs as $job)
                <tr class="border-t">
                    <td class="px-4 py-2">{{ $job->title }}</td>
                    <td class="px-4 py-2">{{ $job->salary_range }}</td>
                    <td class="px-4 py-2">{{ $job->schedule }}</td>
                    <td class="px-4 py-2">{{ $job->remote ? 'Yes' : 'No' }}</td>
                    <td class="px-4 py-2">{{ $job->deadline }}</td>
                    <td class="px-4 py-2">
                        <a href="/jobs/{{$job->id}}/applications" class="text-blue-600 hover:underline">View</a>
                    </td>
                    <td class="px-4 py-2 space-x-4 flex justify-center">
                        <a href="/jobs/{{$job->id}}" class="text-purple-600 hover:underline">Detail</a>
                        <a href="/jobs/{{$job->id}}/edit" class="text-yellow-600 hover:underline">Edit</a>
                        <form action="/jobs/{{$job->id}}" method="POST" class="inline-block"
                            onsubmit="return confirm('Are you sure you want to delete this job?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach

            </tbody>
        </table>

        @endif

        <div class="mt-8 flex justify-left">
            <form action="/logout" method="post">
                @csrf
                @method("DELETE")
                <button
                    class="px-6 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm transition">
                    Logout
                </button>
            </form>
        </div>
    </div>
</x-auth-layout>