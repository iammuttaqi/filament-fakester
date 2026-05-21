<?php

namespace Iammuttaqi\FilamentFakester\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Iammuttaqi\FilamentFakester\FilamentFakester
 */
class FilamentFakester extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Iammuttaqi\FilamentFakester\FilamentFakester::class;
    }
}
