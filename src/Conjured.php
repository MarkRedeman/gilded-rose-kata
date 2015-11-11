<?php

namespace Kata;

class Conjured extends Normal implements Item
{
    public function tick()
    {
        $this->decreaseSellIn();

        $amount = ($this->sellDateExpired()) ? 2 : 1;

        // Conjured items degrade twice as fast
        $this->decradeQuality(2 * $amount);
    }
}