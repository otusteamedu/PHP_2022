<?php

namespace App\Validator;

use Doctrine\DBAL\Types\Types;
use Symfony\Component\Validator\Constraints as Assert;

class EventValidator extends AbstractValidator
{
    protected function rules(): Assert\Collection
    {
        return new Assert\Collection([
            'name' => [
                new Assert\NotBlank(),
                new Assert\Type(Types::STRING),
                new Assert\Length(min: 2, max: 30),
            ],
            'priority' => [
                new Assert\NotBlank(),
                new Assert\Range(['min' => 1, 'max' => 10 * 1000]),
            ],
            'conditions' => [
                new Assert\NotBlank(),
                new Assert\Type(Types::ARRAY),
                new Assert\Count(['min' => 1, 'max' => 20]),
                new Assert\All([
                    new Assert\NotBlank,
                    new Assert\Collection([
                        'name' => [
                            new Assert\NotBlank(),
                            new Assert\Type(['type' => 'string']),
                            new Assert\Regex("/[a-z0-9]+/i", 'only letters and numbers'),
                        ],
                        'value' => [
                            new Assert\NotBlank(),
                            new Assert\Type(['type' => 'string']),
                            new Assert\Regex("/[a-z0-9]+/i", 'only letters and numbers'),
                        ],
                    ]),
                ]),
            ],
            'event' => [
                new Assert\NotBlank(),
                new Assert\Range(['min' => 1, 'max' => 10 * 1000]),
            ],
        ]);
    }
}