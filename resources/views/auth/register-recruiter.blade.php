<x-layout>
    <x-page-heading>Register</x-page-heading>

    <x-forms.form method="POST" action="/register/recruiter" enctype="multipart/form-data">
        <x-forms.input label="Name" name="name" />
        <x-forms.input label="Email" name="email" type="email" />
        <x-forms.input label="Password" name="password" type="password" />
        <x-forms.input label="Password Confirmation" name="password_confirmation" type="password" />

        <x-forms.divider />

        <x-forms.input label="Company Name" name="company" />
        <x-forms.input label="Company Logo" name="logo" type="file" />
        <x-forms.textarea label="Company Profile" name="profile">{{old("profile")}}</x-forms.textarea>
        <x-forms.input label="City" name="city" />
        <x-forms.input label="State" name="state" />
        <x-forms.input label="Founded year" name="founded" />
        <x-forms.input label="Company website" name="website" />

        <x-forms.button>Create Account</x-forms.button>
    </x-forms.form>
    <div class="mt-4 text-center">
        <a href="/register/job-seeker" class="text-blue-400 hover:text-blue-300 underline">Register as a Job Seeker</a>
        <a href="/login" class="text-blue-400 hover:text-blue-300 underline block">Already have an account? Login</a>
    </div>
</x-layout>