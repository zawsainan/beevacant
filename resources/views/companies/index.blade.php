<x-layout>
    <div className="space-y-6">
        @foreach($companies as $company)
        <div class="bg-white/5 text-white rounded-2xl shadow-lg p-6 flex gap-4 transition-colors duration-300 border border-transparent hover:border-1 hover:border-blue-800">
            <img
                src="{{asset('storage/logos/'.$company->logo)}}"
                alt="Company Logo"
                class="w-20 h-20 rounded-full object-cover border-4 border-white" />
            <div>
                <a href="/companies/{{$company->id}}" class="text-lg font-bold mb-1">{{$company->name}}</a>
                <p class="text-sm text-white/80">{{$company->profile}}</p>
            </div>
        </div>
        @endforeach
    </div>
    <div class="flex items-center justify-center mt-6">
        {{$companies->links()}}
    </div>
</x-layout>