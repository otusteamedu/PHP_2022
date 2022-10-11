<?php

declare(strict_types=1);

namespace Nikolai\Php\Application\RequestConverter;

use Nikolai\Php\Infrastructure\Exception\ConverterException;
use Symfony\Component\HttpFoundation\Request;

class RequestConverter implements RequestConverterInterface
{
    const CLASS_POSTFIX = 'ArgumentConverter';

    public function convert(Request $request): array
    {
        $result = [];

        $arguments = array_slice($request->server->get('argv'), 2);

        foreach ($arguments as $item) {
            $argument = explode('=', $item);
            try {
                $classArgumentConverter = __NAMESPACE__ . '\\' . ucfirst($argument[0]) . self::CLASS_POSTFIX;
                $result[$argument[0]] = (new $classArgumentConverter)->convert($argument[1]);
            } catch (\Throwable $exception) {
                throw new ConverterException('Недопустимый аргумент: ' . $argument[0] . PHP_EOL);
            }
        }

        return $result;
    }
}