<?php

namespace Khazl\LootCalculator\Contracts;

interface ItemInterface
{
    public function getWeight(): float;

    public function getPayload(): mixed;
}
