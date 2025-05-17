<x-layout>
    <x-page-heading>Register</x-page-heading>

    <x-forms.form method="POST" action="/register/job-seeker" enctype="multipart/form-data">
        <x-forms.input label="Name" name="name" />
        <x-forms.input label="Email" name="email" type="email" />
        <x-forms.input label="Password" name="password" type="password" />
        <x-forms.input label="Password Confirmation" name="password_confirmation" type="password" />

        <x-forms.divider />

        <x-forms.input label="Phone" name="phone_number" />
        <x-forms.input label="Birthday" name="birthday" type="date" />
        <x-forms.input label="Profession" name="profession" />
        <x-forms.select name="experience_level" label="Experience Level">
            <option value="Entry">Entry</option>
            <option value="Mid">Mid</option>
            <option value="Senior">Senior</option>
        </x-forms.select>
        <x-forms.input label="Expected salary" name="expected_salary" />
        <x-forms.input label="Skills (comma separated)" name="skills" />
        <x-forms.input label="Profile picture" name="profile_picture" type="file" />
        <x-forms.textarea label="Overview" name="overview">{{old("overview")}}</x-forms.textarea>

        <x-forms.button>Create Account</x-forms.button>
    </x-forms.form>
    <div class="mt-4 text-center">
        <a href="/register/recruiter" class="text-blue-400 hover:text-blue-300 underline">Register as a Recruiter</a>
        <a href="/login" class="text-blue-400 hover:text-blue-300 underline block">Already have an account? Login</a>
    </div>
</x-layout>