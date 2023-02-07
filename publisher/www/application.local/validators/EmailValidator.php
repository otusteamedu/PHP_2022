<?php

namespace app\validators;

class EmailValidator implements ValidatorInterface {
    private string $email;
    private string $pattern = '/^[a-zA-Z0-9!#$%&\'*+\\/=?^_`{|}~-]+(?:\.[a-zA-Z0-9!#$%&\'*+\\/=?^_`{|}~-]+)*@(?:[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?\.)+[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?$/';
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
            $this->error = 'Не найдена MX запись для доменного имени.';
        }
    }

    private function validateValue() {
        if (!preg_match($this->pattern, $this->email)) {
            $this->error = 'Не является правильным email адресом.';
        }
    }

    public function getError(): string {
        return $this->error;
    }

}
