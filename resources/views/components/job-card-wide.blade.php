@props(['job'])

<x-panel class="flex gap-x-6">
    <div>
        <x-company-logo :company="$job->company" />
    </div>

    <div class="flex-1 flex flex-col">
        <a href="#" class="self-start text-sm text-gray-400 transition-colors duration-300">{{ $job->company->name }}</a>

        <h3 class="font-bold text-xl mt-3 group-hover:text-blue-800">
            <a href="/jobs/{{$job->id}}" target="_blank">
                {{ $job->title }}
            </a>
        </h3>

        <p class="text-sm text-gray-400 mt-auto">{{ $job->salary }}</p>
    </div>

    <div>
        @foreach($job->tags as $tag)
        <x-tag :$tag />
        @endforeach
    </div>
</x-panel>