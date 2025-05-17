@props(['company', 'width' => 90])

<img src="{{ asset($company->logo) }}" alt="" class="rounded-xl" width="{{ $width }}">