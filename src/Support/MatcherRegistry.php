<?php

namespace Iammuttaqi\FilamentFakester\Support;

class MatcherRegistry
{
    /** @var array<callable(string, ?string): mixed> */
    protected array $matchers = [];

    public function register(callable $matcher): static
    {
        $this->matchers[] = $matcher;

        return $this;
    }

    public function match(string $name, ?string $type): mixed
    {
        foreach ($this->matchers as $matcher) {
            $value = $matcher($name, $type);
            if ($value !== null) {
                return $value;
            }
        }

        return null;
    }
}
