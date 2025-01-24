<?php

declare(strict_types=1);

namespace MoonShine\Advanced\Components\LinkGroup;

use MoonShine\Contracts\UI\HasIconContract;
use MoonShine\UI\Components\MoonShineComponent;
use MoonShine\UI\Traits\WithIcon;

/**
 * @method static static make(string $title, string $title, ?string $description = null)
 */
final class LinkItem extends MoonShineComponent implements HasIconContract
{
    use WithIcon;

    protected string $view = 'moonshine-advanced::components.link-group.item';

    public function __construct(
        private string $href,
        private string $title,
        private ?string $description = null,
    )
    {
        parent::__construct();
    }

    protected function viewData(): array
    {
        return [
            'href' => $this->href,
            'title' => $this->title,
            'description' => $this->description,
            'icon' => $this->getIcon(5, attributes: [
                'class' => 'flex'
            ]),
        ];
    }
}
