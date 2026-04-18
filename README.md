<!--
title: MoonShine Advanced
versions: 3,4
image: https://github.com/moonshine-software/moonshine/raw/3.x/art/line-1.jpg
-->

![logo](https://github.com/moonshine-software/moonshine/raw/3.x/art/line-1.jpg)

# MoonShine Advanced

Advanced Fields and Components

## Requirements

| MoonShine Advanced | MoonShine |
|--------------------|-----------|
| 1.x                | 3.x       |
| 2.x                | 4.x       |

<p align="center">
<a href="https://github.com/moonshine-software/advanced/actions"><img src="https://github.com/moonshine-software/advanced/workflows/tests/badge.svg" alt="Tests status"></a>
<a href="https://packagist.org/packages/moonshine/v"><img src="https://img.shields.io/packagist/dt/moonshine/advanced" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/moonshine/advanced"><img src="https://img.shields.io/packagist/v/moonshine/advanced" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/moonshine/advanced"><img src="https://img.shields.io/packagist/l/moonshine/advanced" alt="License"></a>
</p>
<p align="center">
    <a href="https://laravel.com"><img alt="Laravel 10+" src="https://img.shields.io/badge/Laravel-10+-FF2D20?style=for-the-badge&logo=laravel"></a>
    <a href="https://laravel.com"><img alt="PHP 8.1+" src="https://img.shields.io/badge/PHP-8.1+-777BB4?style=for-the-badge&logo=php"></a>
</p>

```shell
composer require moonshine/advanced
```

## Stepper

### Basic:

```php
use MoonShine\Advanced\Components\Stepper\Stepper;
use MoonShine\Advanced\Components\Stepper\Step;

Stepper::make([
    Step::make([
        Heading::make('Step 1 content')
    ], 'Step 1', 'Some description'),

    Step::make([
        FormBuilder::make()
    ], 'Step 2', 'Some description'),

    Step::make([
        // any components
    ], 'Step 3', 'Some description'),
])
```

### Async content:

```php
Stepper::make([
    Step::make(title: 'Step', description: 'Some description')->async('/html')
])
```

Also with events:

```php
Stepper::make([
    Step::make(title: 'Step', description: 'Some description')->async('/html', events: [
        AlpineJs::event(JsEvent::FRAGMENT_UPDATED, 'fragment-1')
    ])
])
```

### Events when switching a step

Events when a step is changing:

```php
Step::make(title: 'Step', description: 'Some description')
    ->whenChangingEvents([
        AlpineJs::event(JsEvent::FRAGMENT_UPDATED, 'fragment-2')
    ], once: false)
```

Events when a step is completed:

```php
Step::make(title: 'Step', description: 'Some description')
    ->whenFinishEvents([
        AlpineJs::event(JsEvent::FRAGMENT_UPDATED, 'fragment-2')
    ], once: true)
```

The `once` parameter indicates once the events will be caused or with each change

### Content after completion

When all the steps are completed, this set of components will be displayed on the page

```php
Stepper::make([
    // ...
], finishComponent: [
    Heading::make('Thanks!')
]),
```

### The names of the buttons

```php
Stepper::make([
    // ...
], nextText: 'Next step', finishText: 'Finish'),
```

### Modifying the button next step

```php
Stepper::make([
    // ...
])->changeNextButton(function(ActionButton $btn, int $index) {
    return $btn->badge($index);
}),
```

### States

Active default step

```php
Stepper::make([
    // ...
])->current(2),
```

Completed by default

```php
Stepper::make([
    // ...
])->finished(),
```

### Locking

You cannot go to the next step, you can switch to the next Schag only using the event (`go_to_step_ {index}: {stPper_name}`)

```php
Step::make()->nextLock(),
```

The transition in the upper navigation is blocked:

```php
Stepper::make([
    // ...
])->lock(),
```

Once all steps are completed, the top navigation is locked:

```php
Stepper::make([
    // ...
])->lockWhenFinish(),
```

## Async tabs

```php
use MoonShine\Advanced\Components\AsyncTabs\AsyncTabs;
use MoonShine\Advanced\Components\AsyncTabs\AsyncTab;

AsyncTabs::make([
    AsyncTab::make('Tab 1', '/html'),
    AsyncTab::make('Tab 2', '/html')->icon('users'),
]),
```

### Persist active tab in URL

By default the first tab is opened on every page load. To keep the active tab
in the URL (so that reloads and shared links restore it) enable `withUrl()`:

```php
AsyncTabs::make([
    AsyncTab::make('Profile', '/html/profile'),
    AsyncTab::make('Security', '/html/security'),
])->withUrl(),
// ?tab=security
```

The query key defaults to `tab`. Each tab's slug defaults to `Str::slug($label)`
(e.g. `User Profile` → `user-profile`). Both can be overridden:

```php
AsyncTabs::make([
    AsyncTab::make('Profile', '/html/profile')->slug('me'),
    AsyncTab::make('Security', '/html/security')->slug('sec'),
])->withUrl('account'),
// ?account=sec
```

Nested `AsyncTabs` (tabs loaded as content of another async tab) are supported
— just give each group a unique query key:

```php
AsyncTabs::make([
    AsyncTab::make('Profile', '/html/profile'),
    AsyncTab::make('Security', '/html/security'),
])->withUrl('account'),
// inside the /html/security response:
AsyncTabs::make([
    AsyncTab::make('Password', '/html/password'),
    AsyncTab::make('Devices', '/html/devices'),
])->withUrl('security'),
// final URL: ?account=security&security=devices
```

By default switching a tab calls `history.replaceState` to avoid polluting
browser history. Pass `pushHistory: true` to push a new entry per switch so
that the Back/Forward buttons navigate between tabs:

```php
AsyncTabs::make([...])->withUrl(pushHistory: true),
```

## Link group

```php
use MoonShine\Advanced\Components\LinkGroup\LinkGroup;
use MoonShine\Advanced\Components\LinkGroup\LinkItem;

LinkGroup::make([
    LinkItem::make('/documentation', 'Documentation', 'Some description')->icon('arrow-right'),
    // ...
]),
```

## Radio group

```php
use MoonShine\Advanced\Fields\RadioGroup;

RadioGroup::make('Sex')->options([
    1 => 'Male',
    2 => 'Female',
])->inline(),
```

## Checkbox list

```php
use MoonShine\Advanced\Fields\CheckboxList;

CheckboxList::make('Plan')->options([
    1 => 'Basic',
    2 => 'Standard',
    3 => 'Pro',
])->inline(),
```

## Button group

```php
use MoonShine\Advanced\Fields\ButtonGroup;

ButtonGroup::make('Plan')->options([
    1 => 'Basic',
    2 => 'Standard',
    3 => 'Pro',
])->multiple(),
```

## SPA Menu

```php
use MoonShine\MenuManager\MenuItem;

protected function menu(): array
{
    return [
        MenuItem::make('Users', UserResource::class)->spa(),
    ];
}
```

## Example

```php
public function stepForm(MoonShineRequest $request): MoonShineJsonResponse
{
    $request->validate([
        'name' => ['required'],
        'email' => ['required'],
    ]);

    return MoonShineJsonResponse::make()->events([
        'go_to_step_2:dashboard'
    ]);
}

protected function components(): iterable
{
    return [
        Stepper::make([
            Step::make([
                FormBuilder::make()
                    ->name('step_1_form')
                    ->asyncMethod('stepForm')
                    ->fields([
                        Grid::make([
                            Column::make([
                                Box::make([
                                    Text::make('Name'),
                                    Email::make('Email'),

                                    RadioGroup::make('Sex')->options([
                                        1 => 'Male',
                                        2 => 'Female',
                                    ])->inline(),
                                ])
                            ])->columnSpan(6),

                            Column::make([
                                Box::make([
                                    CheckboxList::make('Job title')->options([
                                        1 => 'Developer',
                                        2 => 'Team lead',
                                    ]),

                                    ButtonGroup::make('Plan')->options([
                                        1 => 'Free',
                                        2 => 'Basic',
                                        3 => 'Pro',
                                    ]),
                                ])
                            ])->columnSpan(6)
                        ])
                    ])
                    ->hideSubmit()
            ], 'Step 1', 'Tell us about yourself')->nextLock()->whenChangingEvents([
                AlpineJs::event(JsEvent::FORM_SUBMIT, 'step_1_form')
            ]),
            Step::make([
                AsyncTabs::make([
                    AsyncTab::make('How to use the project', '/html'),
                    AsyncTab::make('User agreement', '/html'),
                ]),
            ], 'Step 2', 'Rules')->icon('users'),

            Step::make([], 'Step 3', 'Finishing')->async('/html', events: [
                AlpineJs::event(JsEvent::FRAGMENT_UPDATED, 'time')
            ])->whenFinishEvents([
                AlpineJs::event(JsEvent::FRAGMENT_UPDATED, 'time')
            ]),
        ], [
            Heading::make('Thanks!'),
            LinkGroup::make([
                LinkItem::make('#', 'Link 1', 'Description 1')->icon('arrow-right'),
                LinkItem::make('#', 'Link 2'),
            ])
        ], 'Next', 'Finish')->name('dashboard')->lock(),

        Fragment::make([
            time()
        ])->name('time'),
    ];
}
```
