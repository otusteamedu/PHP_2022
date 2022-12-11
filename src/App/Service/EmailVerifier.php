<?php

declare(strict_types=1);

namespace App\App\Service;

/**
 * Сервис для определения корректности email адреса
 */
class EmailVerifier
{
    /**
     * Базовый паттерн для проверки корректности email адреса
     */
    private const PATTERN = '/^.+\@\S+\.\S+$/';
    /**
     * Возвращает true, если переданный email - корректный
     */
    public static function verify(string $email): bool
    {
        $result = \preg_match(self::PATTERN, $email);

        // если результат = false, то произошла ошибка (см. документацию)
        if ($result === false) {
            throw new \RuntimeException('Ошибка при проверке email адреса');
        }

        return (bool) $result;
    }
}