<?php

declare(strict_types=1);

namespace MoonShine\Advanced\Fields;

use Closure;
use MoonShine\AssetManager\Css;
use MoonShine\UI\Fields\Field;

class ButtonGroup extends Field
{
    /**
     * @var array<string, int|string>
     */
    protected array $options = [];

    protected bool $multiple = false;

    protected ?Closure $optionAttributes = null;

    protected string $view = 'moonshine-advanced::fields.button-group';

    protected function assets(): array
    {
        return [
            Css::make('vendor/moonshine-advanced/css/main.css'),
        ];
    }

    /**
     * @param array<string, int|string> $options
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

    public function multiple(): self
    {
        $this->multiple = true;

        return $this->group();
    }

    protected function resolveValue(): mixed
    {
        $value = parent::resolveValue();

        if($this->multiple && !\is_array($value)) {
            return [];
        }

        return $value;
    }

    protected function viewData(): array
    {
        return [
            'options' => $this->options,
            'multiple' => $this->multiple,
            'optionAttributes' => $this->optionAttributes,
        ];
    }
}
