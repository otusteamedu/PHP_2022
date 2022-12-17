<?php

namespace app\models;

abstract class Model {
    public array $errors = [];

    public function __construct(array $from = []) {
        foreach ($from as $key => $value) {
            $this->$key = $value;
        }
    }

    public function save() {
        return false;
    }

    public function validate(): bool {
        return true;
    }

    public function find(array $conditions) {}

    public function deleteAll() {}

}
