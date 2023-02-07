<?php

namespace app\validators;

class DateValidator implements ValidatorInterface
{
    private string $date;
    private string $error;

    public function __construct(string $date) {
        $this->date = $date;
    }

    public function validate(): bool {
        if (empty($this->date)) {
            $this->error = 'Вы забыли заполнить дату'; return false;
        }

        if (!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$this->date)) {
            $this->error = 'Неправильно заполнена дата'; return false;
        }

        return true;
    }

    public function getError(): string {
        return $this->error;
    }
}
