@props([
    'formName' => 'default',
    'value',
    'values' => []
])
<div {{ $attributes->only(['style', 'class']) }}>
    @foreach($options as $option => $label)
        <div x-id="['field-{{ $formName }}']">
            <x-moonshine::form.label class="flex items-center gap-2">
                <x-moonshine::form.input
                    type="radio"
                    :attributes="$attributes->except(['type', 'checked', 'value', 'style', 'class', 'id'])
                        ->merge(['checked' => $option === $value])
                        ->merge($optionAttributes === null ? [] : $optionAttributes($option))"
                    value="{{ $option }}"
                />

                {{ $label }}
            </x-moonshine::form.label>
        </div>
    @endforeach
</div>
