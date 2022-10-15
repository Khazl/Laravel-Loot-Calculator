<?php

namespace Khazl\LootCalculator\DomainObjects;

use Khazl\LootCalculator\Contracts\ItemInterface;
use Khazl\LootCalculator\Contracts\LootboxInterface;

class Lootbox implements LootboxInterface
{
    private array $content = [];
    private float $weight = 0;
    private ItemInterface $blank;

    public function __construct(array $items = [])
    {
        $this->blank = new Item(0, null);
        foreach ($items as $item) {
            $this->add($item);
        }
    }

    public function add(ItemInterface $item): bool
    {
        if (
            $this->getTotalWeight() + $item->getWeight() > 100 ||
            $this->itemAlreadyExists($item))
        {
            return false;
        }

        $this->content[] = $item;
        $this->weight += $item->getWeight();
        return true;
    }

    public function remove(ItemInterface $item): void
    {
        foreach ($this->content as $index => $alreadyExistingItem) {
            if ($item == $alreadyExistingItem) {
                unset($this->content[$index]);
                $this->weight -= $item->getWeight();
            }
        }
    }

    public function getContent(): array
    {
        return $this->content;
    }

    public function getTotalWeight(): float
    {
        return $this->weight;
    }

    private function itemAlreadyExists(ItemInterface $item): bool
    {
        foreach ($this->content as $alreadyExistingItem) {
            if ($item == $alreadyExistingItem) {
                return true;
            }
        }
        return false;
    }

    public function draft(): ItemInterface
    {
        $roll = $this->roll();
        $pointer = 0;
        foreach ($this->getContent() as $item) {
            $pointer += $item->getWeight();
            if ($roll <= $pointer) {
                return $item;
            }
        }
        return $this->blank;
    }

    private function roll(int $min = 0, int $max = 100): float
    {
        return mt_rand($min, $max * 10) / 10 ;
    }
}
