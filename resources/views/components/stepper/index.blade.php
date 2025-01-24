@props([
    'components' => [],
    'finishComponent' => [],
    'nextButtons' => [],
    'finishButton',
    'defaultButton',
])
<div x-data="stepper" {{ $attributes }}>
    <div class="js-stepper-head-container">
        @foreach($components as $step)
            {!! $step->head() !!}
        @endforeach
    </div>

    <x-moonshine::layout.divider />

    <div class="js-stepper-content-container">
        @foreach($components as $step)
            <div style="display: none;" class="js-stepper-content js-stepper-content-{{ $loop->index+1 }}">
                <div class="js-stepper-content-html">
                    {!! $step !!}
                </div>

                <div>
                    @if($loop->last)
                        {!! $finishButton !!}
                    @else
                        {!! $nextButtons[$loop->index+1] !!}
                    @endif
                </div>
            </div>
        @endforeach

        <div style="display: none;" class="js-stepper-finish-content">
            @foreach($finishComponent as $component)
                {!! $component !!}
            @endforeach
        </div>
    </div>
</div>
