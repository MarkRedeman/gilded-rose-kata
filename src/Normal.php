<?php

namespace Kata;

class Normal implements Item {

    const MAX_QUALITY = 50;
    const MIN_QUALITY = 0;

    public $sellIn;
    public $quality;

    public function __construct($quality, $sellIn)
    {
        $this->quality = $quality;
        $this->sellIn = $sellIn;
    }

    public function tick()
    {
        $this->decreaseSellIn();

        $amount = ($this->sellDateExpired()) ? 2 : 1;
        $this->decreaseQuality($amount);
    }

    protected function decreaseSellIn()
    {
        $this->sellIn = $this->sellIn - 1;
    }

    protected function decreaseQuality($amount = 1)
    {
        $this->quality = max(static::MIN_QUALITY, $this->quality - $amount);
    }

    protected function increaseQuality($amount = 1)
    {
        $this->quality = min(static::MAX_QUALITY, $this->quality + $amount);
    }

    protected function sellDateExpired()
    {
        return $this->sellIn < 0;
    }
}