<?php

namespace Khazl\LootCalculator\Tests\Unit;

use Khazl\LootCalculator\DomainObjects\Item;
use Khazl\LootCalculator\DomainObjects\Lootbox;
use PHPUnit\Framework\TestCase;

class LootboxObjectTest extends TestCase
{
    public function test_adding_items_manually()
    {
        $lootbox = new Lootbox();
        $lootbox->add(new Item(50, ['name' => 'First Item']));

        $this->assertEquals(1, count($lootbox->getContent()));
        $this->assertEquals('First Item', $lootbox->getContent()[0]->getPayload()['name']);
    }

    public function test_adding_items_construct()
    {
        $lootbox = new Lootbox([
            new Item(20, ['name' => 'First Item']),
            new Item(20, ['name' => 'Second Item'])
        ]);

        $content = $lootbox->getContent();

        $this->assertEquals(2, count($lootbox->getContent()));
        $this->assertEquals('First Item', $content[0]->getPayload()['name']);
        $this->assertEquals('Second Item', $content[1]->getPayload()['name']);
    }

    public function test_removing_items()
    {
        $lootbox = new Lootbox();
        $lootbox->add(new Item(50, ['name' => 'First Item']));
        $lootbox->add(new Item(10, ['name' => 'Second Item']));

        $this->assertEquals(2, count($lootbox->getContent()));

        $lootbox->remove(new Item(10, ['name' => 'Second Item']));

        $this->assertEquals(1, count($lootbox->getContent()));
    }

    public function test_total_weight()
    {
        $lootbox = new Lootbox();
        $lootbox->add(new Item(50, ['name' => 'First Item']));
        $lootbox->add(new Item(10, ['name' => 'Second Item']));
        $lootbox->add(new Item(10, ['name' => 'Third Item']));

        $this->assertEquals(70, $lootbox->getTotalWeight());

        $lootbox->remove(new Item(50, ['name' => 'First Item']));

        $this->assertEquals(20, $lootbox->getTotalWeight());
    }

    public function test_total_weight_not_over_100()
    {
        $lootbox = new Lootbox();
        $lootbox->add(new Item(50, ['name' => 'First Item']));
        $lootbox->add(new Item(50, ['name' => 'Second Item']));
        $lootbox->add(new Item(50, ['name' => 'Third Item']));

        $content = $lootbox->getContent();
        $this->assertEquals(2, count($content));
        $this->assertEquals('First Item', $content[0]->getPayload()['name']);
        $this->assertEquals('Second Item', $content[1]->getPayload()['name']);
        $this->assertEquals(100, $lootbox->getTotalWeight());

        $lootbox->remove(new Item(50, ['name' => 'Second Item']));
        $lootbox->add(new Item(70, ['name' => 'Second Item']));

        $this->assertEquals(50, $lootbox->getTotalWeight());
        $this->assertEquals(1, count($lootbox->getContent()));
    }

    public function test_draft_50_50()
    {
        $lootbox = new Lootbox();

        $itemA = new Item(50, ['name' => 'First Item']);
        $itemB = new Item(50, ['name' => 'Second Item']);

        $lootbox->add($itemA);
        $lootbox->add($itemB);

        $draft = $lootbox->draft();

        $this->assertNotEquals("", $draft);
        $this->assertContains($draft, [$itemA, $itemB]);
    }

    public function test_draft_empty_lootbox()
    {
        $lootbox = new Lootbox();

        $draft = $lootbox->draft()->getPayload();

        $this->assertEquals(null, $draft);
    }

    public function test_draft_distribution()
    {
        $lootbox = new Lootbox();

        $lootbox->add(new Item(50, ['itemId' => 1]));
        $lootbox->add(new Item(0.1, ['itemId' => 2]));

        $loot = [
            null => 0,
            1 => 0,
            2 => 0
        ];

        // Draft 100.000 times
        for ($i = 0; $i <= 100000; $i++) {
            $win = $lootbox->draft()->getPayload();
            if ($win) {
                $loot[$win['itemId']]++;
                continue;
            }
            $loot[null]++;
        }

        // 30% fluctuation to make the test less flaky
        $this->assertGreaterThan(70, $loot[2]);
        $this->assertLessThan(130, $loot[2]);

        $this->assertGreaterThan(35000, $loot[1]);
        $this->assertLessThan(65000, $loot[1]);

        $this->assertGreaterThan(35000, $loot[null]);
        $this->assertLessThan(65000, $loot[null]);
    }
}
