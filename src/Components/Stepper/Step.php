<?php

declare(strict_types=1);

namespace MoonShine\Advanced\Components\Stepper;

use Closure;
use Illuminate\Contracts\Support\Renderable;
use MoonShine\Contracts\UI\HasIconContract;
use MoonShine\Support\AlpineJs;
use MoonShine\UI\Components\AbstractWithComponents;
use MoonShine\UI\Traits\WithIcon;

/** @method static static make(iterable $components = [], ?string $title = null, ?string $description = null) */
final class Step extends AbstractWithComponents implements HasIconContract
{
    use WithIcon;

    protected string $view = 'moonshine-advanced::components.stepper.step';

    private bool $done = false;

    private bool $active = false;

    private int $index = 1;

    public function __construct(
        iterable $components = [],
        private readonly ?string $title = null,
        private readonly ?string $description = null,
    ) {
        parent::__construct($components);
    }

    public function async(string $url, array $events = []): self
    {
        return $this->customAttributes([
            'data-async-url' => $url,
            'data-async-events' => AlpineJs::prepareEvents($events),
        ]);
    }

    public function whenFinishEvents(array $events): self
    {
        return $this->customAttributes([
            'data-async-finish-events' => AlpineJs::prepareEvents($events),
        ]);
    }

    public function index(int $index): self
    {
        assert($index > 0, 'Expected to be greater than zero');
        $this->index = $index;

        return $this;
    }

    public function done(): self
    {
        $this->done = true;

        return $this;
    }

    public function active(): self
    {
        $this->active = true;

        return $this;
    }

    public function head(): Renderable|Closure|string
    {
        return view('moonshine-advanced::components.stepper.head', $this->toArray());
    }

    public function nextLock(): self
    {
        return $this->customAttributes([
            'data-next-lock' => true
        ]);
    }

    protected function viewData(): array
    {
        return [
            'title' => $this->title,
            'description' => $this->description,
            'done' => $this->done,
            'active' => $this->active,
            'index' => $this->index,
            'icon' => $this->getIcon(5),
        ];
    }
}
