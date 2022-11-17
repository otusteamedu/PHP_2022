<?php

namespace app\models;

use app\validators\EmailValidator;

class EmailForm {
    private string $inputStr = '';
    private array $errors = [];

    public function loadPOSTData() {
        $this->inputStr = $_POST['emails'];
    }

    public function validate(): bool {
        $strings = explode("\n", $this->inputStr);
        foreach ($strings as $str) {
            $str = trim($str);
            if (empty($str)) continue; // пустые строки игнорируем
            $validator = new EmailValidator($str);
            if (!$validator->validate()) {
                $this->errors[] = $validator->getError();
            }
        }
        return empty($this->errors);
    }

    public function getErrors(): array {
        return $this->errors;
    }
}
