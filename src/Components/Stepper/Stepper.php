<?php

declare(strict_types=1);

namespace MoonShine\Advanced\Components\Stepper;

use Closure;
use Illuminate\Support\Collection;
use MoonShine\AssetManager\Css;
use MoonShine\AssetManager\Js;
use MoonShine\Contracts\UI\ActionButtonContract;
use MoonShine\UI\Components\AbstractWithComponents;
use MoonShine\UI\Components\ActionButton;
use Throwable;

/**
 * @method static static make(iterable $components = [], iterable $finishComponents = [], string $nextText = 'Next', string $finishText = 'Finish')
 */
final class Stepper extends AbstractWithComponents
{
    protected string $view = 'moonshine-advanced::components.stepper.index';

    private ?Closure $nextButton;

    private ActionButtonContract $finishButton;

    public function __construct(
        iterable $components = [],
        private readonly iterable $finishComponent = [],
        private readonly string $nextText = 'Next',
        private readonly string $finishText = 'Finish',
    ) {
        $collection = new Collection($components);

        $this->finishButton = ActionButton::make($this->finishText)->onClick(fn (): string => 'finish()');
        $this->nextButton = static fn (ActionButtonContract $btn): ActionButtonContract => $btn;

        parent::__construct(
            $collection->ensure(Step::class)->map(fn (Step $step, int $index): Step => $step->index($index + 1)),
        );
    }

    protected function assets(): array
    {
        return [
            Css::make('vendor/moonshine-advanced/css/main.css'),
            Js::make('vendor/moonshine-advanced/js/app.js'),
        ];
    }

    public function lock(): self
    {
        return $this->customAttributes([
            'data-lock' => true,
        ]);
    }

    public function lockWhenFinish(): self
    {
        return $this->customAttributes([
            'data-lock-when-finish' => true,
        ]);
    }

    public function current(int $index): self
    {
        $this->customAttributes([
            'data-current' => $index,
        ]);

        return $this->setComponents(
            $this->getComponents()->map(
                fn (Step $step, int $i) => $step
                ->when(
                    $i < $index,
                    fn (Step $s): Step => $s->done()
                )
                ->when(
                    $i === $index,
                    fn (Step $s): Step => $s->active()
                )
            )
        );
    }

    public function finished(): self
    {
        return $this->current($this->getComponents()->count() + 1);
    }

    /**
     * @param  Closure(ActionButtonContract $btn, int $index): ActionButtonContract  $callback
     */
    public function changeNextButton(Closure $callback): self
    {
        $this->nextButton = $callback;

        return $this;
    }

    /**
     * @param  Closure(ActionButtonContract $btn, self $ctx): self  $callback
     */
    public function changeFinishButton(Closure $callback): self
    {
        $this->finishButton = $callback($this->finishButton, $this);

        return $this;
    }

    /**
     * @throws Throwable
     */
    protected function viewData(): array
    {
        $nextButtons = [];

        foreach ($this->getComponents() as $index => $step) {
            $nextButtons[$index] = call_user_func($this->nextButton, ActionButton::make($this->nextText)->onClick(fn (): string => 'next()'), $index);
        }

        return [
            'finishComponent' => $this->finishComponent,
            'nextButtons' => $nextButtons,
            'finishButton' => $this->finishButton,
        ];
    }
}
