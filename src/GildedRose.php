<?php

namespace Kata;

class GildedRose
{
    const NORMAL            = 'normal';
    const AGED_BRIE         = 'Aged Brie';
    const BACKSTAGE_PASSES  = 'Backstage passes to a TAFKAL80ETC concert';
    const SULFURAS          = 'Sulfuras, Hand of Ragnaros';
    const CONJURED          = 'Conjured Mana Cake';

    public static function of($name, $quality, $sellIn) {
        switch ($name) {

            case static::AGED_BRIE:
                return new AgedBrie($quality, $sellIn);
                break;
            case static::SULFURAS:
                return new Sulfuras($quality, $sellIn);
                break;
            case static::BACKSTAGE_PASSES:
                return new BackstagePasses($quality, $sellIn);
                break;
            case static::CONJURED:
                return new Conjured($quality, $sellIn);
                break;

            default:
                return new Normal($quality, $sellIn);
                break;
        }
    }
}