<?php

declare(strict_types=1);

namespace App\Provider;

use InvalidArgumentException;

final class ProviderFactory
{
    public static function createProvider(array $config): ProviderInterface
    {
        return match ($config['db']['provider']) {
            'elastic' => new ElasticProvider($config['elastic']),
            default => throw new InvalidArgumentException('Unknown provider name given'),
        };
    }
}
