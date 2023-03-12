<?php

namespace Ppro\Hw27\App\Entity;

use Ppro\Hw27\App\Exceptions\AppException;
use Ppro\Hw27\App\Exceptions\BadFormRequestException;
use Ppro\Hw27\App\Validators\Validator;

class FormDto implements DtoInterface
{
    public readonly string $name;
    public readonly string $email;
    public readonly string $date;

    public function __construct(array $formData, Validator $validator) {
        $this->name = $formData['name'];
        $this->email = $formData['email'];
        $this->date = $formData['date'];
        $this->validator = $validator;
    }

    public function validate()
    {
        $errors = $this->validator->validate($this);
        if (count($errors) > 0)
            throw new BadFormRequestException(json_encode($errors));
    }

    public function toJson():string
    {
        return json_encode([
          'name' => $this->name,
          'email' => $this->email,
          'date' => $this->date,
        ]);
    }
}