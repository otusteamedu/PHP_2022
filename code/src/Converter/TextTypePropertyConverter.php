<?php

declare(strict_types=1);

namespace Nikolai\Php\Converter;

class TextTypePropertyConverter extends AbstractTypePropertyConverter
{
    public function convert(): array
    {
        return [
            "match" => [
                $this->item[0] => [
                    'query' => str_replace('+', ' ', $this->item[1]),
                    "fuzziness" => "auto"
                ]
            ]
        ];
    }
}