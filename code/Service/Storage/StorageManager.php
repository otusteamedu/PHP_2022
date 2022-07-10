<?php

declare(strict_types=1);

namespace App\Service\Storage;

use RuntimeException;

class StorageManager
{
    public function getStorage(array $options): StorageInterface
    {
        if (!isset($options['app.events']['storage'])) {
            throw new RuntimeException(
                'No storage was chosen. You need to provide app.events.storage in your settings.'
            );
        }

        switch ($options['app.events']['storage']) {
            case 'redis':
            default:

                if (!isset($options['redis']['host'])) {
                    throw new RuntimeException('No redis settings in config.ini');
                }

                return new RedisStorage(['host' => $options['redis']['host']]);

            case 'memcached':

                if (!isset($options['memcached']['host'])) {
                    throw new RuntimeException('No memcached settings in config.ini');
                }

                return new MemcachedStorage(['host' => $options['redis']['host']]);
        }
    }
}