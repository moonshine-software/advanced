<?php

declare(strict_types=1);

namespace MoonShine\Advanced\Components\Tabs;

use MoonShine\Contracts\UI\HasIconContract;
use MoonShine\Support\Traits\Makeable;
use MoonShine\UI\Traits\WithIcon;

/**
 * @method static static make(string $label, string $href, ?string $slug = null)
 */
final class AsyncTab implements HasIconContract
{
    use Makeable;
    use WithIcon;

    public function __construct(
        public string $label,
        public string $href,
        public ?string $slug = null,
    ) {
    }

    public function slug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }
}
