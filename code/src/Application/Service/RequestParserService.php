<?php

declare(strict_types=1);

namespace Cookapp\Php\Application\Service;

use Cookapp\Php\Application\Dto\DishDto;

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
                if ($argValues[0] === 'ingredient') {
                    $dishDto->ingredients[] = $argValues[1];
                } else {
                    $dishDto->{$argValues[0]} = $argValues[1];
                }
            } else {
                throw new \Exception('Illegal argument: "' . $argValues[0] . '", allowed values: ' .  implode(", ", self::ALLOWED_ARGV));
            }
        }

        return $dishDto;
    }
}