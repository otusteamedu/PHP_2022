<?php

namespace app\actions;

abstract class Action {
    public string $index;
    public array $params;

    public function __construct($index, $params = []) {
        $this->params = $params;
        $this->index = $index;
    }

    public function execute() {}
    public function pretty($result):string {
        return var_export($result, 1);
    }
}
