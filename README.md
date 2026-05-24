# Filament Fakester

[![Latest Version on Packagist](https://img.shields.io/packagist/v/iammuttaqi/filament-fakester.svg?style=flat-square)](https://packagist.org/packages/iammuttaqi/filament-fakester)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/iammuttaqi/filament-fakester/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/iammuttaqi/filament-fakester/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/iammuttaqi/filament-fakester/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/iammuttaqi/filament-fakester/actions?query=workflow%3A"Fix+PHP+code+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/iammuttaqi/filament-fakester.svg?style=flat-square)](https://packagist.org/packages/iammuttaqi/filament-fakester)

Filling out forms in dev is tedious. Filament Fakester sticks a little sparkles button next to every `TextInput`, `Textarea`, `RichEditor`, and `MarkdownEditor` — one click and the field gets sensible fake data. It reads the field name and the input type, so `email` gets an email, `latitude` gets a coordinate, `slug` gets a slug, `phone` gets a phone number, and so on. In production it's gone — nothing renders unless you tell it to.

## Install

```bash
composer require iammuttaqi/filament-fakester --dev
```

That's it. The package self-registers through Laravel's service provider discovery, so the moment a Filament form component renders anywhere in your app — inside a panel, inside a standalone Livewire form, doesn't matter — the hint button is there. No plugin to wire into a panel, no service provider edits.

Want to publish the config?

```bash
php artisan vendor:publish --tag="filament-fakester-config"
```

```php
return [
    'enabled' => env('FAKESTER_ENABLED', ! app()->isProduction()),
];
```

Hidden in production by default. Force it on or off with `FAKESTER_ENABLED` in your env.

## What it figures out for you

The resolver looks at the field's name and HTML type and picks something that fits. A non-exhaustive taste:

| Field name / type | What you get |
| --- | --- |
| `email` (or `type="email"`) | `jane.doe@example.com` |
| `phone`, `mobile`, `tel` | `+1-555-…` |
| `latitude` / `longitude` | valid coordinates |
| `slug` | `kebab-case-words` |
| `url`, `website`, `facebook`, `google_map` | a plausible URL |
| `password` | a random secret |
| `name`, `first_name`, `last_name`, `company`, `city`, … | what you'd expect |
| anything else | a short faker sentence |

`Textarea`, `RichEditor`, `MarkdownEditor` get longer paragraphs — HTML blocks for rich editors, plain markdown for the markdown one.

## Teaching it your own fields

Got an `invoice_number` or `order_ref` that needs a specific shape? Register a matcher anywhere in your app boot (e.g. `AppServiceProvider::boot`):

```php
app(\Iammuttaqi\FilamentFakester\Support\MatcherRegistry::class)
    ->register(fn (string $name, ?string $type) =>
        $name === 'invoice_number' ? 'INV-' . fake()->numerify('######') : null
    );
```

Return a value to override the default, return `null` to fall through to the built-in resolver. Matchers run before the built-ins, so yours always win.

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
