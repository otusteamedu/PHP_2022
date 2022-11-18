<?php

declare(strict_types=1);

class EmailValidator {

    private $emails = [];

    // Валидатор email адресов
    public function validate(): array
    {
        $result = [];
        foreach ($this->emails as $email) {
            $string = $this->prepareString($email);

            if (!$this->checkValidEmail($string)) {
                $result[] = $email.' - is invalid';
                continue;
            }

            $hostname = $this->getHostname($string);
            if (!$this->checkMx($hostname)) {
                $result[] = $email.' - is invalid';
                continue;
            }

            $result[] = $email.' - valid email';
        }
        return $result;
    }

    // Получение списка email адресов
    public function setEmails(array $emails) {
        $this->emails = $emails;
        return $this;
    }

    // Подготовка строки
    private function prepareString(string $string): string
    {
        return mb_strtolower(trim($string));
    }

    // Проверка строки на email
    private function checkValidEmail(string $string): bool
    {
        return (bool) preg_match('/^\S+@\S+\.\S+$/', $string);
    }

    // Получение имени хоста
    private function getHostname(string $email): string
    {
        return preg_replace('/^.*@/', '', $email);
    }

    // Проверка MX записи
    private function checkMx(string $hostname): bool
    {
        if (function_exists('checkdnsrr')) {
            if (!checkdnsrr($hostname, "MX")) {
                return false;
            }
        }
        return true;
    }

}

$emails = [
    'artem@agsys2.ru',
    'artem@agsys.ru',
    'artem@bp-l.ru',
    'artem@yandex',
    'artem@yan.dex',
];

$result = (new EmailValidator())->setEmails($emails)->validate();
print_r($result);
