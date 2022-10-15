<?php

namespace Khazl\LootCalculator\DomainObjects;

use Khazl\LootCalculator\Contracts\ItemInterface;

class Item implements ItemInterface
{
    private float $weight;
    private mixed $payload;

    public function __construct(float $weight, mixed $payload)
    {
        $this->weight = $weight;
        $this->payload = $payload;
    }

    public function getWeight(): float
    {
        return $this->weight;
    }

    public function getPayload(): mixed
    {
        return $this->payload;
    }
}
