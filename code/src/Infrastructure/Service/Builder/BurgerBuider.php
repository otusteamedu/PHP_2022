<?php

namespace Study\Cinema\Infrastructure\Service\Builder;

use Study\Cinema\Domain\Entity\Burger;
use Study\Cinema\Domain\Interface\FoodBuilder;

class BurgerBuider implements FoodBuilder
{
    private Burger $burger;
    private bool $tomato;
    private bool $onion;


    public function __construct(Burger $burger)
    {
        $this->burger = $burger;
    }

    /**
     * @param bool $tomato
     * @return BurgerBuider
     */
    public function setTomato(bool $tomato): BurgerBuider
    {
        $this->burger->tomato = $tomato;
        return $this;
    }

    /**
     * @return bool
     */
    public function isOnion(): bool
    {
        return $this->onion;
    }

    /**
     * @param bool $onion
     * @return BurgerBuider
     */
    public function setOnion(bool $onion): BurgerBuider
    {
        $this->burger->onion = $onion;
        return $this;
    }


    public function build()
    {
        return $this->burger;
    }




}