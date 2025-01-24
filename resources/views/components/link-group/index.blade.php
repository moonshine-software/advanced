@props([
    'components' => []
])
<div {{ $attributes->merge(['class' => 'link-group'])}}>
    @foreach($components as $link)
        {!! $link !!}
    @endforeach
</div>
