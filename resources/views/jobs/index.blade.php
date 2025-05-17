<x-layout>
    <section class="text-center pt-6">
        <h1 class="font-bold text-4xl">Let's Find Your Next Job</h1>

        <x-forms.form action="/search" class="mt-6">
            <x-forms.input :label="false" name="q" placeholder="Web Developer..." />
        </x-forms.form>
    </section>
    <div class="mt-6 space-y-6">
        @foreach($jobs as $job)
        <x-job-card-wide :$job />
        @endforeach
    </div>
    <div class="flex items-center justify-center mt-6">
        {{$jobs->links()}}
    </div>
</x-layout>