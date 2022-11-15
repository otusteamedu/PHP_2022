<?php

namespace app\validators;

class EmailValidator {
    private string $email;
    private string $pattern = '/^[A-Z0-9._%+-]+@[A-Z0-9-]+.+.[A-Z]{2,4}$/i';
    private string $error;

    public function __construct(string $email) {
        $this->email = $email;
    }

    public function validate(): bool {
        $this->validateValue();
        if (empty($this->error)) {
            $this->validateDns();
        }
        return empty($this->error);
    }

    private function validateDns() {
        $arr = explode("@", $this->email);
        if (!checkdnsrr($arr[1], 'MX')) {
            $this->error = 'Не найдена MX запись для доменного имени '.$arr[1];
        }
    }

    private function validateValue() {
        if (!preg_match($this->pattern, $this->email)) {
            $this->error = $this->email.' не является правильным email адресом.';
        }
    }

    public function getError(): string {
        return $this->error;
    }

}
