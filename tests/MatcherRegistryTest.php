<?php

use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Textarea;
use Iammuttaqi\FilamentFakester\Generators\FakerValueResolver;
use Iammuttaqi\FilamentFakester\Support\MatcherRegistry;

beforeEach(function () {
    $this->registry = app(MatcherRegistry::class);
});

it('applies custom matcher to Textarea', function () {
    $this->registry->register(fn (string $name) => $name === 'bio' ? 'custom bio text' : null);

    $component = Textarea::make('bio');
    $resolver = app(FakerValueResolver::class);

    expect($resolver->forComponent($component))->toBe('custom bio text');
});

it('applies custom matcher to RichEditor', function () {
    $this->registry->register(fn (string $name) => $name === 'content' ? '<p>custom content</p>' : null);

    $component = RichEditor::make('content');
    $resolver = app(FakerValueResolver::class);

    expect($resolver->forComponent($component))->toBe('<p>custom content</p>');
});

it('applies custom matcher to MarkdownEditor', function () {
    $this->registry->register(fn (string $name) => $name === 'notes' ? '# custom notes' : null);

    $component = MarkdownEditor::make('notes');
    $resolver = app(FakerValueResolver::class);

    expect($resolver->forComponent($component))->toBe('# custom notes');
});

it('falls back to default when no custom matcher matches', function () {
    $component = Textarea::make('description');
    $resolver = app(FakerValueResolver::class);

    expect($resolver->forComponent($component))->toBeString()->not->toBeEmpty();
});
