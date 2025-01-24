<?php

declare(strict_types=1);

namespace MoonShine\Advanced\Components\LinkGroup;

use Illuminate\Support\Collection;
use MoonShine\UI\Components\AbstractWithComponents;

final class LinkGroup extends AbstractWithComponents
{
    protected string $view = 'moonshine-advanced::components.link-group.index';

    public function __construct(iterable $components = [])
    {
        $collection = new Collection($components);

        parent::__construct(
            $collection->ensure(LinkItem::class)
        );
    }
}
