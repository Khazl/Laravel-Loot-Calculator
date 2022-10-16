<?php

namespace Khazl\LootCalculator\Examples;

use Khazl\LootCalculator\Contracts\LootboxInterface;
use Khazl\LootCalculator\DomainObjects\Lootbox;

class WolfLoot
{
    private LootboxInterface $lootPool;

    public function __construct()
    {
        $this->lootPool = new Lootbox([
            'CharacterItem:462' => 200, // Leather
            'CharacterItem:9875' => 300, // Claw
            'AccountItem:64' => 1, // Very rare pet
        ]);
    }

    public function loot(): array
    {
        $loot = [];

        // draft three times
        for ($i = 0; $i < 3; $i++) {
            $loot[] = $this->lootPool->draw();
        }
        return $loot; // ['CharacterItem:462', 'CharacterItem:9875', 'AccountItem:64']
    }
}
