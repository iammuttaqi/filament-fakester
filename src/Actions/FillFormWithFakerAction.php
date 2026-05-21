<?php

namespace Iammuttaqi\FilamentFakester\Actions;

use Filament\Actions\Action;
use Filament\Forms\Components\Field;
use Filament\Schemas\Schema;
use Iammuttaqi\FilamentFakester\Generators\FakerValueResolver;

class FillFormWithFakerAction
{
    public static function register(): void
    {
        Schema::configureUsing(function (Schema $schema): void {
            $schema->headerActions([
                Action::make('fakester-fill-all')
                    ->label('Fill with Faker')
                    ->icon('heroicon-o-sparkles')
                    ->color('gray')
                    ->visible(fn () => config('filament-fakester.enabled'))
                    ->action(function () use ($schema): void {
                        $resolver = app(FakerValueResolver::class);
                        foreach ($schema->getFlatFields(withHidden: false) as $field) {
                            if ($field instanceof Field && ! $field->isDisabled()) {
                                $field->state($resolver->forComponent($field));
                            }
                        }
                    }),
            ]);
        });
    }
}
