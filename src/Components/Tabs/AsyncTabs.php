<?php

declare(strict_types=1);

namespace MoonShine\Advanced\Components\Tabs;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use MoonShine\AssetManager\Js;
use MoonShine\Support\DTOs\AsyncCallback;
use MoonShine\UI\Components\AbstractWithComponents;
use MoonShine\UI\Components\ActionButton;

final class AsyncTabs extends AbstractWithComponents
{
    protected string $view = 'moonshine-advanced::components.tabs.index';

    private readonly string $contentClass;

    private ?string $urlName = null;

    private bool $pushHistory = false;

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
                ->values()
                ->map(function (AsyncTab $tab, int $index) {
                    $button = ActionButton::make($tab->label, $tab->href)
                        ->customView('moonshine-advanced::components.tabs.action-tab')
                        ->async(
                            selector: ".{$this->contentClass}",
                            callback: AsyncCallback::with(afterResponse: 'asyncTabs')
                        );

                    $button->customAttributes([
                        'data-async-tab-slug' => $this->resolveSlug($tab, $index),
                    ]);

                    return $button;
                })
        );
    }

    /**
     * Persist active tab in the URL using a query parameter.
     *
     * @param  string  $name  Query param name for this tab group. Defaults to "tab".
     *                        Use a unique value for nested groups or when several
     *                        AsyncTabs coexist on one page.
     * @param  bool  $pushHistory  Push a new history entry on each tab switch so that
     *                             Back/Forward navigate between tabs. Defaults to
     *                             replacing the current entry.
     */
    public function withUrl(string $name = 'tab', bool $pushHistory = false): self
    {
        $this->urlName = $name;
        $this->pushHistory = $pushHistory;

        return $this;
    }

    private function resolveSlug(AsyncTab $tab, int $index): string
    {
        if ($tab->slug !== null) {
            return $tab->slug;
        }

        $fromLabel = Str::slug($tab->label);

        return $fromLabel !== '' ? $fromLabel : (string) $index;
    }

    protected function viewData(): array
    {
        return [
            'contentClass' => $this->contentClass,
            'urlName' => $this->urlName,
            'pushHistory' => $this->pushHistory,
        ];
    }
}
