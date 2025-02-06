@props([
    'formName' => 'default',
    'value',
    'multiple' => false,
    'values' => []
])
<div {{ $attributes->merge(['class' => 'advanced-button-group']) }}>
    @foreach($options as $option => $label)
        <x-moonshine::link-button
            :attributes="$attributes->only([])->merge($optionAttributes === null ? [] : $optionAttributes($option))"
        >
            <label>
                <x-moonshine::form.input
                    :type="$multiple ? 'checkbox' : 'radio'"
                    :attributes="$attributes->only(['name'])->merge(['checked' => $multiple ? in_array($option, $value) : $option == $value])"
                    value="{{ $option }}"
                />
            </label>
            {!! $label !!}
        </x-moonshine::link-button>
    @endforeach
</div>
