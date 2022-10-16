<?php

namespace Khazl\LootCalculator\Examples;

use Khazl\LootCalculator\Contracts\LootboxInterface;
use Khazl\LootCalculator\DomainObjects\Lootbox;

class CoinToss
{
    private LootboxInterface $coin;

    public function __construct()
    {
        $this->coin = new Lootbox([
            'Heads' => 50,
            'Tails' => 50
        ]);
    }

    public function flip(): string
    {
        return $this->coin->draw();
    }
}
