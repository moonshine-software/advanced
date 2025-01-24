@props([
    'done' => false,
    'active' => false,
    'index' => 1,
    'title' => null,
    'description' => null,
    'icon',
])
<div {{ $attributes->merge(['class' => 'js-stepper-head js-stepper-head-' . $index, '@click' => 'current(`'.$index.'`)']) }}>
    <div class="js-stepper-head-state-active" @if(!$active && !$done) style="display: none" @endif>
        <div class="flex gap-3 items-center">
            <x-moonshine::badge color="secondary">
                {!! $icon ?: $index !!}
            </x-moonshine::badge>
            <div>
                <div>{{ $title ?? $index }}</div>
                @if($description)
                    <div class="js-stepper-head-description">{{ $description }}</div>
                @endif
            </div>
        </div>
    </div>
    <div class="js-stepper-head-state-default {{ $done ? 'js-stepper-head-state-done' : '' }}"
         @if(!$active || $done) style="display: none" @endif>
        <div class="btn">
            <span>{{ $index }}</span>
        </div>
    </div>
</div>
