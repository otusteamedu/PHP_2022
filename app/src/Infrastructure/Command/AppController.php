<?php

namespace app\Infrastructure\Command;

use app\Application\ProcessManagerService;


class AppController {
    private string $processName;

    public function __construct() {
        $this->processName = $_SERVER['argv'][1];
    }

    public function run(): void {
        try {
            $fileName = $this->getSocketFilename($this->processName);
            $serverFileName = $this->getSocketFilename('server');
            $this->rmOldFile($fileName);
            $process = (new ProcessManagerService())->createService($this->processName, $fileName, $serverFileName);
            $process->run($fileName);
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    private function getSocketFilename($suffix): string {
        $dir = parse_ini_file(__DIR__ . '/../../../config/sockets.ini');

        if (empty($dir['socket_dir'])) {
            throw new \Exception('Отсутствует настройка директории socket файла');
        }
        return $dir['socket_dir'] . '/'.$suffix.'.sock';
    }

    private function rmOldFile($fileName) {
        if (file_exists($fileName)) unlink($fileName);
    }

}
