<?php

namespace app\storages;

use Predis\Client;

trait Redis {
    public Client $client;

    public function setStorageClient(): void {
        $this->client = new Client([
            'host'   => $_ENV['REDIS_HOST'],
            'port'   => $_ENV['REDIS_PORT'],
            'password' => $_ENV['REDIS_PASSWORD'],
        ]);
    }
}
