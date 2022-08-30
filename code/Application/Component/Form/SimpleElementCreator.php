<?php

declare(strict_types=1);

namespace App\Application\Component\Form;

use App\Application\Component\FormComponent\FormComponent;
use App\Application\Component\FormComponent\SimpleFormElement;
use App\Application\Component\FormComponent\Validator\ValidatorInterface;

class SimpleElementCreator extends ElementCreator
{
    public function factoryMethod(string $data = null, ?ValidatorInterface $validator = null): FormComponent
    {
        return new SimpleFormElement($data, $validator);
    }
}