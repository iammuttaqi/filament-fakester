<?php

namespace Iammuttaqi\FilamentFakester\Concerns;

use Filament\Actions\Action;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Iammuttaqi\FilamentFakester\Generators\FakerValueResolver;

trait RegistersFakerHints
{
    protected function registerHintActions(): void
    {
        $resolver = app(FakerValueResolver::class);

        foreach ([TextInput::class, Textarea::class, RichEditor::class, MarkdownEditor::class] as $class) {
            $class::configureUsing(fn ($component) => $component->hintAction(
                fn () => Action::make('fakester-fill')
                    ->label(false)
                    ->icon('heroicon-o-sparkles')
                    ->visible(fn () => config('fakester.enabled') && ! $component->isDisabled())
                    ->action(fn () => $component->state($resolver->forComponent($component))),
            ));
        }
    }
}
