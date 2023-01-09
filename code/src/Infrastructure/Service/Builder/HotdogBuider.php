<?php

namespace Study\Cinema\Infrastructure\Service\Builder;

use Study\Cinema\Domain\Entity\Hotdog;
use Study\Cinema\Domain\Interface\FoodBuilder;

class HotdogBuider implements FoodBuilder
{
    private Hotdog $hotdog;
    private bool $tomato;
    private bool $tomato_sauce;


    public function __construct(Hotdog $hotdog)
    {
        $this->hotdog = $hotdog;
    }

        public function setTomato(bool $tomato): HotdogBuider
    {
        $this->hotdog->tomato = $tomato;
        return $this;
    }

    public function setTomatoSauce(bool $tomato_sauce): HotdogBuider
    {
        $this->hotdog->tomato_sauce = $tomato_sauce;
        return $this;
    }

    public function build()
    {
        return $this->hotdog;
    }




}