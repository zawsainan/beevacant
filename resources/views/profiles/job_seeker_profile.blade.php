@php
$profile = Auth::user()->work_profile;
@endphp
<x-auth-layout>
    <div class="max-w-4xl mx-auto mt-8 p-6 bg-white/5 shadow-lg rounded-2xl text-white">
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-6">
                <img
                    src="{{asset('storage/'.$profile->profile_picture)}}"
                    alt="Profile Picture"
                    class="w-24 h-24 rounded-full object-cover border border-white/20" />
                <div>
                    <h2 class="text-2xl font-semibold">
                        {{auth()->user()->name}}
                    </h2>
                    <p class="text-sm text-gray-300">
                        {{$profile->phone_number}}
                    </p>
                    <p class="text-sm text-gray-300">
                        Birthday: {{$profile->birthday}}
                    </p>
                </div>
            </div>
            <a href="/profile/job-seeker/edit" class="px-6 py-2 bg-blue-600 rounded-lg text-sm hover:bg-blue-700">Edit</a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
            <div>
                <span class="font-medium text-gray-400">Profession:</span>{{" "}}
                {{$profile->profession}}
            </div>
            <div>
                <span class="font-medium text-gray-400">
                    Open to work:
                </span>{{" "}}
                {{$profile->is_open_to_work ? "Yes" : "No"}}
            </div>
            <div>
                <span class="font-medium text-gray-400">Experience Level:</span>{{" "}}
                {{$profile->experience_level}}
            </div>
            <div>
                <span class="font-medium text-gray-400">Expected Salary:</span>{{" "}}
                {{$profile->expected_salary ?? "Not specified"}}
            </div>
        </div>

        <div class="mt-6">
            <h3 class="font-semibold text-white mb-2">Overview</h3>
            <p class="text-gray-200">
                {{$profile->overview ?? "No overview provided."}}
            </p>
        </div>

        <div class="mt-6">
            <h3 class="font-semibold text-white mb-2">Skills</h3>
            <div class="flex flex-wrap gap-2">
                @if(!empty($profile->skills))
                @foreach($profile->skills as $skill)
                <span
                    class="px-3 py-1 bg-blue-500/10 text-blue-300 rounded-full text-sm">
                    {{$skill}}
                </span>
                @endforeach
                @else
                <p class="text-gray-300">No skills listed.</p>
                @endif
            </div>
        </div>
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