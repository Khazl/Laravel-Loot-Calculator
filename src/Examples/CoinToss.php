<?php

namespace Khazl\LootCalculator\Examples;

use Khazl\LootCalculator\Contracts\CoinTossInterface;
use Khazl\LootCalculator\Contracts\LootboxInterface;
use Khazl\LootCalculator\DomainObjects\Item;
use Khazl\LootCalculator\DomainObjects\Lootbox;

class CoinToss implements CoinTossInterface
{
    private LootboxInterface $coin;

    public function __construct()
    {
        $this->coin = new Lootbox([
            new Item(50, 'Heads'),
            new Item(50, 'Tails')
        ]);
    }

    public function flip(): string
    {
        return $this->coin->draft()->getPayload();
    }
}
