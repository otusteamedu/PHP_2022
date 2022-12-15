<?php

namespace app\actions;

use app\models\ModelInterface;

abstract class Action {
    public string $index;
    public array $params;
    public ModelInterface $model;

    public function __construct(string $index, ModelInterface $model, $params = []) {
        $this->params = $params;
        $this->index = $index;
        $this->model = $model;
    }

    public function execute() {}
}
