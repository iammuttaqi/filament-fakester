<?php

namespace Iammuttaqi\FilamentFakester;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Iammuttaqi\FilamentFakester\Actions\BulkFakeRecordsAction;
use Iammuttaqi\FilamentFakester\Actions\FakeRowTableAction;
use Iammuttaqi\FilamentFakester\Concerns\RegistersFakerHints;

class FilamentFakesterPlugin implements Plugin
{
    use RegistersFakerHints;

    protected array $featureOverrides = [];

    public static function make(): static
    {
        return app(static::class);
    }

    public function getId(): string
    {
        return 'filament-fakester';
    }

    public function register(Panel $panel): void
    {
        if (! config('filament-fakester.enabled')) {
            return;
        }

        $features = array_merge(config('filament-fakester.features', []), $this->featureOverrides);

        if ($features['hint_action'] ?? false) {
            $this->registerHintActions();
        }
        if ($features['fake_row_action'] ?? false) {
            FakeRowTableAction::register();
        }
        if ($features['bulk_fake_action'] ?? false) {
            BulkFakeRecordsAction::register();
        }
    }

    public function boot(Panel $panel): void
    {
        //
    }

    public function withFeatures(array $features): static
    {
        $this->featureOverrides = $features;

        return $this;
    }
}
