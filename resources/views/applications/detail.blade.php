<x-auth-layout>
    @if($job->applications->isEmpty())
    <h1>No applications listed</h1>
    @else
    @foreach ($job->applications as $application)
    <div class="border p-4 mb-4">
        <h2 class="font-bold">{{ $application->user->name }}</h2>
        <p>Phone: {{ $application->user->work_profile->phone_number ?? 'N/A' }}</p>
        <p>Experience Level: {{ $application->user->work_profile->experience_level ?? 'N/A' }}</p>
        <p>Cover Letter: {{ $application->cover_letter }}</p>
        <a href="{{ asset('storage/' . $application->resume_path) }}" class="text-blue-600 hover:underline" target="_blank">Download Resume</a>
    </div>
    @endforeach
    @endif
</x-auth-layout>