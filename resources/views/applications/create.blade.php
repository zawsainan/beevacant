<x-auth-layout>
    <x-page-heading>We'd love to hear from you</x-page-heading>
    <p class="text-gray-600 mb-8 text-center">
        Please fill in the form below to submit your application.
    </p>
    <x-forms.form method="Post" enctype="multipart/form-data">
        <x-forms.textarea label="Cover Letter (optional)" name="cover_letter"></x-forms.textarea>
        <x-forms.input label="Resume" name="resume" type="file" />
        <x-forms.button>Apply</x-forms.button>
    </x-forms.form>
</x-auth-layout>