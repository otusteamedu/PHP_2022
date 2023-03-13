<?php

namespace Ppro\Hw27\Consumer\Entity;

interface DtoInterface
{
    public function toJson():string;
    public function validate();

}