<?php

namespace App\Validator;

use App\FileManager\FileManager;
use App\Validator\Interfaces\ValidatorInterface;
use App\Validator\Providers\EmailValidator;

class ValidatorFactory
{
    /**
     * create
     *
     * @param  mixed $validator
     * @return Validator
     */
    public static function create(ValidatorInterface $validator): Validator
    {
        $fileManager = new FileManager();

        return new Validator($fileManager, $validator);
    }

    
    /**
     * createByEmail
     *
     * @return Validator
     */
    public static function createByEmail(): Validator
    {
        return static::create(new EmailValidator());
    }
}