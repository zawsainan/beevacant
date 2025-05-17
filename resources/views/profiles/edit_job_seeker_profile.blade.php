@php
$user = Auth::user();
$profile = $user->work_profile;
@endphp
<x-auth-layout>
    <x-page-heading>Edit Profile</x-page-heading>

    <x-forms.form method="POST" action="/profile/job-seeker/edit" enctype="multipart/form-data">
        <x-forms.input label="Name" name="name" value="{{$user->name}}" />

        <x-forms.divider />
        <x-forms.input label="Phone" name="phone_number" value="{{$profile->phone_number}}" />
        <x-forms.input label="Birthday" name="birthday" type="date" value="{{$profile->birthday}}" />
        <x-forms.input label="Profession" name="profession" value="{{$profile->profession}}" />
        <x-forms.select name="experience_level" label="Experience Level">
            <option @selected(old('experience_level',$profile->experience_level) == "Entry") value="Entry">Entry</option>
            <option @selected(old('experience_level',$profile->experience_level) == "Mid") value="Mid">Mid</option>
            <option @selected(old('experience_level',$profile->experience_level) == "Senior") value="Senior">Senior</option>
        </x-forms.select>
        <x-forms.input label="Expected salary" name="expected_salary" value="{{$profile->expected_salary}}" />
        <x-forms.input label="Skills (comma separated)" name="skills" value="{{implode(',',$profile->skills)}}" />
        <x-forms.input label="Profile picture" name="profile_picture" type="file" value="{{asset('profile_pictures/'.$profile->profile_picture)}}" />
        <x-forms.textarea label="Overview" name="overview">
            {{$profile->overview}}
        </x-forms.textarea>

        <x-forms.button>Update</x-forms.button>
    </x-forms.form>
</x-auth-layout>