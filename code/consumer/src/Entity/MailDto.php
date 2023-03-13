<?php

namespace Ppro\Hw27\Consumer\Entity;

use Ppro\Hw27\Consumer\Exceptions\InvalidMailDataException;
use Ppro\Hw27\Consumer\Validators\Validator;

class MailDto implements DtoInterface
{
    /**
     * @var string|mixed
     */
    public readonly string $name;
    /**
     * @var string|mixed
     */
    public readonly string $email;
    /**
     * @var string|mixed
     */
    public readonly string $msg;

    /**
     * @param array $formData
     * @param Validator $validator
     */
    public function __construct(array $formData, Validator $validator) {
        $this->name = $formData['name'];
        $this->email = $formData['email'];
        $this->msg = $formData['msg'];
        $this->validator = $validator;
    }

    /**
     * @return void
     * @throws InvalidMailDataException
     */
    public function validate()
    {
        $errors = $this->validator->validate($this);
        if (count($errors) > 0)
            throw new InvalidMailDataException(json_encode($errors));
    }

    /**
     * @return string
     */
    public function toJson():string
    {
        return json_encode([
          'name' => $this->name,
          'email' => $this->email,
          'msg' => $this->msg,
        ]);
    }
}