# Filament Fakester

[![Latest Version on Packagist](https://img.shields.io/packagist/v/iammuttaqi/filament-fakester.svg?style=flat-square)](https://packagist.org/packages/iammuttaqi/filament-fakester)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/iammuttaqi/filament-fakester/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/iammuttaqi/filament-fakester/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/iammuttaqi/filament-fakester/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/iammuttaqi/filament-fakester/actions?query=workflow%3A"Fix+PHP+code+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/iammuttaqi/filament-fakester.svg?style=flat-square)](https://packagist.org/packages/iammuttaqi/filament-fakester)

Faker-powered devtools for Filament. Drop-in plugin that adds:

- A sparkles **hint action** on every `TextInput`, `Textarea`, `RichEditor`, `MarkdownEditor` — click to fill that one field with context-aware fake data (detects `email`, `phone`, `latitude`, `facebook`, `google_map`, `slug`, etc. by field name and HTML type).
- A **form header action** to fill every visible field at once.
- A per-row **"Fake row"** table action that regenerates a record from its `Factory::definition()`.
- A **bulk header action** to create N fake records via factory.
- An opt-in **`SeedResourceAction`** to seed list pages from a button.

All actions are hidden in production (or whenever `FAKESTER_ENABLED=false`), so it stays purely a local/staging devtool.

## Installation

Install via Composer (dev-only recommended):

```bash
composer require iammuttaqi/filament-fakester --dev
```

Publish the config:

```bash
php artisan vendor:publish --tag="filament-fakester-config"
```

This is the contents of the published config file:

```php
return [
    'enabled' => env('FAKESTER_ENABLED', ! app()->isProduction()),

    'features' => [
        'hint_action'      => true,
        'fake_row_action'  => true,
        'bulk_fake_action' => true,
    ],

    'default_count' => 25,
];
```

## Usage

### Register on a panel

```php
use Iammuttaqi\FilamentFakester\FilamentFakesterPlugin;

public function panel(Panel $panel): Panel
{
    return $panel
        ->plugin(FilamentFakesterPlugin::make());
}
```

### Per-panel features

```php
->plugin(
    FilamentFakesterPlugin::make()->withFeatures([
        'bulk_fake_action' => false,
        'fake_row_action'  => false,
    ])
)
```

### Custom matcher

Override built-ins or extend with project-specific field names:

```php
app(\Iammuttaqi\FilamentFakester\Support\MatcherRegistry::class)
    ->register(fn (string $name, ?string $type) =>
        $name === 'invoice_number' ? 'INV-' . fake()->numerify('######') : null
    );
```

### Page-level helpers

Filament v5 has no global form-level header action hook, so two helpers are opt-in per page — drop them into the page's `getHeaderActions()`.

**Fill the whole form** (Create / Edit pages):

```php
use Iammuttaqi\FilamentFakester\Actions\FillFormWithFakerAction;

protected function getHeaderActions(): array
{
    return [
        FillFormWithFakerAction::make(),
    ];
}
```

**Seed N records via factory** (List pages):

```php
use Iammuttaqi\FilamentFakester\Actions\SeedResourceAction;

protected function getHeaderActions(): array
{
    return [
        SeedResourceAction::make(\App\Models\Post::class, 100),
    ];
}
```

### Features

- **Hint action** (auto-wired): Sparkles icon on every `TextInput`, `Textarea`, `RichEditor`, `MarkdownEditor` → click to fill that field with context-aware fake data.
- **Fake row** (auto-wired): Per-row table action regenerates that record using its `Factory::definition()`.
- **Bulk fake rows** (auto-wired): Table header action creates N records via factory.
- **Fill whole form** (opt-in via `FillFormWithFakerAction::make()`): page header button that populates every visible field.
- **Resource seed** (opt-in via `SeedResourceAction::make()`): seed N rows from a `List*` page.

All actions hidden when `FAKESTER_ENABLED=false` or in production by default.

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](.github/SECURITY.md) on how to report security vulnerabilities.

## Credits

- [Muttaqi](https://github.com/iammuttaqi)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
