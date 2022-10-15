<?php

namespace Khazl\LootCalculator\Contracts;

interface LootboxInterface
{
    public function add(ItemInterface $item): bool;

    public function remove(ItemInterface $item): void;

    public function getContent(): array;

    public function getTotalWeight(): float;

    public function draft(): ItemInterface;
}
