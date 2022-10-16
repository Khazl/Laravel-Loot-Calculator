<?php

namespace Khazl\LootCalculator\DomainObjects;

use Khazl\LootCalculator\Contracts\LootboxInterface;

// TODO: Not an DomainObject anymore. Move to another place!
class Lootbox implements LootboxInterface
{
    private array $content = [];
    private float $weight = 0;

    public function __construct(array $items = [])
    {
        foreach ($items as $itemReference => $weight) {
            $this->add($itemReference, $weight);
        }
    }

    public function add(string $itemReference, int $weight): bool
    {
        if ($this->itemAlreadyExists($itemReference)) {
            return false;
        }

        $this->content[$itemReference] = $weight;
        $this->weight += $weight;

        return true;
    }

    public function remove(string $itemReference): bool
    {
        if ($this->itemAlreadyExists($itemReference)) {
            $weight = $this->content[$itemReference];
            unset($this->content[$itemReference]);
            $this->weight -= $weight;
            return true;
        }

        return false;
    }

    public function getContent(): array
    {
        return $this->content;
    }

    public function getTotalWeight(): float
    {
        return $this->weight;
    }

    private function itemAlreadyExists(string $itemReference): bool
    {
        return isset($this->content[$itemReference]);
    }

    public function draw(): string
    {
        $roll = $this->roll();
        $pointer = 0;
        foreach ($this->content as $itemReference => $weight) {
            $pointer += $weight;
            if ($roll <= $pointer) {
                return $itemReference;
            }
        }

        throw new \Exception('Can not draw anything from an empty lootbox!');
    }

    private function roll(): int
    {
        return mt_rand(0, $this->weight);
    }
}
