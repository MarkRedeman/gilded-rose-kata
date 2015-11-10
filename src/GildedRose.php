<?php

namespace Kata;


class GildedRose
{
    const NORMAL            = 'normal';
    const AGED_BRIE         = 'Aged Brie';
    const BACKSTAGE_PASSES  = 'Backstage passes to a TAFKAL80ETC concert';
    const SULFURAS          = 'Sulfuras, Hand of Ragnaros';

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
        if ($this->name != static::AGED_BRIE and $this->name != static::BACKSTAGE_PASSES) {
            if ($this->quality > 0) {
                if ($this->name != static::SULFURAS) {
                    $this->quality = $this->quality - 1;
                }
            }
        } else {
            if ($this->quality < 50) {
                $this->quality = $this->quality + 1;

                if ($this->name == static::BACKSTAGE_PASSES) {
                    if ($this->sellIn < 11) {
                        if ($this->quality < 50) {
                            $this->quality = $this->quality + 1;
                        }
                    }
                    if ($this->sellIn < 6) {
                        if ($this->quality < 50) {
                            $this->quality = $this->quality + 1;
                        }
                    }
                }
            }
        }

        if ($this->name != static::SULFURAS) {
            $this->sellIn = $this->sellIn - 1;
        }

        if ($this->sellIn < 0) {
            if ($this->name != static::AGED_BRIE) {
                if ($this->name != static::BACKSTAGE_PASSES) {
                    if ($this->quality > 0) {
                        if ($this->name != static::SULFURAS) {
                            $this->quality = $this->quality - 1;
                        }
                    }
                } else {
                    $this->quality = $this->quality - $this->quality;
                }
            } else {
                if ($this->quality < 50) {
                    $this->quality = $this->quality + 1;
                }
            }
        }
    }
}