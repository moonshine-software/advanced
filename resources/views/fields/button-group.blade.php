@props([
    'formName' => 'default',
    'column',
    'value',
    'multiple' => false,
    'values' => []
])
<div {{ $attributes->only(['class'])->merge(['class' => 'advanced-button-group']) }} data-validation-field="{{ $column }}">
    @foreach($options as $option => $label)
        <x-moonshine::link-button
            :attributes="$attributes->only([])->merge($optionAttributes === null ? [] : $optionAttributes($option))"
        >
            <label>
                <x-moonshine::form.input
                    :type="$multiple ? 'checkbox' : 'radio'"
                    :attributes="$attributes->except(['type', 'checked', 'value', 'style', 'class', 'id'])->merge(['checked' => $multiple ? in_array($option, $value) : $option == $value])"
                    value="{{ $option }}"
                />
            </label>
            {!! $label !!}
        </x-moonshine::link-button>
    @endforeach
</div>
