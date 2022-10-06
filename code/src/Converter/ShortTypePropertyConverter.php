<?php

declare(strict_types=1);

namespace Nikolai\Php\Converter;

use Nikolai\Php\Exception\ConverterException;

class ShortTypePropertyConverter extends AbstractTypePropertyConverter
{
    const ALLOWED_RELATIONS = [
        'eq',
        'gt',
        'gte',
        'lt',
        'lte'
    ];

    public function convert(): array
    {
        if (!in_array($this->item[1], self::ALLOWED_RELATIONS)) {
            throw new ConverterException('Недопустимое отношение: ' . $this->item[1]);
        }

        if (isset($this->item[3])) {
            if (!in_array($this->item[3], self::ALLOWED_RELATIONS)) {
                throw new ConverterException('Недопустимое отношение: ' . $this->item[3]);
            }

            $conditions = [
                $this->item[0] => [
                    $this->item[1] => $this->item[2],
                    $this->item[3] => $this->item[4]
                ]
            ];
        } else {
            $conditions = [
                $this->item[0] => [
                    $this->item[1] => $this->item[2]
                ]
            ];
        }

        return [
            "range" => $conditions
        ];
    }
}