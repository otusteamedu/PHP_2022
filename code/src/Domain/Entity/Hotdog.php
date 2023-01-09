<?php


namespace Study\Cinema\Domain\Entity;

use Study\Cinema\Infrastructure\Food;

class Hotdog implements Food
{
    private string $base;
    private string $sausage;

    public function cook(string $base, string $sausage)
    {
        $this->setBase($base);
        $this->setSausage($sausage);
    }

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
    public function getSausage(): string
    {
        return $this->sausage;
    }

    /**
     * @param string $sausage
     */
    public function setSausage(string $sausage): void
    {
        $this->sausage = $sausage;
    }
    public function __toString()
    {

        return "Hotdog base: $this->base,  sausage: $this->sausage";
    }

}