<?php

declare(strict_types=1);

namespace MoonShine\Advanced\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use MoonShine\Laravel\Layouts\BaseLayout;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\MenuManager\MenuItem;
use MoonShine\Support\DTOs\AsyncCallback;
use MoonShine\UI\Components\ActionButton;

final class AdvancedServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'moonshine-advanced');

        Blade::componentNamespace('MoonShine\Advanced\Components', 'moonshine-advanced');

        MenuItem::macro('spa', function () {
            /** @var MenuItem $this */
            /** @var ModelResource $filler */
            $filler = value($this->getFiller());

            return $this->setUrl(
                fn () => $filler->getFragmentLoadUrl(BaseLayout::CONTENT_FRAGMENT_NAME)
            )->changeButton(
                static fn (ActionButton $btn): ActionButton => $btn->async(
                    selector: '#' . BaseLayout::CONTENT_ID,
                    callback: AsyncCallback::with(afterResponse: 'spaMenu')
                )
            );
        });

        $this->publishes([
            __DIR__ . '/../../public' => public_path('vendor/moonshine-advanced'),
        ], ['moonshine-advanced', 'laravel-assets']);
    }
}
