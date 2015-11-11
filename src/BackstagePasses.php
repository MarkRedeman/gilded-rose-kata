<?php

namespace Kata;

class BackstagePasses extends Normal implements Item
{
    // These constants denote the sellIn days for which quality triples, doubles, or is lost
    const TRIPLE_INCREASE = 5;
    const DOUBLE_INCREASE = 10;
    const LOSE_QUALITY = 0;

    public function tick()
    {
        $this->decreaseSellIn();

        $this->improveQuality(
            $this->qualityIncrease()
        );
    }

    private function qualityIncrease()
    {
        if ($this->sellDateExpired())
        {
            return - $this->quality;
        }
        if ($this->sellIn < static::TRIPLE_INCREASE)
        {
            return 3;
        }
        if ($this->sellIn < static::DOUBLE_INCREASE)
        {
            return 2;
        }
        return 1;
    }
}