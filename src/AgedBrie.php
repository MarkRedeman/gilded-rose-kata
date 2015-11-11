<?php

namespace Kata;

class AgedBrie extends Normal implements Item
{
    public function tick()
    {
        $this->decreaseSellIn();

        $amount = ($this->sellDateExpired()) ? 2 : 1;
        $this->improveQuality($amount);
    }
}