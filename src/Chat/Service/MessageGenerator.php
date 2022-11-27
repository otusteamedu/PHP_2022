<?php

declare(strict_types=1);

namespace App\Chat\Service;

class MessageGenerator
{
    private const PERSONS = [
        'Мистер Бин',
        'Губка Боб',
        'Капитан Америка',
        'Павлик Морозов',
        'Павлик Морозов',
        'Чебурашка',
        'Кот Бегемот',
    ];

    private const HELLO = [
        'Привет',
        'Салам',
        'Барэв',
        'Шломо',
        'Чао',
        'Ола',
        'Салют',
    ];

    private const ACTIONS = [
        'Копает',
        'Кодит',
        'Апчихает',
        'Берет',
        'Водит',
        'Думает',
        'Икает',
        'Вспоминает',
        'Летит',
        'Юлит',
        'Решает',
        'Пропускает',
        'Орет',
    ];

    private const SUBJECTS = [
        'Слона',
        'Яму',
        'Афганистан',
        'Первый класс',
        'Кухню',
        'Новый год',
        'Хоровод',
        'Самолет',
        'Тучу',
    ];

    public static function makeGreeting(): string
    {
        return \sprintf('%s, %s!', Arr::randomValue(self::HELLO), Arr::randomValue(self::PERSONS));
    }

    public static function makeAction(): string
    {
        return \sprintf('%s %s %s', Arr::randomValue(self::PERSONS), Arr::randomValue(self::ACTIONS), Arr::randomValue(self::SUBJECTS));
    }
}