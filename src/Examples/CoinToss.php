<?php

namespace Khazl\LootCalculator\Examples;

use Khazl\LootCalculator\Contracts\LootboxInterface;
use Khazl\LootCalculator\LootCalculator;

class CoinToss
{
    private LootboxInterface $coin;

    public function __construct()
    {
        $this->coin = new LootCalculator([
            'Heads' => 50,
            'Tails' => 50
        ]);
    }

    public function flip(): string
    {
        return $this->coin->draw(); // Heads || Tails
    }
}
