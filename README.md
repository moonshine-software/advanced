# MoonShine Advanced

Advanced Fields and Components

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

Events when a step is completed:

```php
Step::make(title: 'Step', description: 'Some description')
    ->whenFinishEvents([
        AlpineJs::event(JsEvent::FRAGMENT_UPDATED, 'fragment-2')
    ])
```

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
            ], 'Step 1', 'Tell us about yourself')->nextLock()->whenFinishEvents([
                AlpineJs::event(JsEvent::FORM_SUBMIT, 'step_1_form')
            ]),
            Step::make([
                AsyncTabs::make([
                    AsyncTab::make('How to use the project', '/html'),
                    AsyncTab::make('User agreement', '/html'),
                ]),
            ], 'Step 2', 'Rules')->icon('users'),

            Step::make([], 'Step 3', 'Finishing')->async('/html', events: [
                AlpineJs::event(JsEvent::FRAGMENT_UPDATED, '_content1')
            ])->whenFinishEvents([
                AlpineJs::event(JsEvent::FRAGMENT_UPDATED, '_content2')
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
        ])->name('_content1'),

        Fragment::make([
            time()
        ])->name('_content2'),
    ];
}
```
