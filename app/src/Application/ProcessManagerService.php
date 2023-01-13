<?php

namespace app\Application;

use app\Domain\Process\ChatClientService;
use app\Domain\Process\ChatProcessInterface;
use app\Domain\Process\ChatServerService;

class ProcessManagerService implements ProcessManagerInterface {

    public function createService(string $serviceName, string $fileName, string $serverFileName): ChatProcessInterface {
        switch ($serviceName) {
            case 'server': return new ChatServerService($fileName, $serverFileName);
            case 'client': return new ChatClientService($fileName, $serverFileName);
            default:
                throw new \Exception('Неверно задан процесс: '.$serviceName. '.');
        }
    }
}
