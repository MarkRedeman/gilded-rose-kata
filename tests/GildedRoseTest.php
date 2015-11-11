<?php

use Kata\GildedRose;

class GildedRoseTest extends PHPUnit_Framework_TestCase
{

    /** @test */
    public function it_returns_an_item()
    {
        $item = GildedRose::of(GildedRose::NORMAL, 10, 5);
        $this->assertInstanceOf(Kata\Item::class, $item);
    }

    /** @test */
    public function it_returns_a_aged_brie_item()
    {
        $item = GildedRose::of(GildedRose::AGED_BRIE, 10, 5);
        $this->assertInstanceOf(Kata\AgedBrie::class, $item);
    }

    /** @test */
    public function it_returns_a_sulfuras_item()
    {
        $item = GildedRose::of(GildedRose::SULFURAS, 10, 5);
        $this->assertInstanceOf(Kata\Sulfuras::class, $item);
    }

    /** @test */
    public function it_returns_a_backstage_passes_item()
    {
        $item = GildedRose::of(GildedRose::BACKSTAGE_PASSES, 10, 5);
        $this->assertInstanceOf(Kata\BackstagePasses::class, $item);
    }

    /** @test */
    public function it_updates_normal_items_before_sell_datei() {
        $item = GildedRose::of(GildedRose::NORMAL, 10, 5); // quality, sell in X days

        $item->tick();

        $this->assertSame($item->quality, 9);
        $this->assertSame($item->sellIn, 4);
    }

    /** @test */
    public function it_updates_normal_items_on_the_sell_date() {
        $item = GildedRose::of(GildedRose::NORMAL, 10, 0);

        $item->tick();

        $this->assertSame($item->quality, 8);
        $this->assertSame($item->sellIn, -1);
    }

    /** @test */
    public function it_updates_normal_items_after_the_sell_date() {
        $item = GildedRose::of(GildedRose::NORMAL, 10, -5);

        $item->tick();

        $this->assertSame($item->quality, 8);
        $this->assertSame($item->sellIn, -6);
    }

    /** @test */
    public function it_updates_normal_items_with_a_quality_of_0() {
        $item = GildedRose::of(GildedRose::NORMAL, 0, 5);

        $item->tick();

        $this->assertSame($item->quality, 0);
        $this->assertSame($item->sellIn, 4);
    }

    /** @test */
    public function updates_Brie_items_before_the_sell_date() {
        $item = GildedRose::of(GildedRose::AGED_BRIE, 10, 5);

        $item->tick();

        $this->assertSame($item->quality, 11);
        $this->assertSame($item->sellIn, 4);
    }

    /** @test */
    public function updates_Brie_items_before_the_sell_date_with_maximum_quality() {
        $item = GildedRose::of(GildedRose::AGED_BRIE, 50, 5);

        $item->tick();

        $this->assertSame($item->quality, 50);
        $this->assertSame($item->sellIn, 4);
    }

    /** @test */
    public function updates_Brie_items_on_the_sell_date() {
        $item = GildedRose::of(GildedRose::AGED_BRIE, 10, 0);

        $item->tick();

        $this->assertSame($item->quality, 12);
        $this->assertSame($item->sellIn, -1);
    }

    /** @test */
    public function updates_Brie_items_on_the_sell_date_near_maximum_quality() {
        $item = GildedRose::of(GildedRose::AGED_BRIE, 49, 0);

        $item->tick();

        $this->assertSame($item->quality, 50);
        $this->assertSame($item->sellIn, -1);
    }

    /** @test */
    public function updates_Brie_items_on_the_sell_date_with_maximum_quality() {
        $item = GildedRose::of(GildedRose::AGED_BRIE, 50, 0);

        $item->tick();

        $this->assertSame($item->quality, 50);
        $this->assertSame($item->sellIn, -1);
    }

    /** @test */
    public function updates_Brie_items_after_the_sell_date() {
        $item = GildedRose::of(GildedRose::AGED_BRIE, 10, -10);

        $item->tick();

        $this->assertSame($item->quality, 12);
        $this->assertSame($item->sellIn, -11);
    }

     /** @test */
     public function updates_Briem_items_after_the_sell_date_with_maximum_quality() {
        $item = GildedRose::of(GildedRose::AGED_BRIE, 50, -10);

        $item->tick();

        $this->assertSame($item->quality, 50);
        $this->assertSame($item->sellIn, -11);
    }


    /** @test */
    public function updates_Sulfuras_items_before_the_sell_date() {
        $item = GildedRose::of(GildedRose::SULFURAS, 10, 5);

        $item->tick();

        $this->assertSame($item->quality, 10);
        $this->assertSame($item->sellIn, 5);
    }

    /** @test */
    public function updates_Sulfuras_items_on_the_sell_date() {
        $item = GildedRose::of(GildedRose::SULFURAS, 10, 5);

        $item->tick();

        $this->assertSame($item->quality, 10);
        $this->assertSame($item->sellIn, 5);
    }

    /** @test */
    public function updates_Sulfuras_items_after_the_sell_date() {
        $item = GildedRose::of(GildedRose::SULFURAS, 10, -1);

        $item->tick();

        $this->assertSame($item->quality, 10);
        $this->assertSame($item->sellIn, -1);
    }

     /*
        "Backstage passes", like aged brie, increases in Quality as it's SellIn
        value approaches; Quality increases by 2 when there are 10 days or
        less and by 3 when there are 5 days or less but Quality drops to
        0 after the concert
     */
    /** @test */
    public function updates_Backstage_pass_items_long_before_the_sell_date() {
        $item = GildedRose::of(GildedRose::BACKSTAGE_PASSES, 10, 11);

        $item->tick();

        $this->assertSame($item->quality, 11);
        $this->assertSame($item->sellIn, 10);
    }

    /** @test */
    public function updates_Backstage_pass_items_close_to_the_sell_date() {
        $item = GildedRose::of(GildedRose::BACKSTAGE_PASSES, 10, 10);

        $item->tick();

        $this->assertSame($item->quality, 12);
        $this->assertSame($item->sellIn, 9);
    }

    /** @test */
    public function updates_Backstage_pass_items_close_to_the_sell_data_at_max_quality() {
        $item = GildedRose::of(GildedRose::BACKSTAGE_PASSES, 50, 10);

        $item->tick();

        $this->assertSame($item->quality, 50);
        $this->assertSame($item->sellIn, 9);
    }

    /** @test */
    public function updates_Backstage_pass_items_very_close_to_the_sell_date() {
        $item = GildedRose::of(GildedRose::BACKSTAGE_PASSES, 10, 5);

        $item->tick();

        $this->assertSame($item->quality, 13); // goes up by 3
        $this->assertSame($item->sellIn, 4);
    }

    /** @test */
    public function updates_Backstage_pass_items_very_close_to_the_sell_date_at_max_quality() {
        $item = GildedRose::of(GildedRose::BACKSTAGE_PASSES, 50, 5);

        $item->tick();

        $this->assertSame($item->quality, 50);
        $this->assertSame($item->sellIn, 4);
    }

    /** @test */
    public function updates_Backstage_pass_items_with_one_day_left_to_sell() {
        $item = GildedRose::of(GildedRose::BACKSTAGE_PASSES, 10, 1);

        $item->tick();

        $this->assertSame($item->quality, 13);
        $this->assertSame($item->sellIn, 0);
    }

    /** @test */
    public function updates_Backstage_pass_items_with_one_day_left_to_sell_at_max_quality() {

        $item = GildedRose::of(GildedRose::BACKSTAGE_PASSES, 50, 1);

        $item->tick();

        $this->assertSame($item->quality, 50);
        $this->assertSame($item->sellIn, 0);
    }

    /** @test */
    public function updates_Backstage_pass_items_on_the_sell_date() {

        $item = GildedRose::of(GildedRose::BACKSTAGE_PASSES, 10, 0);

        $item->tick();

        $this->assertSame($item->quality, 0);
        $this->assertSame($item->sellIn, -1);
    }

    /** @test */
    public function updates_Backstage_pass_items_after_the_sell_date() {

        $item = GildedRose::of(GildedRose::BACKSTAGE_PASSES, 10, -1);

        $item->tick();

        $this->assertSame($item->quality, 0);
        $this->assertSame($item->sellIn, -2);
    }



            // /** @test */
            // public function updates_onjured_items_before_the_sell_date() {
            //     $item = GildedRose::of('Conjured Mana Cake', 10, 10);

            //     $item->tick();

            //     $this->assertSame($item->quality, 8);
            //     $this->assertSame($item->sellIn, 9);
            // }

            // /** @test */
            // public function updates_onjured_items_at_zero_quality() {
            //     $item = GildedRose::of('Conjured Mana Cake', 0, 10);

            //     $item->tick();

            //     $this->assertSame($item->quality, 0);
            //     $this->assertSame($item->sellIn, 9);
            // }

            // /** @test */
            // public function updates_onjured_items_on_the_sell_date() {
            //     $item = GildedRose::of('Conjured Mana Cake', 10, 0);

            //     $item->tick();

            //     $this->assertSame($item->quality, 6);
            //     $this->assertSame($item->sellIn, -1);
            // }

            // * @test
            // public function updates_onjured_items_on_the_sell_date_at_0_quality() {
            //     $item = GildedRose::of('Conjured Mana Cake', 0, 0);

            //     $item->tick();

            //     $this->assertSame($item->quality, 0);
            //     $this->assertSame($item->sellIn, -1);
            // }

            // /** @test */
            // public function updates_onjured_items_after_the_sell_date() {
            //     $item = GildedRose::of('Conjured Mana Cake', 10, -10);

            //     $item->tick();

            //     $this->assertSame($item->quality, 6);
            //     $this->assertSame($item->sellIn, -11);
            // }

            // /** @test */
            // public function updates_onjured_items_after_the_sell_date_at_zero_quality() {
            //     $item = GildedRose::of('Conjured Mana Cake', 0, -10);

            //     $item->tick();

            //     $this->assertSame($item->quality, 0);
            //     $this->assertSame($item->sellIn, -11);
            // }



}
