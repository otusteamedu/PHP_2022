<?php

declare(strict_types=1);

namespace App\Application\Component\Form;

use App\Application\Component\FormComponent\FormComponent;
use App\Application\Component\FormComponent\Validator\ValidatorInterface;

abstract class ElementCreator
{
    abstract public function factoryMethod(): FormComponent;

    public function newTreeElement(?string $data = null, ?ValidatorInterface $validator = null): FormComponent
    {
        return $this->factoryMethod($data, $validator);
    }
}