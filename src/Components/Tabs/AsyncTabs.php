<?php

declare(strict_types=1);

namespace MoonShine\Advanced\Components\Tabs;

use Illuminate\Support\Collection;
use MoonShine\AssetManager\Js;
use MoonShine\Support\DTOs\AsyncCallback;
use MoonShine\UI\Components\AbstractWithComponents;
use MoonShine\UI\Components\ActionButton;

final class AsyncTabs extends AbstractWithComponents
{
    protected string $view = 'moonshine-advanced::components.tabs.index';

    private string $contentClass;

    protected function assets(): array
    {
        return [
            Js::make('vendor/moonshine-advanced/js/app.js'),
        ];
    }

    public function __construct(iterable $components = [])
    {
        $collection = new Collection($components);

        $id = spl_object_id($this);

        $this->contentClass = "async-tabs-content-$id";

        parent::__construct(
            $collection
                ->ensure(AsyncTab::class)
                ->map(
                    fn (AsyncTab $tab) => ActionButton::make($tab->label, $tab->href)
                        ->customView('moonshine-advanced::components.tabs.action-tab')
                        ->async(
                            selector: ".{$this->contentClass}",
                            callback: AsyncCallback::with(afterResponse: 'asyncTabs')
                        )
                )
        );
    }

    protected function viewData(): array
    {
        return [
            'contentClass' => $this->contentClass,
        ];
    }
}
