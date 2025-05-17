@props(['label', 'name','isChecked' => false])

@php
$defaults = [
'type' => 'checkbox',
'id' => $name,
'name' => $name,
'value' => old($name)
];

if($isChecked) $defaults['checked'] = "";
@endphp

<x-forms.field :$label :$name>
    <div class="rounded-xl bg-white/10 border border-white/10 px-5 py-4 w-full">
        <input {{ $attributes($defaults) }}>
        <span class="pl-1">{{ $label }}</span>
    </div>
</x-forms.field>