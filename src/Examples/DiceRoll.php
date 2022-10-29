<?php

namespace Khazl\LootCalculator\Examples;

use Khazl\LootCalculator\Contracts\LootCalculatorInterface;
use Khazl\LootCalculator\LootCalculator;

class DiceRoll
{
    private LootCalculatorInterface $dice;

    public function __construct()
    {
        $this->dice = new LootCalculator([
            1 => 1,
            2 => 1,
            3 => 1,
            4 => 1,
            5 => 1,
            6 => 1
        ]);
    }

    public function roll(): int
    {
        return $this->dice->draw(); // 1 || 2 || 3 || 4 || 5 || 6
    }
}
