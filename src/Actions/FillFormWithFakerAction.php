<?php

namespace Iammuttaqi\FilamentFakester\Actions;

use Filament\Actions\Action;
use Filament\Forms\Components\Field;
use Iammuttaqi\FilamentFakester\Generators\FakerValueResolver;

class FillFormWithFakerAction
{
    public static function make(string $formProperty = 'form'): Action
    {
        return Action::make('fakester-fill-all')
            ->label('Fill with Faker')
            ->icon('heroicon-o-sparkles')
            ->color('gray')
            ->visible(fn () => config('filament-fakester.enabled'))
            ->action(function ($livewire) use ($formProperty): void {
                $schema = $livewire->{$formProperty};
                $resolver = app(FakerValueResolver::class);

                foreach ($schema->getFlatFields(withHidden: false) as $field) {
                    if ($field instanceof Field && ! $field->isDisabled()) {
                        $field->state($resolver->forComponent($field));
                    }
                }
            });
    }
}
