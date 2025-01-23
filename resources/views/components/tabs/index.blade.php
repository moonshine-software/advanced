@props([
    'contentClass' => 'async-tabs-content',
    'components' => []
])
<div class="tabs" x-data="asyncTabs" {{ $attributes }}>
    <ul class="tabs-list justify-start async-tabs-container">
        @foreach($components as $button)
            <li class="tabs-item">{!! $button !!}</li>
        @endforeach
    </ul>

    <div class="tabs-content">
        <div class="{{ $contentClass }}"></div>
    </div>
</div>
