@props([
    'href' => '#',
    'title',
    'description' => null,
    'icon' => null,
])
<a href="{{ $href }}" {{ $attributes->merge(['class' => 'link-group-item'])}}>
    <div>
        <div>{!! $title !!}</div>
        @if($description)
            <div class="link-group-description">{!! $description !!}</div>
        @endif
    </div>

    @if($icon)
        {!! $icon !!}
    @endif
</a>
