<?php

namespace Iammuttaqi\FilamentFakester\Generators;

use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;

class FakerValueResolver
{
    public function __construct(
        protected TextInputResolver $textInput,
        protected BlockResolver $blocks,
    ) {}

    public function forComponent(mixed $component): string
    {
        return match (true) {
            $component instanceof TextInput => $this->textInput->resolve($component),
            $component instanceof Textarea => fake()->realText(500),
            $component instanceof RichEditor => $this->blocks->generate(html: true),
            $component instanceof MarkdownEditor => $this->blocks->generate(html: false),
            default => 'faker data',
        };
    }
}
