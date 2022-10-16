<?php

namespace Khazl\LootCalculator\Contracts;

interface LootboxInterface
{
    public function add(string $itemReference, int $weight): bool;

    public function remove(string $itemReference): bool;

    public function getContent(): array;

    public function getTotalWeight(): float;

    public function draw(): string;
}
