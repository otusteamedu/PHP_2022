<?php

namespace Ppro\Hw27\App\Entity;

interface DtoInterface
{
    public function validate();
    public function toJson():string;
}