<?php

namespace Kata;

class GildedRose
{
    const NORMAL            = 'normal';
    const AGED_BRIE         = 'Aged Brie';
    const BACKSTAGE_PASSES  = 'Backstage passes to a TAFKAL80ETC concert';
    const SULFURAS          = 'Sulfuras, Hand of Ragnaros';

    const MAX_QUALITY = 50;
    const MIN_QUALITY = 0;

    private $name;

    public $quality;

    public $sellIn;

    public function __construct($name, $quality, $sellIn)
    {
        $this->name = $name;
        $this->quality = $quality;
        $this->sellIn = $sellIn;
    }

    public static function of($name, $quality, $sellIn) {
        return new static($name, $quality, $sellIn);
    }

    public function tick()
    {
        if ($this->name === static::SULFURAS) {
            return;
        }

        if ($this->name != static::AGED_BRIE and $this->name != static::BACKSTAGE_PASSES) {
            $this->decreaseQuality();
        } else {
            if ($this->quality < 50) {
                $this->quality = $this->quality + 1;

                if ($this->name == static::BACKSTAGE_PASSES) {
                    $this->increaseQualityOfBackstagePasses();
                }
            }
        }

        $this->decreaseSellIn();

        if ($this->sellIn >= 0) {
            return;
        }

        if ($this->name === static::AGED_BRIE) {
            $this->increaseQuality();
        } else {
            if ($this->name != static::BACKSTAGE_PASSES) {
                $this->decreaseQuality();
            } else {
                $this->quality = 0;
            }
        }
    }

    private function decreaseSellIn()
    {
        $this->sellIn = $this->sellIn - 1;
    }

    private function decreaseQuality()
    {
        $this->quality = max(static::MIN_QUALITY, $this->quality - 1);
    }

    private function increaseQuality()
    {
        $this->quality = min(static::MAX_QUALITY, $this->quality + 1);
    }

    private function increaseQualityOfBackstagePasses()
    {
        if ($this->sellIn < 11) {
            $this->increaseQuality();
        }
        if ($this->sellIn < 6) {
            $this->increaseQuality();
        }
    }
}