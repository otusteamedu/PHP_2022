<?php

declare(strict_types=1);

namespace Nikolai\Php\Application\Service;

use Nikolai\Php\Application\Dto\DishDto;

class RequestParserService
{
    private const DELIMITER = '=';
    private const ALLOWED_ARGV = [
        'dish',
        'recipe',
        'ingredient'
    ];

    public function createDishDto(array $argv): DishDto
    {
        $dishDto = new DishDto();

        foreach ($argv as $arg) {
            $argValues = explode(self::DELIMITER, $arg);

            if (in_array($argValues[0], self::ALLOWED_ARGV)) {
                if ($argValues[0] === self::ALLOWED_ARGV[2]) {
                    $dishDto->ingredients[] = $argValues[1];
                } else {
                    $dishDto->{$argValues[0]} = $argValues[1];
                }
            } else {
                throw new \Exception('Не допустимый аргумент: ' . $argValues[0]);
            }
        }

        return $dishDto;
    }
}