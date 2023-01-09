<?php


namespace Study\Cinema\Domain\Entity;

use Study\Cinema\Infrastructure\Food;

class Burger implements Food
{

    private string $base;
    private string $cutlet;

    public bool $tomato = false;
    public bool $onion = false;

    //private $tomato;
/*
    public function cook(string $base, string $cutlet)
    {
        $this->setBase($base);
        $this->setCutlet($cutlet);
    }
*/
    /**
     * @return string
     */
    public function getBase(): string
    {
        return $this->base;
    }

    /**
     * @param string $base
     */
    public function setBase(string $base): void
    {
        $this->base = $base;
    }

    /**
     * @return string
     */
    public function getCutlet(): string
    {
        return $this->cutlet;
    }

    /**
     * @param string $cutlet
     */
    public function setCutlet(string $cutlet): void
    {
        $this->cutlet = $cutlet;
    }
    public function __toString()
    {

        return "Burger base: $this->base,  cutlet: $this->cutlet ,  tomato: $this->tomato,  onion: $this->onion";
    }

}