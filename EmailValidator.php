<?php

declare(strict_types=1);

/**
 * Валидотор email
 */
class EmailValidator
{
    private string $error = '';

    private array $blackList = [
        'qwerty',
        'test',
        'admin',
        'administrator',
    ];

    public function validate(string $email): bool
    {
        $emailArray = \explode("@", $email);
        if ((2 === \count($emailArray))
            && $this->checkEmail($email)
            && $this->checkDomain(\array_pop($emailArray))
            && $this->checkToBlackList(\array_pop($emailArray))
        ) {
            $this->error = '';
            return true;
        }

        $this->error = 'Введён не корректный email.';
        return false;
    }

    /**
     * @return string
     */
    public function getError(): string
    {
        return $this->error;
    }

    /**
     * Проверка почты фильтром
     * @param string $email
     * @return bool
     */
    private function checkEmail(string $email): bool
    {
        return \filter_var($email, FILTER_VALIDATE_EMAIL) && \preg_match("/^[a-zA-Z0-9_.-]+@[a-zA-Z0-9-]+.[a-zA-Z0-9-.]+$/", $email);
    }

    /**
     * Проверка домена почты
     * @param string $domain
     * @return bool
     */
    private function checkDomain(string $domain): bool
    {
        if (\checkdnsrr($domain)) {
            return true;
        }

        return false;
    }

    /**
     * Проверка имени почты на недопустимое имя
     * @param string $name
     * @return bool
     */
    private function checkToBlackList(string $name): bool
    {
        if (\in_array($name, $this->blackList, true)) {
            return true;
        }

        return false;
    }
}
