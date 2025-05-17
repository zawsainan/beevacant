@php
$company = Auth::user()->company;
@endphp
<x-auth-layout>
    <x-page-heading>Edit Company Profile</x-page-heading>

    <x-forms.form method="POST" action="/profile/recruiter/edit" enctype="multipart/form-data">
        <x-forms.input label="Company Name" name="name" value="{{$company->name}}" />
        <x-forms.input label="Company Logo" name="logo" type="file" />
        <x-forms.textarea label="Company Profile" name="profile">
            {{$company->profile}}
        </x-forms.textarea>
        <x-forms.input label="City" name="city" value="{{$company->city}}" />
        <x-forms.input label="State" name="state" value="{{$company->state}}" />
        <x-forms.input label="Founded year" name="founded" value="{{$company->founded}}" />
        <x-forms.input label="Company website" name="website" value="{{$company->website}}" />

        <x-forms.button>Update</x-forms.button>
    </x-forms.form>
</x-auth-layout>