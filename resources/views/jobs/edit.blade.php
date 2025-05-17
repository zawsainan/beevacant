<x-auth-layout>
    <x-page-heading>Edit Job</x-page-heading>
    <x-forms.form method="POST" action="/jobs/{{$job->id}}">
        {{-- Basic Job Info --}}
        <x-forms.input label="Title" name="title" placeholder="CEO" value="{{$job->title}}" />
        <x-forms.input label="Salary Range" name="salary_range" placeholder="400000 - 600000 MMK" value="{{$job->salary_range}}" />
        <x-forms.input label="Location" name="location" placeholder="Winter Park, Florida" value="{{$job->location}}" />

        <x-forms.select label="Schedule" name="schedule">
            <option class="text-black dark:text-white dark:bg-gray-800" value="Part Time">Part Time</option>
            <option class="text-black dark:text-white dark:bg-gray-800" value="Full Time">Full Time</option>
        </x-forms.select>

        <x-forms.select label="Experience Level" name="experience_level">
            <option class="text-black dark:text-white dark:bg-gray-800" value="Entry">Entry</option>
            <option class="text-black dark:text-white dark:bg-gray-800" value="Mid">Mid</option>
            <option class="text-black dark:text-white dark:bg-gray-800" value="Senior">Senior</option>
        </x-forms.select>

        <x-forms.select label="Industry" name="industry_id">
            @foreach($industries as $industry)
            <option class="text-black dark:text-white dark:bg-gray-800" value="{{ $industry->id }}">{{ $industry->name }}</option>
            @endforeach
        </x-forms.select>

        {{-- Job Settings --}}
        <input type="hidden" name="is_featured" value="0" />
        <x-forms.checkbox label="Feature (Costs Extra)" name="is_featured" value="1" :isChecked="$job->is_featured" />

        <input type="hidden" name="is_remote" value="0" />
        <x-forms.checkbox label="Remote" name="is_remote" value="1" :isChecked="$job->is_remote" />

        <x-forms.input label="Deadline" name="deadline" type="date" min="2025-05-05" value="{{$job->deadline}}" />

        <x-forms.divider />

        {{-- Description Section --}}
        <x-forms.input label="Tags (comma separated)" name="tags" placeholder="laracasts, video, education" :value="implode(', ',$job->tags->pluck('name')->toArray())" />
        <x-forms.textarea label="Description" name="description">{{$job->description}}</x-forms.textarea>
        <x-forms.textarea label="Requirements" name="requirements" placeholder="List requirements separated by dashes (e.g. - Strong communication skills - 2+ years experience)">
            {{$job->requirements}}
        </x-forms.textarea>

        <x-forms.button>Update</x-forms.button>
    </x-forms.form>
</x-auth-layout>