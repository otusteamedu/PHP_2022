<?php

namespace app;

class Controller {
    private string $index;
    private string $action;
    private array $params;

    public function __construct() {
        $this->processQuery();
    }

    public function run(): string {
        $className = 'app\\actions\\'.ucfirst(strtolower($this->action)).'Action';
        try {
            $action = new $className($this->index, $this->params);
        } catch (\Throwable $e) {
            if (preg_match('/^Class .+ not found$/', $e->getMessage())) {
                return 'Действие '.$this->action.' не поддерживается.'.PHP_EOL;
            } else throw new \Exception($e->getMessage());
        }

        return $action->execute();
    }

    private function processQuery(): void {
        $argv = $_SERVER['argv'];
        if (!isset($argv[1])) throw new \Exception('Не указан индекс.');
        elseif (!isset($argv[2])) throw new \Exception('Не указано действие.');

        $this->index = $argv[1];
        $this->action = $argv[2];
        $this->params = array_slice($argv, 3) ?? [];
    }

}
