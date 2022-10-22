<?php

namespace Khazl\LootCalculator;

use Khazl\LootCalculator\Contracts\LootboxInterface;

class LootCalculator implements LootboxInterface
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

        if ($weight <= 0) {
            throw new \ValueError('Can not add items with weight less than or equal to 0 to the lootbox!');
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

    public function getContentWithPercentages(): array
    {
        $result = [];
        foreach ($this->content as $itemReference => $weight)
        {
            $result[$itemReference] = ($weight / $this->weight) * 100;
        }
        return $result;
    }

    public function draw(): string
    {
        if ($this->weight <= 0) {
            throw new \Exception('Can not draw anything from an empty lootbox!');
        }

        $roll = $this->roll();
        $pointer = 0;
        foreach ($this->content as $itemReference => $weight) {
            $pointer += $weight;
            if ($roll <= $pointer) {
                return $itemReference;
            }
        }
        throw new \RuntimeException('Nothing was drawn. In fact, this can not happen.');
    }

    private function roll(): int
    {
        return mt_rand(1, $this->weight);
    }
}
