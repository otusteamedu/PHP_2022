<?php

namespace App\Validator;

use App\FileManager\FileManager;
use App\Validator\Contracts\ValidatorInterface;
use App\Validator\Providers\EmailValidator;

class ValidatorFactory
{

    public static function create(ValidatorInterface $validator): Validator
    {
        $fileManager = new FileManager();

        return new Validator($fileManager, $validator);
    }


    public static function createByEmail(): Validator
    {
        return static::create(new EmailValidator());
    }
}
