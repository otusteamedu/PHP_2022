<?php

declare(strict_types=1);

namespace App\Application\Component\FormComponent;

use App\Application\Component\FormComponent\Validator\ValidatorInterface;

class SimpleFormElement extends FormComponent
{
    public function __construct(private readonly string $data, private readonly ?ValidatorInterface $validator = null)
    {
    }

    public function value(): string
    {
        return $this->data;
    }

    public function process(): void
    {
        $this->validator?->validate($this->data);
    }
}