<?php
namespace app;

class App {
    private string $process;

    public function __construct() {
        $this->process = $_SERVER['argv'][1];
    }

    /**
     * @throws \Exception
     */
    public function run() {
        switch ($this->process) {
            case 'server':
                (new Server())->run();
                break;
            case 'client':
                (new Client())->run();
                break;
            default:
                throw new \Exception('Неверно задан процесс: '.$this->process. '. Допустимые значения: server, client.');
        }
    }

}
