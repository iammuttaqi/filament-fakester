<?php

namespace Iammuttaqi\FilamentFakester\Actions;

use Filament\Actions\Action;
use Filament\Notifications\Notification;

class SeedResourceAction
{
    public static function make(string $model, int $count = 50): Action
    {
        return Action::make('fakester-seed')
            ->label("Seed {$count} records")
            ->icon('heroicon-o-sparkles')
            ->color('gray')
            ->visible(fn () => config('filament-fakester.enabled'))
            ->requiresConfirmation()
            ->action(function () use ($model, $count): void {
                $model::factory()->count($count)->create();
                Notification::make()->title("Seeded {$count} {$model} records")->success()->send();
            });
    }
}
