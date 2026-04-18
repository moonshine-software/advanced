@props([
    'contentClass' => 'async-tabs-content',
    'components' => [],
    'urlName' => null,
    'pushHistory' => false,
])
<div
    class="tabs"
    x-data="asyncTabs"
    @if($urlName)
        data-async-tabs-name="{{ $urlName }}"
        data-async-tabs-history="{{ $pushHistory ? 'push' : 'replace' }}"
    @endif
    {{ $attributes }}
>
    <ul class="tabs-list justify-start async-tabs-container">
        @foreach($components as $button)
            <li class="tabs-item">{!! $button !!}</li>
        @endforeach
    </ul>

    <div class="tabs-content">
        <div class="{{ $contentClass }}"></div>
    </div>
</div>
