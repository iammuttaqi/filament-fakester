<?php

namespace Iammuttaqi\FilamentFakester\Generators;

class BlockResolver
{
    public function generate(bool $html): string
    {
        return collect(range(1, 10))
            ->map(fn () => $html
                ? '<p><strong>' . fake()->realText(50) . '</strong></p><p>' . fake()->realText(500) . '</p><hr>'
                : '**' . fake()->realText(50) . "**\n\n" . fake()->realText(500) . "\n\n---")
            ->implode($html ? '' : "\n\n");
    }
}
