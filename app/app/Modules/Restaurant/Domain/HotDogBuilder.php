<?php

declare(strict_types=1);

namespace App\Modules\Restaurant\Domain;

use App\Modules\Restaurant\Domain\Ingredients\HotDogBun;
use App\Modules\Restaurant\Domain\Ingredients\Onion;
use App\Modules\Restaurant\Domain\Ingredients\Sauce;
use App\Modules\Restaurant\Domain\Ingredients\Sausage;
use Exception;

class HotDogBuilder
{
    private ?HotDogBun $bun = null;
    private ?Sausage $sausage = null;
    private ?Onion $onion = null;
    private ?Sauce $sauce = null;

    /**
     * @throws Exception
     */
    public function __get($name)
    {
        if (!property_exists($this, $name)) {
            throw new Exception("Атрибут {$name} отсутствует");
        }
        return $this->$name;
    }

    public function setBun(HotDogBun $bun): HotDogBuilder
    {
        $this->bun = $bun;
        return $this;
    }

    public function setSausage(Sausage $sausage): HotDogBuilder
    {
        $this->sausage = $sausage;
        return $this;
    }

    public function setOnion(Onion $onion): HotDogBuilder
    {
        $this->onion = $onion;
        return $this;
    }

    public function setSauce(Sauce $sauce): HotDogBuilder
    {
        $this->sauce = $sauce;
        return $this;
    }

    public function make(): HotDog
    {
        return new HotDog($this);
    }
}
