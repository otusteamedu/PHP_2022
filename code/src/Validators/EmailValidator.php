<?php

declare(strict_types=1);

namespace Ekaterina\Hw5\Validators;

use RuntimeException;

class EmailValidator
{
    /**
     * Тексты ошибок при валидации файлов
     */
    private const ERROR_FORMAT = 'неверный формат email-адреса';
    private const ERROR_DOMEN = 'почтовый домен не существует';

    /**
     * @var array Исходный массив email-адресов, который нужно проверить
     */
    private array $sourceEmails;

    /**
     * @var array Сохраненные проверенные домены с результатом проверки, чтобы не гонять на проверку одни и те же
     */
    private array $cacheDomains = [];

    /**
     * @var array Массив результатов валидации
     */
    private array $results = [];

    /**
     * Constructor
     *
     * @param array|null $arEmails
     */
    public function __construct(?array $arEmails = null)
    {
        $this->sourceEmails = $arEmails ?? [];
        $this->validate();
    }

    /**
     * Результат валидации
     *
     * @return array
     */
    public function getResults(): array
    {
        return $this->results;
    }

    /**
     * Валидация массива email-адресов
     *
     * @return void
     */
    private function validate(): void
    {
        if (empty($this->sourceEmails)) {
            throw new RuntimeException('Отсутствуют email-адреса дя проверки');
        }

        foreach ($this->sourceEmails as $email) {
            if (!$this->isEmailFormat($email)) {
                $this->results[$email] = ['valid' => false, 'description' => self::ERROR_FORMAT];
            } elseif (!$this->isExistDomain($email)) {
                $this->results[$email] = ['valid' => false, 'description' => self::ERROR_DOMEN];
            } else {
                $this->results[$email] = ['valid' => true];
            }
        }
    }

    /**
     * Проверка формата email-адреса
     *
     * @param string $email
     * @return bool
     */
    private function isEmailFormat(string $email): bool
    {
        return !empty(filter_var($email, FILTER_VALIDATE_EMAIL));
    }

    /**
     * Проверка на существование MX записи для домена email-адреса
     *
     * @param string $email
     * @return bool
     */
    private function isExistDomain(string $email): bool
    {
        $arData = explode('@', $email);
        if (array_key_exists($arData[1], $this->cacheDomains)) {
            return $this->cacheDomains[$arData[1]];
        }

        $this->cacheDomains[$arData[1]] = checkdnsrr($arData[1]);
        return $this->cacheDomains[$arData[1]];
    }
}