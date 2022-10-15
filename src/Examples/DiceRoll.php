<?php

namespace Khazl\LootCalculator\Examples;

use Khazl\LootCalculator\Contracts\DiceRollInterface;
use Khazl\LootCalculator\Contracts\LootboxInterface;
use Khazl\LootCalculator\DomainObjects\Item;
use Khazl\LootCalculator\DomainObjects\Lootbox;

class DiceRoll implements DiceRollInterface
{
    private LootboxInterface $dice;

    public function __construct()
    {
        $this->dice = new Lootbox([
            new Item(16.6, 1),
            new Item(16.6, 2),
            new Item(16.6, 3),
            new Item(16.6, 4),
            new Item(16.6, 5),
            new Item(16.6, 6)
        ]);
    }

    public function roll(): int
    {
        $result = null;
        while (!$result) { // roll again if blank - 0.4% chance
            $result = $this->dice->draft()->getPayload();
        }
        return $result;
    }
}
