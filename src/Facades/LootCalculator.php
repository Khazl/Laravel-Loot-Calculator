<?php

namespace Khazl\LootCalculator\Facades;

use Illuminate\Support\Facades\Facade;

class LootCalculator extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'loot-calculator';
    }
}
