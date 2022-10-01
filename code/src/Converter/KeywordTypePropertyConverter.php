<?php

declare(strict_types=1);

namespace Nikolai\Php\Converter;

class KeywordTypePropertyConverter extends AbstractTypePropertyConverter
{
    public function convert(): array
    {
        return [
            "term" => [
                $this->item[0] => str_replace('+', ' ', $this->item[1])
            ]
        ];
    }
}