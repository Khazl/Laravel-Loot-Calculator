<?php

namespace Khazl\LootCalculator\Examples;

use Khazl\LootCalculator\Contracts\WolfLootInterface;
use Khazl\LootCalculator\Contracts\LootboxInterface;
use Khazl\LootCalculator\DomainObjects\Item;
use Khazl\LootCalculator\DomainObjects\Lootbox;

class WolfLoot implements WolfLootInterface
{
    private LootboxInterface $lootPool;

    public function __construct()
    {
        // 39.5% blank
        $this->lootPool = new Lootbox([
            new Item(25, ['id' => 123, 'name' => 'Leather']),
            new Item(35, ['id' => 456, 'name' => 'Claw']),
            new Item(0.5, ['id' => 999, 'name' => 'Very Raw Pet']),
        ]);
    }

    public function loot(): array
    {
        $loot = [];

        // draft three times
        for ($i = 0; $i < 3; $i++) {
            $draft = $this->lootPool->draft()->getPayload();
            if ($draft) { // skip blank drafts
                $loot[] = $draft;
            }
        }
        return $loot;
    }
}
