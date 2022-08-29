<?php

declare(strict_types=1);

namespace App\Application\Component\Form;

use App\Application\Component\FormComponent\ComplexFormElement;
use App\Application\Component\FormComponent\FormComponent;

class ComplexElementCreator extends ElementCreator
{
    public function factoryMethod(): FormComponent
    {
        return new ComplexFormElement();
    }
}