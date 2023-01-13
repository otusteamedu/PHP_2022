<?php

namespace app\Application;

use app\Domain\Process\ChatProcessInterface;

interface ProcessManagerInterface {
    public function createService(string $serviceName, string $fileName, string $serverFileName): ChatProcessInterface;
}
