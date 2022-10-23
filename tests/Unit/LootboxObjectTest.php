<?php

namespace Khazl\LootCalculator\Tests\Unit;

use Khazl\LootCalculator\LootCalculator;
use PHPUnit\Framework\TestCase;

class LootboxObjectTest extends TestCase
{
    public function test_adding_items_manually()
    {
        $lootbox = new LootCalculator();
        $lootbox->add('First Item', 50);

        $this->assertEquals(1, count($lootbox->getContent()));
        $this->assertEquals(50, $lootbox->getContent()['First Item']);
    }

    public function test_adding_items_already_exists()
    {
        $lootbox = new LootCalculator();
        $lootbox->add('First Item', 50);

        $this->assertEquals(false, $lootbox->add('First Item', 50));
    }

    public function test_adding_items_construct()
    {
        $lootbox = new LootCalculator([
            'First Item' => 20,
            'Second Item' => 30
        ]);

        $content = $lootbox->getContent();

        $this->assertEquals(2, count($lootbox->getContent()));
        $this->assertEquals(20, $content['First Item']);
        $this->assertEquals(30, $content['Second Item']);
    }

    public function test_removing_items()
    {
        $lootbox = new LootCalculator();
        $lootbox->add('First Item', 50);
        $lootbox->add('Second Item', 10);

        $this->assertEquals(2, count($lootbox->getContent()));

        $lootbox->remove('Second Item');

        $this->assertEquals(1, count($lootbox->getContent()));
    }

    public function test_removing_item_not_exists()
    {
        $lootbox = new LootCalculator();
        $lootbox->add('First Item', 50);

        $this->assertEquals(false, $lootbox->remove('Second Item'));
    }

    public function test_total_weight()
    {
        $lootbox = new LootCalculator();
        $lootbox->add('First Item', 50);
        $lootbox->add('Second Item',10);
        $lootbox->add('Third Item', 10);

        $this->assertEquals(70, $lootbox->getTotalWeight());

        $lootbox->remove('First Item');

        $this->assertEquals(20, $lootbox->getTotalWeight());
    }

    public function test_draw_50_50()
    {
        $lootbox = new LootCalculator();

        $lootbox->add('First Item', 50);
        $lootbox->add('Second Item', 50);

        $this->assertContains($lootbox->draw(), ['First Item', 'Second Item']);
    }

    public function test_draw_empty_lootbox()
    {
        $lootbox = new LootCalculator();

        $this->expectException(\Exception::class);

        $lootbox->draw();
    }

    public function test_draw_distribution()
    {
        $lootbox = new LootCalculator();

        $lootbox->add('Item:45', 49);
        $lootbox->add('Item:687', 1);

        $loot = [
            'Item:45' => 0,
            'Item:687' => 0
        ];

        // draw 100.000 times
        for ($i = 0; $i <= 100000; $i++) {
            $loot[$lootbox->draw()]++;
        }

        // 30% fluctuation to make the test less flaky
        $this->assertGreaterThan(68600, $loot['Item:45']);
        $this->assertLessThan(98600, $loot['Item:45']);

        $this->assertGreaterThan(1400, $loot['Item:687']);
        $this->assertLessThan(2600, $loot['Item:687']);
    }

    public function test_add_invalid_item_weight_zero()
    {
        $lootbox = new LootCalculator();

        $this->expectException(\ValueError::class);

        $lootbox->add('First Item', 0);
    }

    public function test_add_invalid_item_weight_negative()
    {
        $lootbox = new LootCalculator();

        $this->expectException(\ValueError::class);

        $lootbox->add('First Item', -5);
    }

    public function test_content_with_percentages()
    {
        $lootbox = new LootCalculator();

        $lootbox->add('First Item', 999);
        $lootbox->add('Second Item', 1);

        $result = $lootbox->getContentWithPercentages();

        $this->assertEquals(99.9, $result['First Item']);
        $this->assertEquals(0.1, $result['Second Item']);

        $lootbox->remove('First Item');

        $this->assertEquals(100, $lootbox->getContentWithPercentages()['Second Item']);
    }
}
