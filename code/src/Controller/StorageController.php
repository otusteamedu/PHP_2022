<?php

declare(strict_types=1);

namespace Otus\App\Controller;

use JsonException;
use Otus\App\App;
use Otus\App\Model\Redis;
use Otus\App\Model\Memcached;

class StorageController
{
    protected Redis $storage;
    //protected Memcached $storage;

    public function __construct()
    {
        $config = App::getConfig();

        if (!isset($config['repository']['storage'])) {
            throw new \RuntimeException(
                'No storage was chosen. Check config.php.'
            );
        }

        switch ($config['repository']['storage']) {
            case 'redis':
            default:

                if (!isset($config['repository']['redis_host'],
                            $config['repository']['redis_port'],
                            $config['repository']['redis_pass'])) {
                    throw new \RuntimeException('No Redis settings in config.php');
                }

                return $this->storage = new Redis();

            case 'memcached':

                if (!isset($config['repository']['memcached_host'],
                            $config['repository']['memcached_port'])) {
                    throw new \RuntimeException('No Memcached settings in config.php');
                }

                return $this->storage = new Redis();
                //return $this->storage = new Memcached();
        }
    }

    public function saveEvent($event): bool
    {
        return $this->storage->saveEvent($event);
    }

    public function deleteEvents(string $key): bool
    {
        return $this->storage->deleteEvents($key);
    }

    public function getEvent($params): array
    {
        return $this->storage->getEvent($params);
    }

}
