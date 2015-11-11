<?php

namespace Kata;

class BackstagePasses extends Normal implements Item
{
    public function tick()
    {
        $this->increaseQuality();
        if ($this->sellIn < 11) {
            $this->increaseQuality();
        }
        if ($this->sellIn < 6) {
            $this->increaseQuality();
        }

        $this->decreaseSellIn();

        if ($this->sellDateExpired()) {
            $this->quality = 0;
        }
    }
}