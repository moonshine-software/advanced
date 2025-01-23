@props([
    'inDropdown' => false,
    'hasComponent' => false,
    'url' => '#',
    'icon' => '',
    'label' => '',
    'component' => null,
    'badge' => false,
])
<x-moonshine::link
    :attributes="$attributes->class('tabs-button')"
    :href="$url"
    :badge="$badge"
>
    <x-slot:icon>{!! $icon !!}</x-slot:icon>

    {!! $label !!}
</x-moonshine::link>

@if($hasComponent)
    <template x-teleport="body">
        {!! $component !!}
    </template>
@endif

