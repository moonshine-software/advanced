<?php

declare(strict_types=1);

namespace MoonShine\Advanced\Fields;

use Closure;
use MoonShine\UI\Fields\Field;

class RadioGroup extends Field
{
    /**
     * @var array<int|string, int|string>
     */
    protected array $options = [];

    protected ?Closure $optionAttributes = null;

    protected string $view = 'moonshine-advanced::fields.radio-group';

    /**
     * @param array<int|string, int|string> $options
     */
    public function options(array $options): self
    {
        $this->options = $options;

        return $this;
    }

    /**
     * @param Closure(int|string $value): array $callback
     */
    public function optionAttributes(Closure $callback): self
    {
        $this->optionAttributes = $callback;

        return $this;
    }

    public function inline(): self
    {
        return $this->class(['flex-group-inline-list', 'flex', 'flex-wrap', 'gap-4']);
    }

    protected function viewData(): array
    {
        return [
            'options' => $this->options,
            'optionAttributes' => $this->optionAttributes,
        ];
    }
}
